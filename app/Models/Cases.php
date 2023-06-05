<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\DelScope;

class Cases extends Model
{
    use HasFactory;

    protected $table = "Cases";
    protected $primaryKey = "Case_CaseId";
    const CREATED_AT = 'Case_CreatedDate';
    const UPDATED_AT = 'Case_UpdatedDate';
	protected $dates = [
        "Case_Opened",
		"Case_Closed"

    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Case_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->Case_CreatedBy = $user->getKey();
                $model->Case_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->Case_UpdatedBy = $user->getKey();
			}
        });
    }

	public function Company()
	{
		return $this->belongsTo(Company::class, "Case_PrimaryCompanyId", "Comp_CompanyId");//3rd parameter is primary key
	}

	public function Person()
	{
		return $this->belongsTo(Person::class, "Case_PrimaryPersonId");//3rd parameter is primary key
	}

	public function User()
	{
		return $this->belongsTo(User::class, "Case_AssignedUserId");//3rd parameter is primary key
	}

	public function Contact()
	{
		return $this->belongsTo(Contact::class, "Case_PrimaryPersonId", "Pers_PersonId");//3rd parameter is primary key
	}

	public function ServiceOrder()
	{
		return $this->belongsTo(ServiceOrder::class, "Case_CaseId", "svor_CaseId")->orderBy('Svor_ServiceOrderID','DESC')->latest();//3rd parameter is primary key
	}


	public function Contract()
	{
		return $this->belongsTo(Contract::class, "case_contractid", "Ctra_ContractID");//3rd parameter is primary key
	}

	public function Address()
	{
		return $this->belongsTo(Address::class, "case_addr");//3rd parameter is primary key
	}


    /*public function items()
    {
        return $this->hasMany(FJODetail::class, "svit_ServiceOrderItemId");
    }*/

	/*
	public function territory()
	{
		return $this->belongsTo(Territories::class, "svod_Secterr", "Terr_TerritoryID");
	}


	public function Person()
	{
		return $this->belongsTo(Person::class, "svod_PersonId");//3rd parameter is primary key
	}

	public function Company()
	{
		return $this->belongsTo(Company::class, "svod_CompanyId");//3rd parameter is primary key
	}

	public function Contact()
	{
		return $this->belongsTo(Contact::class, "svod_PersonId", "Pers_PersonId");//3rd parameter is primary key
	}

	public function Address()
	{
		return $this->belongsTo(Address::class, "svod_svcaddress");//3rd parameter is primary key
	}

	public function Asset()
	{
		return $this->belongsTo(Asset::class, "svod_assetid");//3rd parameter is primary key
	}*/

}
