<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class NewProduct extends Model
{
    use HasFactory;

    protected $table = "NewProduct";
    protected $primaryKey = "Prod_ProductID";
    const CREATED_AT = 'Prod_CreatedDate';
    const UPDATED_AT = 'Prod_UpdatedDate';


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Prod_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Prod_CreatedBy = $user->getKey();
                $model->Prod_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Prod_UpdatedBy = $user->getKey();
			}
        });
    }

}
