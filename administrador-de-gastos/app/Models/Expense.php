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
        'user_id',
        'purchase_id',
        'date_id',
        'reason_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function date()
    {
        return $this->belongsTo(date::class);
    }

    public function reason()
    {
        return $this->belongsTo(reason::class);
    }
}
