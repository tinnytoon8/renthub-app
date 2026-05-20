<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Override;

class Expense extends Model
{
    protected $fillable = ['title', 'amount', 'expense_date', 'proof_of_expense', 'notes'];
}