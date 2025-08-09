<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'customer',
        'amount',
        'gyro_cash',
        'date_entry',
        'description',
        'date_factur',
        'no_factur',
        'date',
    ];
}
