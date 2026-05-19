<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['lease_id', 'invoice_number', 'amount_paid', 'payment_date', 'payment_method', 'status', 'proof_of_payment', 'notes'];

    public function lease()
    {
        // pembayaran ini milik satu 
        return $this->belongsTo(Lease::class);
    }

    protected static function booted()
    {
        static::creating(function ($payment) {
            $today = Carbon::now()->format('Ymd');

           $lastPayment = self::where('invoice_number', 'like', "INV-{$today}-%")
                               ->orderBy('id', 'desc')
                               ->first();
            
            if ($lastPayment) {
                $lastNumber = intval(substr($lastPayment->invoice_number, -4));
                $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '0001';
            }

            $payment->invoice_number = "INV-{$today}-{$nextNumber}";
        });
    }
}
