<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanMovement;
use App\Models\InterestRate;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // ===============================
    // ADMIN VE PRÉSTAMOS
    // ===============================
    public function index()
    {
        $loans = Loan::with('user')->get();
        return view('admin.loans.index', compact('loans'));
    }

    // ===============================
    // USUARIO SOLICITA ENTREGA
    // ===============================
    public function store(Request $request)
    {
        $rate = InterestRate::findOrFail($request->interest_rate_id);

        $amount = floatval($request->amount);

        // comisión = interés %
        $commission = $amount * ($rate->rate / 100);

        // total real
        $total = $amount + $commission;

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'amount' => $amount,
            'interest_rate_id' => $rate->id,
            'commission' => $commission,
            'total' => $total,
            'status' => 'pending'
        ]);

        // movimiento solicitud
        // saldo anterior real del usuario
        $lastBalance = floatval(
            \App\Models\LoanMovement::whereHas('loan', function($q) {
                $q->where('user_id', auth()->id());
            })->latest()->value('balance_after') ?? 0
        );

        // movimiento solicitud (NO cambia saldo)
        $loan->movements()->create([
            'type' => 'request',
            'amount' => $amount,
            'balance_after' => $lastBalance
        ]);

        return back();
    }

    // ===============================
    // ADMIN APRUEBA ENTREGA
    // ===============================
   public function approve(Loan $loan)
{
    $loan->update(['status' => 'approved']);

    // Buscar el movimiento request
    $requestMovement = $loan->movements()
        ->where('type', 'request')
        ->first();

    if (!$requestMovement) {
        return back();
    }

    // Calcular comisión
    $commission = floatval($loan->amount) * ($loan->interestRate->rate / 100);

    // 🔎 Saldo anterior REAL del usuario (sin contar este request)
    $lastBalance = LoanMovement::whereHas('loan', function($q) use ($loan) {
            $q->where('user_id', $loan->user_id);
        })
        ->where('id', '!=', $requestMovement->id)
        ->latest()
        ->value('balance_after') ?? 0;

    // =====================================
    // 1️⃣ CONVERTIR REQUEST EN DELIVERY
    // =====================================

    $balanceAfterDelivery = $lastBalance + $loan->amount;

    $requestMovement->update([
        'type' => 'delivery',
        'balance_after' => $balanceAfterDelivery
    ]);

    // =====================================
    // 2️⃣ CREAR MOVIMIENTO DE COMISIÓN
    // =====================================

    $balanceAfterCommission = $balanceAfterDelivery + $commission;

    $loan->movements()->create([
        'type' => 'commission',
        'amount' => $commission,
        'balance_after' => $balanceAfterCommission
    ]);

    return back();
}

    // ===============================
    // ADMIN RECHAZA
    // ===============================
    public function reject(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        return back();
    }

    public function pay(Request $request, Loan $loan)
{
    $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    $lastBalance = $loan->movements()->latest()->value('balance_after') ?? 0;

    $newBalance = $lastBalance - $request->amount;

    $loan->movements()->create([
        'type' => 'payment',
        'amount' => $request->amount,
        'balance_after' => $newBalance,
        'status' => 'enviado' // 🔥 CLAVE
    ]);

    return back();
}

public function userLoan()
{
    $loans = Loan::where('user_id', auth()->id())->get();

    $movements = LoanMovement::whereHas('loan', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

    // 🔎 Último movimiento real
    $ultimoMovimiento = LoanMovement::whereHas('loan', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->latest()
        ->first();

    $ultimoTipo = $ultimoMovimiento->type ?? null;

    // 🔥 Monto solicitado o entregado
    $montoSolicitadoUsuario = 0;

    if ($ultimoMovimiento) {
        if ($ultimoMovimiento->type === 'request') {
            $montoSolicitadoUsuario = $ultimoMovimiento->amount;
        }

        if ($ultimoMovimiento->type === 'delivery') {
            $montoSolicitadoUsuario = $ultimoMovimiento->amount;
        }
    }

    // ✅ SALDO REAL ACTUAL (último balance_after)
    $saldoTotalCard = LoanMovement::whereHas('loan', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->latest()
        ->value('balance_after') ?? 0;

    return view('user.loan', compact(
        'loans',
        'movements',
        'ultimoTipo',
        'montoSolicitadoUsuario',
        'saldoTotalCard'
    ));
}


}
