<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class Asset extends Model
{
    use HasFactory;
	
	protected $table = "Asset";
    protected $primaryKey = "aset_AssetID";
    const CREATED_AT = 'aset_CreatedDate';
    const UPDATED_AT = 'aset_UpdatedDate';
	protected $dates = [
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("aset_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->aset_CreatedBy = $user->getKey();
                $model->aset_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->aset_UpdatedBy = $user->getKey();
			}
        });
    }
}
