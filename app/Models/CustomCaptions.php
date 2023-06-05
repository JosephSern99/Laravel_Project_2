<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomCaptions extends Model
{
    use HasFactory;

    protected $table = "Custom_Captions";
    protected $primaryKey = "Capt_CaptionId";
    const CREATED_AT = 'Capt_CreatedDate';
    const UPDATED_AT = 'Capt_UpdatedDate';

}
