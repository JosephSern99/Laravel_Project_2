<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class Person extends Model
{
    use HasFactory;
	
	protected $table = "Person";
    protected $primaryKey = "Pers_PersonId";
    const CREATED_AT = 'Pers_CreatedDate';
    const UPDATED_AT = 'Pers_UpdatedDate';
	protected $dates = [
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Pers_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Pers_CreatedBy = $user->getKey();
                $model->Pers_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Pers_UpdatedBy = $user->getKey();
			}
        });
    }
	

}
