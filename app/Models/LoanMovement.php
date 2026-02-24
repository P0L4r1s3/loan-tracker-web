<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanMovement extends Model
{
    protected $fillable = [
        'loan_id',
        'payment_id',
        'type',
        'amount',
         'status',
        'balance_after'
    ];

    // Relación con Loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // 🔥 RELACIÓN CON PAYMENT (LA QUE TE FALTA)
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
