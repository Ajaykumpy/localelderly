<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'uuid',
        'name',
        'description',
        'days',
        'price',
        'email'
        
    ];

    public function isFree(): bool
    {
        return (float) $this->price <= 0.00;
    }

    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
    }

    public function hasGrace(): bool
    {
        return $this->grace_period && $this->grace_interval;
    }

    public function getFeatureBySlug(string $featureSlug): ?PackageFeature
    {
        return $this->features()->where('slug', $featureSlug)->first();
    }
    public function activate()
    {
        $this->update(['status' => 1]);

        return $this;
    }
    public function deactivate()
    {
        $this->update(['status' => 0]);

        return $this;
    }

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class, 'package_id', 'id');
    }
    
}
