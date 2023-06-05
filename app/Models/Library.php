<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class Library extends Model
{
    use HasFactory;

	protected $table = "Library";
    protected $primaryKey = "Libr_LibraryId";
    const CREATED_AT = 'Libr_CreatedDate';
    const UPDATED_AT = 'Libr_UpdatedDate';
	protected $dates = [
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Libr_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Libr_CreatedBy = $user->getKey();
                $model->Libr_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Libr_UpdatedBy = $user->getKey();
			}
        });
    }
}
