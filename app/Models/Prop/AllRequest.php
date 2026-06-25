<?php

namespace App\Models\Prop;

use Illuminate\Database\Eloquent\Model;

class AllRequest extends Model
{
    protected $table = "requests";

    protected $fillable = [
        'prop_id',
        'agent_name',
        'user_id',
        'name',
        'email',
        'phone',
    ];

    // Define relationship with Property model
    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id', 'id');
    }
}
