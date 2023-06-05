<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;


class Address extends Model
{
    use HasFactory;
	
	protected $table = "Address";
    protected $primaryKey = "Addr_AddressId";
    const CREATED_AT = 'Addr_CreatedDate';
    const UPDATED_AT = 'Addr_UpdatedDate';
	protected $dates = [
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Addr_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Addr_CreatedBy = $user->getKey();
                $model->Addr_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Addr_UpdatedBy = $user->getKey();
			}
        });
    }
}
