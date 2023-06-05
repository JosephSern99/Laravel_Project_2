<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Scopes\DelScope;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "Users";
    protected $primaryKey = "User_UserId";
    const CREATED_AT = 'User_CreatedDate';
    const UPDATED_AT = 'User_UpdatedDate';

    protected $rememberTokenName = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("User_Deleted"));

        static::creating(function($model)
        {
			if(auth()->check()){
				$user = auth()->user();
				$model->User_CreatedBy = $user->getKey();
                $model->User_UpdatedBy = $user->getKey();
			}
        });

        static::updating(function($model)
        {
            if(auth()->check()){
				$user = auth()->user();
                $model->User_UpdatedBy = $user->getKey();
			}
        });
    }

    public function getAuthPassword(){
        return 'User_Password';
    }

    public function scopeGetLogon($query, $username, $password){
        return $query->where("User_Logon", $username)
        ->where("user_webpassword", $password);
    }
}
