<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $table = "ServiceOrder";
    protected $primaryKey = "Svor_ServiceOrderID";
    const CREATED_AT = 'Svor_CreatedDate';
    const UPDATED_AT = 'Svor_UpdatedDate';
	protected $dates = [
		"svor_ServiceOrderDate",
    ];

    protected $casts = [
        "svor_datefrom" => "datetime:d/m/Y H:i:s",
		"svor_dateto" => "datetime:d/m/Y H:i:s"
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Svor_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Svor_CreatedBy = $user->getKey();
                $model->Svor_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Svor_UpdatedBy = $user->getKey();
			}
        });
    }


	public function Company()
	{
        return $this->belongsTo(Company::class, "svor_CompanyId", "Comp_CompanyId");//3rd parameter is primary key
	}


	public function Cases()
	{
		return $this->belongsTo(Cases::class, "svor_CaseId");//3rd parameter is primary key
	}

    public function ServiceOrderItem()
	{
		return $this->belongsTo(ServiceOrderItem::class, "Svor_ServiceOrderID", "svit_serviceorderid")->latest();//3rd parameter is primary key
	}


}
