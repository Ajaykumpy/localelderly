<?php
if(!function_exists('getAge')){
    function getAge($dob){
        if($dob){
            $dob_year = explode('/',$dob);
            $current_year = \Carbon\carbon::now()->format('Y');
            $age = (int)$current_year - (int)$dob_year[2];
            return $age;
        }else{
            return 'NA';
        }
    }
}

if(!function_exists('getBmi')){
    function getBmi($height, $weight){
        $bmi=0;
        if($height && $weight){
            if (str_contains($height, '.')) {
                //means height is in feet
                $feet_to_mtr = $height * 0.3048;
                $mtr_sqr = pow($feet_to_mtr,2);
                $bmi = round( (float) $weight/ $mtr_sqr, 1);
            }else{
                //for height in cm
                $cm_to_mtr = (int)$height * (float)0.01;
                $mtr_sqr = pow($cm_to_mtr,2);
                $bmi = round( (float) $weight/ $mtr_sqr, 1);
            }
            return  $bmi;
        }
    }//end of function
}


if(!function_exists('call_duration')){
    function call_duration($start, $end){        
        if($start && $end){
            $start = DateTime::createFromFormat('Y-m-d H:i:s', $start);
            $ends = DateTime::createFromFormat('Y-m-d H:i:s', $end);
            $duration = $start->diff($ends);
            $duration = $duration->format('%h:%i');
            return $duration;
        }else{
            return 'NA';
        }
    }
}


//Custom notification
if(!function_exists('custom_notification')){
    function custom_notification($device_id,$title='',$body='',$data=""){
        $ids=[];
        if(is_array($device_id)){
            $ids=$device_id;
        }
        else{
            $ids=[$device_id];
        }

        $headers = [
            'Authorization' => 'key=AAAA0vOjJRA:APA91bH8LLq7TJytkFVMgRt9m5H_q_AXHv7Rw3zRmaAYVsHECVyy0SJgAZvy_jqVLBTdWfUBIsgS-Dtp9tklQMu4z8zG7CFUP1OD0PUTW5qh43KDhJmrPlId80GE6y4XO2-82tnfnqYB',
            'Content-Type'  => 'application/json',
        ];
        $data = [
            "registration_ids" => $ids,
            "priority"=> "high",
            //"to" => "/topics/all",
            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound" =>'custom_ringtone.wav',
                "android_channel_id" => 'high_importance_channel',
            ],
            "data" => $data,
        ];
        $fields = json_encode ( $data );
        \Log::info($fields);
        $client = new \GuzzleHttp\Client();

        try{
            $request = $client->post("https://fcm.googleapis.com/fcm/send",[
                'headers' => $headers,
                'body' => $fields,
                //'cert' => ['/path/to/openyes.crt.pem', 'password'],
                //'ssl_key' => ['/path/to/openyes.key.pem', 'password']
            ]);
            $response = $request->getBody();
            return $response;
        }
        catch (Exception $e){
            return $e;
        }

    }
}
//Doctor Call
if(!function_exists('call_custom_notification')){
    function call_custom_notification($device_id,$title='',$body='',$data=""){
        $ids=[];
        if(is_array($device_id)){
            $ids=$device_id;
        }
        else{
            $ids=[$device_id];
        }
        $headers = [
            //'Authorization' => 'key=AAAA0vOjJRA:APA91bH8LLq7TJytkFVMgRt9m5H_q_AXHv7Rw3zRmaAYVsHECVyy0SJgAZvy_jqVLBTdWfUBIsgS-Dtp9tklQMu4z8zG7CFUP1OD0PUTW5qh43KDhJmrPlId80GE6y4XO2-82tnfnqYB',
            'Authorization' => 'key=AAAAQtScLnE:APA91bGLmKKk_uv2Ol8fXK2amheMKer80MEgI6lsE4cuagTwazJoMefbiRqFKKjnLFYsv7OrMcg6Jqs733zjTsDFzYlxLmA6f60JDQg3D63ZhWWkw3Nu5cighKPSAzh3H4H-Oodc9dUa',
            'Content-Type'  => 'application/json',
        ];
        $data = [
            "registration_ids" => $ids,
            "priority"=> "high",
            //"to" => "/topics/all",
            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound" =>'sound.caf',
                "android_channel_id" => 'high_importance_channel',
            ],
            "data" => $data,
        ];
        $fields = json_encode ( $data );
        \Log::info($fields);
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->post("https://fcm.googleapis.com/fcm/send",[
                'headers' => $headers,
                'body' => $fields,
                //'cert' => ['/path/to/openyes.crt.pem', 'password'],
                //'ssl_key' => ['/path/to/openyes.key.pem', 'password']
            ]);

            $response = $request->getBody();
            return $response;
        }
        catch (Exception $e){
            return $e;
        }

    }
}
//send otp
if(!function_exists('send_otp')){
    function send_otp($mobile,$message){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.authkey.io/request?authkey=abd19922e8887923&mobile='.$mobile.'&country_code=91&sid=6560&otp='.$message.'&time='.'%20mins',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        }
        return $response;
    }
}
if(!function_exists('emergency_status')){
    function emergency_status($data){
    //0 = UPCOMMING,1=Connected, 2=COMPLETED, 3=cancelled call. for latest notation refer DB
        $status=[
            '0'=>'primary',
            '1'=>'warning',
            '2'=>'success',
            '3'=>'warning',
            '4'=>'warning',
        ];
        if($data){
            return $status[$data];
        }else{
            return $status[$data];
        }
        return $data;
    }
}
