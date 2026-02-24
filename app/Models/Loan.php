<?php

namespace App\Models;
 use App\Models\InterestRate;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
   protected $fillable = [
    'user_id',
    'amount',
    'months',
    'interest_rate_id',
    'total',
    'monthly_payment',
    'status'
];


    public function interestRate()
    {
        return $this->belongsTo(InterestRate::class);
    }

    public function movements()
{
    return $this->hasMany(LoanMovement::class);
}

public function payments(){
    return $this->hasMany(Payment::class);
}

public function totalPaid(){
    return $this->payments()
        ->where('status','received')
        ->sum('amount');
}




protected static function booted()
{
    static::creating(function ($loan) {

        $rate = InterestRate::find($loan->interest_rate_id)->rate;

        // comisión
        $loan->commission = $loan->amount * ($rate / 100);

        // total
        $loan->total = $loan->amount + $loan->commission;

        // pago mensual
        //$loan->monthly_payment = $loan->total / $loan->months;
    });
}

public function user()
{
    return $this->belongsTo(User::class);
}



}

