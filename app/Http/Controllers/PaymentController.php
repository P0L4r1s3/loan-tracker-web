<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Loan;
use App\Models\LoanMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{


public function adminIndex()
{
    $payments = Payment::with(['loan.user'])
                ->orderBy('created_at', 'desc')
                ->get();

                

    // ===== RESUMEN GLOBAL =====

    $totalEntregado = LoanMovement::where('type','delivery')->sum('amount');

    $totalComisiones = LoanMovement::where('type','commission')->sum('amount');

    $totalPagosRecibidos = LoanMovement::where('type','payment')
                                ->where('status','received')
                                ->sum('amount');

    $totalConComision = $totalEntregado + $totalComisiones;

    $saldoGlobal = $totalConComision - $totalPagosRecibidos;

    return view('admin.payments', compact(
        'payments',
        'totalEntregado',
        'totalComisiones',
        'totalConComision',
        'totalPagosRecibidos',
        'saldoGlobal'
    ));
}

    // ✅ Vista para crear pago
    public function create()
    {
        $loans = auth()->user()
            ->loans()
            ->where('status', 'approved')
            ->get();

        return view('user.payments.create', compact('loans'));
    }

    // ✅ Guardar pago
    public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'concept' => 'required|string|max:255',
        'receipt' => 'required|image|max:2048'
    ]);

    // 🔹 1️⃣ Obtener automáticamente el último préstamo aprobado
    $loan = auth()->user()
        ->loans()
        ->where('status', 'approved')
        ->latest() // el más reciente por created_at
        ->first();

    if (!$loan) {
        return back()->with('error','No tienes préstamos activos');
    }

    $path = $request->file('receipt')->store('receipts','public');

    // 🔹 2️⃣ Crear pago usando el ID automático
    $payment = Payment::create([
        'user_id' => auth()->id(),
        'loan_id' => $loan->id, // 👈 aquí ya no viene del form
        'amount' => $request->amount,
        'concept' => $request->concept,
        'receipt' => $path,
        'status' => 'sent'
    ]);

    // 🔹 3️⃣ Obtener último saldo GLOBAL del usuario
    $lastBalance = LoanMovement::whereHas('loan', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->latest()
        ->value('balance_after') ?? 0;

    // 🔹 4️⃣ Crear movimiento
    LoanMovement::create([
        'loan_id' => $loan->id,
        'type' => 'payment',
        'amount' => $request->amount,
        'balance_after' => $lastBalance,
        'status' => 'sent',
        'payment_id' => $payment->id
    ]);

    return redirect()->route('user.loan')
        ->with('success','Pago enviado correctamente');
}


    // (opcional) mostrar pagos de un préstamo
    public function show(Loan $loan)
    {
        $payments = $loan->payments;
        return view('user.payments', compact('loan','payments'));
    }

    // ✅ Confirmar pago (ADMIN)


public function confirm(Payment $payment)
{
    if ($payment->status === 'received') {
        return back()->with('error', 'Este pago ya fue confirmado');
    }

    DB::transaction(function () use ($payment) {

        // 1️⃣ Confirmar pago
        $payment->update([
            'status' => 'received'
        ]);

        $movement = LoanMovement::where('payment_id', $payment->id)->first();

        if ($movement) {
            $movement->update([
                'status' => 'received'
            ]);
        }

        // 2️⃣ Traer TODOS los movimientos del usuario en orden
        $movements = LoanMovement::whereHas('loan', function ($q) use ($payment) {
                $q->where('user_id', $payment->user_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // 3️⃣ Recalcular saldo acumulado correctamente
        $saldo = 0;

        foreach ($movements as $move) {

            if (in_array($move->type, ['delivery','commission'])) {
                $saldo += $move->amount;
            }

            if ($move->type === 'payment' && $move->status === 'received') {
                $saldo -= $move->amount;
            }

            // 🔹 Actualizar cada fila correctamente
            $move->update([
                'balance_after' => $saldo
            ]);
        }
    });

    return back()->with('success', 'Pago confirmado correctamente');
}



// ❌ Rechazar pago (ADMIN)
public function reject(Payment $payment)
{
    if ($payment->status === 'received') {
        return back()->with('error', 'No puedes rechazar un pago ya confirmado');
    }

    $payment->update([
        'status' => 'rejected'
    ]);

    LoanMovement::where('payment_id', $payment->id)
        ->update(['status' => 'rejected']);

    return back()->with('error', 'Pago rechazado');
}

}
