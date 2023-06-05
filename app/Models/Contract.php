<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class Contract extends Model
{
    use HasFactory;
	protected $table = "Contract";
    protected $primaryKey = "Ctra_ContractID";
    const CREATED_AT = 'Ctra_CreatedDate';
    const UPDATED_AT = 'Ctra_UpdatedDate';
	protected $dates = [
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Ctra_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Ctra_CreatedBy = $user->getKey();
                $model->Ctra_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Ctra_UpdatedBy = $user->getKey();
			}
        });
    }
	
	public function Address()
	{
		return $this->belongsTo(Address::class, "ctra_Address");//3rd parameter is primary key
	}
}
