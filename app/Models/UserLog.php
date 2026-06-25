<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'user_logs';

    // Specify the fillable fields if you want to use mass assignment
    protected $fillable = [
        'user_id',
        'operation',
        'changed_data',
        'performed_at',
    ];
}