<?php

namespace App\Helpers;

use App\Helpers\Period;
use App\Models\Package;
use App\Models\PackageSubscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPackageSubscriptions
{
    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $type
     * @param string $id
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Boot the HasPlanSubscriptions trait for the model.
     *
     * @return void
     */
    protected static function bootHasSubscriptions()
    {
        static::deleted(function ($package) {
            $package->packageSubscriptions()->delete();
        });
    }
    /**
     * The subscriber may have many plan subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function packageSubscriptions(): MorphMany
    {
        return $this->morphMany(PackageSubscription::class, 'subscriber', 'subscriber_type', 'subscriber_id')->whereNotNull('starts_at');
    }

    /**
     * A model may have many active plan subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activePackageSubscriptions(): Collection
    {
        return $this->packageSubscriptions->reject->inactive();
    }

    /**
     * Get a plan subscription by slug.
     *
     * @param string $subscriptionSlug
     *
     * @return \Rinvex\Subscriptions\Models\PlanSubscription|null
     */
    public function packageSubscription(string $subscriptionSlug): ?PackageSubscription
    {
        return $this->packageSubscriptions()->where('slug', $subscriptionSlug)->first();
    }

    /**
     * Get subscribed plans.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscribedPlans(): Collection
    {
        $packageIds = $this->packageSubscriptions->reject->inactive()->pluck('package_id')->unique();

        return app(Package::class)->whereIn('id', $packageIds)->get();
    }

    /**
     * Check if the subscriber subscribed to the given plan.
     *
     * @param int $planId
     *
     * @return bool
     */
    public function subscribedTo($package): bool
    {
        $subscription = $this->packageSubscriptions()->where('package_id', $package)->first();

        return $subscription && $subscription->active();
    }

    /**
     * Subscribe subscriber to a new plan.
     *
     * @param string                            $subscription
     * @param \Rinvex\Subscriptions\Models\Plan $plan
     * @param \Carbon\Carbon|null               $startDate
     *
     * @return \Rinvex\Subscriptions\Models\PlanSubscription
     */
    public function newPackageSubscription($subscription, Package $package, Carbon $startDate = null): packageSubscription
    {
        $trial = new Period($package->trial_interval, $package->trial_period, $startDate ?? now());
        $period = new Period($package->invoice_interval, $package->invoice_period, $trial->getEndDate());

        return $this->packageSubscriptions()->create([
            'name' => $subscription,
            'package_id' => $package->getKey(),
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $period->getStartDate(),
            'ends_at' => $period->getEndDate(),
        ]);
    }
}
