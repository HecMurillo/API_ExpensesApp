<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'expense',
        'earning',
        'users_id',
        'purchase_id',
        'date_id',
        'reason_id',
    ];
}
