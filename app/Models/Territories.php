<?php
namespace App\Models;
use App\Scopes\DelScope;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class Territories extends Model
{
    use HasFactory;

	protected $table = "Territories";
    protected $primaryKey = "Terr_DBID";
    const CREATED_AT = 'Terr_CreatedDate';
    const UPDATED_AT = 'Terr_UpdatedDate';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new DelScope("Terr_Deleted"));

        static::addGlobalScope("valid", function(Builder $builder){
            $builder->where('Terr_DBID', '>', 1);
        });
    }
}