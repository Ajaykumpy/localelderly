<?php
namespace App\Helpers;

use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPackage
{
    /**
     * The model always belongs to a plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id', 'package');
    }

    /**
     * Scope models by plan id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int                                   $planId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPlanId(Builder $builder, int $packageId): Builder
    {
        return $builder->where('package_id', $packageId);
    }
}