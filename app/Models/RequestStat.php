<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class RequestStat extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['endpoint', 'date'];
    protected $dates = ['date'];
}
