<?php

namespace App\Models\Prop;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = "props";

    protected $fillable = [
        'title',
        'price',
        'image',
        'beds',
        'baths',
        'sq_ft',
        'home_type',
        'year_built',
        'price_sqft',
        'more_info',
        'location',
        'agent_name',
    ];

    public $timestamps = true;

    // Define relationship with AllRequest model
    public function requests()
    {
        return $this->hasMany(AllRequest::class, 'prop_id', 'id');
    }
}
