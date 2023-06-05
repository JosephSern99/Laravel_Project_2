<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testing extends Model
{
    use HasFactory;
	protected $table = "BOMHeader";
    protected $primaryKey = "bomh_BOMHeaderID";
    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;
	
}
