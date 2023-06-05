<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class ServiceOrderItem extends Model
{
    use HasFactory;

    protected $table = "ServiceOrderItem";
    protected $primaryKey = "svit_ServiceOrderItemID";
    const CREATED_AT = 'svit_CreatedDate';
    const UPDATED_AT = 'svit_UpdatedDate';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("svit_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->svit_CreatedBy = $user->getKey();
                $model->svit_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->svit_UpdatedBy = $user->getKey();
			}
        });
    }

}
