<?php

namespace App\Models\Prop;

use Illuminate\Database\Eloquent\Model;

class SavedProp extends Model
{
    protected $table = "savedprops";

    protected $fillable = [
        'prop_id',
        'user_id',
        'title',
        'image',
        'location',
        'price'



    ];

    public $timestamps = true;
}
