<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = "url";
    protected $fillable = ["original_url",'short_code'];
    protected $hidden = ['created_at', 'updated_at'];
}
