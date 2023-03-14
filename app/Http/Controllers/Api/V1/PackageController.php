<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\UserPackages;
use Carbon\Carbon;
use DateTime;
use Spatie\FlareClient\Api;
use App\Models\UserTransactions;

class PackageController extends Controller
{
  /**
   * Package DropDown.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

      $package = package::with('features')->where('status',1)->select('id','name','image', 'price', 'invoice_period', 'invoice_interval')->get();
      if(auth()->check()){
        $package=$package->map(function($items){
            $subscription=\App\Models\PackageSubscription::where([
                                                    'subscriber_type'=>get_class(auth()->user()),
                                                    'subscriber_id'=>auth()->id(),
                                                    'package_id'=>$items->id
                                                ])->first();
            $items->subscribed=$subscription?1:0;
            $items->subscription_id=$subscription->id??0;
            $items->active= auth()->user()->subscribedTo($items);
            return $items;
        });
      }
      if(!$package){
          return response()->json(['error'=>true, 'package'=>$package],422);
      }
      return response()->json(['success'=>true, 'package'=>$package],200);
  }

  public function package_subscription(){
    //$packages=User::find(auth()->id())->activePackageSubscriptions();
     $packages =PackageSubscription::where('subscriber_type',get_class(auth()->user()))->where('subscriber_id',auth()->id())
                            // ->whereNotNull('ends_at')
                            ->whereDate('ends_at','>', Carbon::now())
                            ->latest()->get();
    if(!$packages->count() > 0){
        return response()->json([
            'error'=>true,
            'message'=>'No package found!'
        ],422);
    }

    if($packages->count()>0){
        $packages=$packages->map(function($items){
            $items->package=\App\Models\Package::find($items->package_id);
            return [
                'package_id'=>$items->package_id,
                'image'=>$items->image,
                'name'=>$items->package->name,
                'description'=>$items->package->description,
                'price'=>$items->package->price,
                'starts_at'=>$items->starts_at,
                'ends_at'=>$items->ends_at,
                'active'=>$items->active(),
                'subscriber_id'=>$items->subscriber_id,
                'id'=>$items->id
            ];
        });
    }
    return response()->json($packages);
  }


  /**
   * Package selection stored here.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request){
    // Important points
    // In this function, when customer click on any of the package in app while purchasing it.
    // Then, api will be hit to this function to store the selected package in table, and in return on 200 status code app will goto the payment screen for further process
    // Also, customer can go back to package selection screen, if customer  want to select any new package.
    // Then again new record will be created in table.
    // when payment is successfull then, this record will be updated by start and end date for subscription

    $this->validate($request,[
        'package_id'=>'required'
    ]);
    $user=User::find(auth()->id());
    //delete existing package if expired
    // $expired_subscription=PackageSubscription::where('subscriber_type',get_class($user))->where('subscriber_id',$user->id)->where('ends_at','<',now())->update(['deleted_at'=>now()]);
    //to do
    /*if($user->subscribedTo($request->package_id)){
        return response()->json([
            'error'=>true,
            'message'=>'Package already taken'
        ],422);
    }*/
    //check pending payment or activation
    //if starts, end date in null then need to buy subscription
    $check_subscription=PackageSubscription::where([
        'subscriber_type'=>get_class($user),
        'subscriber_id'=>$user->id,
        'package_id'=>$request->package_id,
        'starts_at'=>null,
        'ends_at'=>null
    ])->first();
    //if
    if($check_subscription){
        // $check_subscription_payment=\Corcel\Model\Post::type('subscription')->hasMeta('subscription_id',$check_subscription->id)->first();
        $check_subscription->subscription_id=$check_subscription->id;
        return response()->json([
            'error'=>true,
            'message'=>'Package already taken',
            'status'=>'pending',//$check_subscription_payment->post_status,
            'data'=>collect($check_subscription)->except(['subscriber_type'])
        ],200);//422
    }

    $package=Package::find($request->package_id);
    $subscription=PackageSubscription::create([
        'subscriber_type'=>get_class($user),
        'subscriber_id'=>$user->id,
        'package_id'=>$package->id,
        'name'=>'main',
    ]);
    if(!$subscription){
        return response()->json([
            'error'=>true,
            'message'=>'Unknown Error',
        ],422);
    }

    //this was old code it also record all data in post and post and meta data. Now, we are not going to record this data in
    // $subscription_payment=new \Corcel\Model\Post();
    // $subscription_payment->post_type='subscription';
    // $subscription_payment->post_title='Subscription';
    // $subscription_payment->post_content='';
    // $subscription_payment->post_status='pending';
    // $subscription_payment->post_author=auth()->id();
    // $subscription_payment->save();
    // $subscription_payment->saveMeta([
    //     'subscription_id'=>$subscription->id,
    //     'price'=>$package->price,
    // ]);
    // $subscription_payment->saveMeta($subscription->toArray());


    $subscription->subscription_id=$subscription->id;
    return response()->json([
        'success'=>true,
        'message'=>'Package added successfully',
        'status'=>'pending',//$subscription_payment->status,
        'data'=>collect($subscription)->except(['subscriber_type'])
    ]);
  }


   /**
   * Creating payment record in table.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request){
    $this->validate($request,[
        'package_id'=>'required',
        'subscription_id'=>'required',
        'payment_id'=>'required',
        'payment_method'=>'required'
    ]);
    $package=Package::findOrFail($request->package_id);

    // $subscription_payment=\Corcel\Model\Post::type('subscription')->hasMeta('subscription_id',$request->subscription_id)->orderBy('id','desc')->first();

    $subscription=PackageSubscription::find($request->subscription_id);


    //check package is started
    if($subscription->starts_at && $subscription->ends_at && $subscription->ends_at>now()){
        return response()->json([
            'error'=>true,
            'message'=>'Package already active'
        ],422);
    }

    if($request->payment_method=="razorpay"){  //payment_method it will come from app
        $keys = DB::table('settings')->where('key', 'razor_key')->first();
        $secret = DB::table('settings')->where('key', 'razor_secret')->first();
        $api = new \Razorpay\Api\Api($keys->value, $secret->value);
        $verify_payment=$api->payment->fetch($request->payment_id);

        //store payment record in table
        $payment = new UserTransactions;
        $payment->transaction_id            = 'PTX'.auth()->user()->id.mt_rand(111111, 999999);
        $payment->package_subscriptions_id  = $request->subscription_id??NULL;
        $payment->subscriber_id             = auth()->user()->id??NULL;
        $payment->package_id                = $package->id??NULL;
        $payment->payment_id                = $request->payment_id;
        $payment->title                     = 'subscription';
        $payment->status                    = $verify_payment['status'];
        $payment->price                     = $verify_payment['amount']/100;
        $payment->payment_log               = collect($verify_payment)->toJson();
        $payment->save();
        // $subscription_payment->post_status=$verify_payment['status'];
        // $subscription_payment->post_content=collect($verify_payment)->toJson();
        // $subscription_payment->save();
        // $subscription_payment->saveMeta([
        //     'payment_method'=>$request->payment_method,
        //     'payment_id'=>$request->payment_id
        // ]);

        if(!in_array($verify_payment['status'],['authorized','complete'])){
            return response()->json([
                'error'=>'true',
                'status'=>'pending',
                'message'=>'Payment Not completed yet!',
                'data'=>collect($subscription)->except(['subscriber_type'])
            ]);
        }
        $trial = new \App\Helpers\Period($package->trial_interval, $package->trial_period, $startDate ?? now());
        $period = new \App\Helpers\Period($package->invoice_interval, $package->invoice_period, $trial->getEndDate());

        $subscription->trial_ends_at = $trial->getEndDate();
        $subscription->starts_at = $period->getStartDate();
        $subscription->ends_at = $period->getEndDate();
        $subscription->save();

        $subscription_old=PackageSubscription::where('subscriber_id',auth()->user()->id)->whereNull('starts_at')->whereNull('ends_at')->get();
        //this will delete rest selected record from app while buying package, for which payment was not done.
        foreach($subscription_old as $items){
            PackageSubscription::where('id',$items->id)->forceDelete();
        }
        return response()->json([
            'success'=>true,
            'message'=>'Package activated successfully',
            'data'=>collect($subscription)->except(['subscriber_type'])
        ]);
    }

  }
  /*public function store(Request $request){
    $this->validate($request,[
        'package_id'=>'required'
    ]);
    $user=User::find(auth()->id());
    if($user->subscribedTo($request->package_id)){
        //check pending payment or activation
        $check_subscription=PackageSubscription::where([
            'subscriber_type'=>get_class($user),
            'subscriber_id'=>$user->id,
            'package_id'=>$request->package_id,
            'starts_at'=>null,
            'ends_at'=>null
        ])->first();
        if($check_subscription){
            $check_subscription_payment=\Corcel\Model\Post::type('subscription')->hasMeta('subscription_id',$check_subscription->id)->first();
            $check_subscription->subscription_id=$check_subscription->id;
            return response()->json([
                'error'=>true,
                'message'=>'Package already taken',
                'status'=>$check_subscription_payment->post_status,
                'data'=>collect($check_subscription)->except(['subscriber_type'])
            ],422);
        }
        return response()->json([
            'error'=>true,
            'message'=>'Package already taken'
        ],422);
    }
    $package=Package::find($request->package_id);

    $subscription=PackageSubscription::create([
        'subscriber_type'=>get_class($user),
        'subscriber_id'=>$user->id,
        'package_id'=>$package->id,
        'name'=>'main',
    ]);
    if(!$subscription){
        return response()->json([
            'error'=>true,
            'message'=>'Unknown Error',
        ],422);
    }
    $subscription_payment=new \Corcel\Model\Post();
    $subscription_payment->post_type='subscription';
    $subscription_payment->post_title='Subscription';
    $subscription_payment->post_content='';
    $subscription_payment->post_status='pending';
    $subscription_payment->post_author=auth()->id();
    $subscription_payment->save();
    $subscription_payment->saveMeta([
        'subscription_id'=>$subscription->id,
        'price'=>$package->price,
    ]);
    $subscription_payment->saveMeta($subscription->toArray());
    $subscription->subscription_id=$subscription->id;
    return response()->json([
        'success'=>true,
        'message'=>'Package added successfully',
        'status'=>$subscription_payment->status,
        'data'=>collect($subscription)->except(['subscriber_type'])
    ]);
  }
  public function update(Request $request){
    $this->validate($request,[
        'package_id'=>'required',
        'subscription_id'=>'required',
        'payment_id'=>'required'
    ]);
    $package=Package::findOrFail($request->package_id);

    $subscription_payment=\Corcel\Model\Post::type('subscription')->hasMeta('subscription_id',$request->subscription_id)->orderBy('id','desc')->first();

    if($request->payment_method=="razorpay"){
        $subscription=PackageSubscription::find($subscription_payment->subscription_id);
        $api = new \Razorpay\Api\Api('rzp_test_Pcxw5YZ5JTcfeH', 'RX3uNaqiDbqW0hWQpfRLAh5q');
        $verify_payment=$api->payment->fetch($request->payment_id);

        $subscription_payment->post_status=$verify_payment['status'];
        $subscription_payment->post_content=collect($verify_payment)->toJson();
        $subscription_payment->save();
        $subscription_payment->saveMeta([
            'payment_method'=>$request->payment_method,
            'payment_id'=>$request->payment_id
        ]);
        if(!in_array($verify_payment['status'],['authorized','complete'])){
            return response()->json([
                'error'=>'true',
                'status'=>$subscription_payment->post_status,
                'message'=>'Payment Not completed yet!',
                'data'=>collect($subscription)->except(['subscriber_type'])
            ]);
        }
        $trial = new \App\Helpers\Period($package->trial_interval, $package->trial_period, $startDate ?? now());
        $period = new \App\Helpers\Period($package->invoice_interval, $package->invoice_period, $trial->getEndDate());

        $subscription->trial_ends_at = $trial->getEndDate();
        $subscription->starts_at = $period->getStartDate();
        $subscription->ends_at = $period->getEndDate();
        $subscription->save();
        return response()->json([
            'success'=>true,
            'message'=>'Package activated successfully',
            'data'=>collect($subscription)->except(['subscriber_type'])
        ]);
    }

  }*/

  /**
   * payment fail.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function payment_failure(Request $request){
        $this->validate($request,[
            'package_id'=>'required',
            'payment_id'=>'required',
            'payment_method'=>'required'
        ]);

        $keys = DB::table('settings')->where('key', 'razor_key')->first();
        $secret = DB::table('settings')->where('key', 'razor_secret')->first();
        // $api = new \Razorpay\Api\Api('rzp_test_Pcxw5YZ5JTcfeH', 'RX3uNaqiDbqW0hWQpfRLAh5q'); old method
        $api = new \Razorpay\Api\Api($keys->value, $secret->value);
        $verify_payment=$api->payment->fetch($request->payment_id);

        //store payment record in table
        $payment = new UserTransactions;
        $payment->transaction_id            = 'FTX'.auth()->user()->id.mt_rand(111111, 999999);
        $payment->package_subscriptions_id  = $request->package_subscriptions_id??NULL;//this is database promary keys
        $payment->subscriber_id             = auth()->user()->id??NULL;
        $payment->package_id                = $request->package_id??NULL;
        $payment->payment_id                = $request->payment_id;
        $payment->title                     = 'subscription';
        $payment->status                    = 'failed';//$verify_payment['status'];
        $payment->price                     = $request->price; //$verify_payment['amount']/100;
        $payment->payment_log               = collect($verify_payment)->toJson();
        $payment->save();

        if(!$payment){
            return response()->json(['error'=>true,'message'=>'Something went wrong'],500);
        }
        return response()->json(['success'=>true],200);

  }

  public function renew(Request $request){
    //remmember not to add transaction in post and post_meta
    $package=Package::findOrFail($request->package_id);
    $subscription=PackageSubscription::where([
        'package_id'=>$request->package_id,
        'subscriber_type'=>get_class(auth()->user()),
        'subscriber_id'=>auth()->id()
    ])->first();
    if(!$subscription){
        return response()->json([
            'error'=>true,
            'message'=>'No subscription available for this package'
        ]);
    }
    $subscription_payment=new \Corcel\Model\Post();
    $subscription_payment->post_type='subscription';
    $subscription_payment->post_title='Subscription';
    $subscription_payment->post_content='';
    $subscription_payment->post_status='pending';
    $subscription_payment->post_author=auth()->id();
    $subscription_payment->save();
    $subscription_payment->saveMeta([
        'subscription_id'=>$subscription->id,
        'price'=>$package->price,
    ]);
    $subscription_payment->saveMeta($subscription->toArray());
    $subscription->subscription_id=$subscription->id;
    return response()->json([
        'success'=>true,
        'message'=>'Package added successfully',
        'status'=>$subscription_payment->status,
        'data'=>collect($subscription)->except(['subscriber_type'])
    ]);
  }



  public function renew_update(Request $request){
     //remmember not to add transaction in post and post_meta
    $this->validate($request,[
        'package_id'=>'required',
        'subscription_id'=>'required',
        'payment_id'=>'required'
    ]);
    $package=Package::findOrFail($request->package_id);

    $subscription_payment=\Corcel\Model\Post::type('subscription')->hasMeta('subscription_id',$request->subscription_id)->orderBy('id','desc')->first();

    if($request->payment_method=="razorpay"){
        $subscription=PackageSubscription::find($subscription_payment->subscription_id);
        $keys = DB::table('settings')->where('key', 'razor_key')->first();
        $secret = DB::table('settings')->where('key', 'razor_secret')->first();
        $api = new \Razorpay\Api\Api($keys->value, $secret->value);
        $verify_payment=$api->payment->fetch($request->payment_id);
        $subscription_payment->post_status=$verify_payment['status'];
        $subscription_payment->post_content=collect($verify_payment)->toJson();
        $subscription_payment->save();
        $subscription_payment->saveMeta([
            'payment_method'=>$request->payment_method,
            'payment_id'=>$request->payment_id
        ]);
        if(!in_array($verify_payment['status'],['authorized','complete'])){
            return response()->json([
                'error'=>'true',
                'status'=>$subscription_payment->post_status,
                'message'=>'Payment Not completed yet!',
                'data'=>collect($subscription)->except(['subscriber_type'])
            ]);
        }
        $trial = new \App\Helpers\Period($package->trial_interval, $package->trial_period, $startDate ?? now());
        $period = new \App\Helpers\Period($package->invoice_interval, $package->invoice_period, $trial->getEndDate());

        $subscription->trial_ends_at = $trial->getEndDate();
        $subscription->starts_at = $period->getStartDate();
        $subscription->ends_at = $period->getEndDate();
        $subscription->save();
        return response()->json([
            'success'=>true,
            'message'=>'Package renew successfully',
            'data'=>collect($subscription)->except(['subscriber_type'])
        ]);
    }
  }

   /**
   * Validate activation code given by company to its employee
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function validate_activation(Request $request){
    $this->validate($request, [
        'activation_code'=>'required',
        //'mobile'=>'required',
    ]);
    //$code = \DB::table('company_employee_packages')->where('user_mobile',$request->mobile)->where('activation_code',$request->activation_code)->first();
    $code = \DB::table('company_employee_packages')->where('user_mobile',auth()->user()->mobile)->where('activation_code',$request->activation_code)->first();
    if(!$code){
        return response()->json(['error'=>true, 'message'=>'Wrong Activation Code'],422);
    }
    if(strtolower($code->status)=='active'){
        return response()->json(['error'=>true, 'message'=>'Activation code already used!'],422);
    }
    if($code->activation_code == $request->activation_code){
        $user=User::find(auth()->id());
        $package=Package::find($code->package_id);
        //check active package
        if($user->subscribedTo($package->package_id)){
            return response()->json([
                'error'=>true,
                'message'=>'Package already taken'
            ],422);
        }
        $trial = new \App\Helpers\Period($package->trial_interval, $package->trial_period, $startDate ?? now());
        $period = new \App\Helpers\Period($package->invoice_interval, $package->invoice_period, $trial->getEndDate());

        $subscription=PackageSubscription::create([
            'subscriber_type'=>get_class($user),
            'subscriber_id'=>$user->id,
            'package_id'=>$package->id,
            'name'=>'main',
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate()
        ]);

        if(!$subscription){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error',
            ],422);
        }
        $subscription_payment=new \Corcel\Model\Post();
        $subscription_payment->post_type='subscription';
        $subscription_payment->post_title='Subscription';
        $subscription_payment->post_content='';
        $subscription_payment->post_status='complete';
        $subscription_payment->post_author=auth()->id();
        $subscription_payment->save();
        $subscription_payment->saveMeta([
            'subscription_id'=>$subscription->id,
            'price'=>$package->price,
            'activation_code'=>$code->activation_code
        ]);
        $subscription_payment->saveMeta($subscription->toArray());
        $subscription->subscription_id=$subscription->id;
        $code = \DB::table('company_employee_packages')->where('id',$code->id)->update([
            'status'=>'active'
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Package activated successfully',
            'status'=>$subscription_payment->status,
            'data'=>collect($subscription)->except(['subscriber_type'])
        ]);

    }

  }
  public function old_validate_activation(Request $request)
  {
      $validator = Validator::make($request->all(), [
          'activation_code'=>'required',
          'mobile'=>'required',
      ]);
      //Send failed response if request is not valid
      if ($validator->fails()) {
          return response()->json($validator->messages(), 422);
      }
      $code = DB::table('company_employee_packages')->where('user_mobile',$request->mobile)->where('activation_code',$request->activation_code)->first();
      if(!$code){
          return response()->json(['error'=>true, 'package'=>'Wrong Activation Coder'],422);
      }
      if($code->activation_code == $request->activation_code){
        //calculate user subscription days based on package
        $package_data = DB::table('packages')->where('id',$code->package_id)->first();
        $packages = new UserPackages;
        $packages->user_id      =  auth()->user()->id;
        $packages->package_id   =  $code->package_id;
        // $packages->price        =  $request->price;
        $start_date = Carbon::now();
        $end_date =  Carbon::now()->addDays($packages->days);
        $packages->start_date   =  $start_date;
        $packages->end_date     =  $end_date;
        // $packages->type     =  'Employee';
        $packages->save();
        return response()->json(['success'=>true, 'message'=>'Verified Successfully'],200);
      }
   }
}
