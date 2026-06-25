<?php

namespace App\Models\Prop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeType extends Model
{
    use SoftDeletes;

    protected $table = "hometypes";

    protected $fillable = [
        'id',
        'hometypes',
    ];

    public $timestamps = true;
}
