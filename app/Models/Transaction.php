<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';  

    protected $fillable = [
        'type',
        'amount',
        'customer',
        'gyro_cash',
        'date_entry',
        'description',
        'date_factur',
        'no_factur',
        'date',
    ];
}
