<x-app-layout>
<div class="bg-gray-100 min-h-screen py-12">
<div class="max-w-5xl mx-auto space-y-12">

<h1 class="text-4xl font-extrabold text-slate-800 text-center">
Panel de Entregas
</h1>

{{-- ================= FILTRO ================= --}}
<div class="bg-white rounded-2xl shadow p-6 border">
<form method="GET" action="{{ route('user.loan') }}"
class="flex flex-wrap gap-4 items-end">

<div>
<label class="text-sm text-gray-600">Desde</label>
<input type="date" name="from" value="{{ request('from') }}"
class="border rounded-xl p-2">
</div>

<div>
<label class="text-sm text-gray-600">Hasta</label>
<input type="date" name="to" value="{{ request('to') }}"
class="border rounded-xl p-2">
</div>

<button class="bg-indigo-600 text-white px-6 py-2 rounded-xl hover:bg-indigo-700">
Filtrar
</button>

<a href="{{ route('user.loan') }}" class="text-gray-500 underline">
Limpiar
</a>

</form>
</div>

{{-- ================= SOLICITUD ================= --}}
<div class="bg-white rounded-2xl shadow-xl p-8 border">
<h2 class="text-2xl font-semibold mb-6 text-indigo-700">
Nueva solicitud de Entrega
</h2>

<form action="{{ route('loans.store') }}" method="POST"
class="grid md:grid-cols-3 gap-5">
@csrf

<input type="number" name="amount" required
placeholder="Monto solicitado"
class="rounded-xl border p-3">

<select name="interest_rate_id" required
class="rounded-xl border p-3">
@foreach(\App\Models\InterestRate::all() as $rate)
<option value="{{ $rate->id }}">
{{ $rate->rate }}%
</option>
@endforeach
</select>

<button class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold">
Solicitar
</button>

</form>
</div>

{{-- ================= MOVIMIENTOS ================= --}}
@php
$movements = \App\Models\LoanMovement::with('loan','payment')
    ->whereHas('loan', function($q){
        $q->where('user_id', auth()->id());
    })
    ->when(request('from'), fn($q)=>$q->whereDate('created_at','>=',request('from')))
    ->when(request('to'), fn($q)=>$q->whereDate('created_at','<=',request('to')))
    ->orderBy('created_at')
    ->get();

/* 🔹 Monto solicitado */
$montoSolicitado = $movements
    ->where('type','request')
    ->sum('amount');

    /* 🔹 Último movimiento (para saber el tipo) */
$lastMovement = \App\Models\LoanMovement::whereHas('loan', function($q) {
        $q->where('user_id', auth()->id());
    })
    ->latest()
    ->first();

$ultimoTipo = $lastMovement->type ?? null;


/* 🔹 Último request (SIEMPRE sin comisión) */
$lastRequest = \App\Models\LoanMovement::whereHas('loan', function($q) {
        $q->where('user_id', auth()->id());
    })
    ->where('type', 'request')
    ->latest()
    ->first();

$montoSolicitadoUsuario = $lastRequest->amount ?? 0;



/* 🔹 Monto entregado */
$montoEntregado = $movements
    ->where('type','delivery')
    ->sum(function($m){
        return $m->loan->amount ?? 0;
    });

/* 🔹 Saldo */
//$saldoTotal = $movements->last()->balance_after ?? 0;

/* 🔹 Saldo calculado correctamente */
$saldoTotalCard = optional($movements->last())->balance_after ?? 0;

foreach ($movements as $move) {

    // Cuando es solicitud (no afecta saldo aún)
    if ($move->type === 'request') {
        continue;
    }

    // Cuando es entrega aprobada
    if ($move->type === 'delivery' && $move->status === 'entregado') {
        $saldoTotal += $move->amount;
    }

    // Cuando es pago
    if ($move->type === 'payment') {
        $saldoTotal -= $move->amount;
    }

    $saldoTotal = 0;

// 🔹 Suma total de solicitudes
$totalSolicitudes = $movements
    ->where('type','request')
    ->sum('amount');

// 🔹 Recorremos todos los movimientos en orden
foreach ($movements as $move) {

    // 1️⃣ Si es solicitud
    if ($move->type === 'request') {
        $saldoTotal += $move->amount;
    }

    // 2️⃣ Si es entrega aprobada
    if ($move->type === 'delivery' && $move->status === 'entregado') {

        // 🔹 Si tu comisión está guardada en $move->commission
        $comision = $move->commission ?? 0;

        $saldoTotal += ($move->amount + $comision);
    }

    // 3️⃣ Si es pago
    if ($move->type === 'payment') {
        $saldoTotal -= $move->amount;
    }
}

}
@endphp

<div class="bg-white rounded-2xl shadow-xl p-8 space-y-8 border">

{{-- ===== RESUMEN ===== --}}
<div class="grid md:grid-cols-3 gap-6">

  @if($ultimoTipo === 'request')
<div class="rounded-xl bg-slate-50 border p-6 shadow-sm">
    <p class="text-sm text-gray-500 uppercase">Monto Solicitado</p>
    <p class="text-3xl font-bold text-slate-800">
        ${{ number_format($montoSolicitadoUsuario,2) }}
    </p>
</div>
@endif

@if($ultimoTipo === 'delivery')
<div class="rounded-xl bg-emerald-50 border border-emerald-200 p-6 shadow-sm">
    <p class="text-sm text-emerald-600 uppercase">Monto Entregado</p>
    <p class="text-3xl font-bold text-emerald-700">
        ${{ number_format($montoSolicitadoUsuario,2) }}
    </p>
</div>
@endif


    {{-- SALDO --}}
    <div class="rounded-xl bg-slate-50 border p-6 shadow-sm">
        <p class="text-sm text-gray-500 uppercase">Saldo actual</p>
        <p class="text-3xl font-bold 
            @if($saldoTotalCard > 0) text-red-600 
            @else text-emerald-600 
            @endif">
            ${{ number_format(abs($saldoTotalCard),2) }}
        </p>
    </div>

</div>

{{-- BOTÓN PAGO --}}
@if($saldoTotalCard > 0)
<div class="flex justify-end mb-4">
    <a href="{{ route('payments.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
        Realizar Pago
    </a>
</div>
@endif

<hr>

{{-- ===== HISTORIAL ===== --}}
{{-- ===== HISTORIAL ===== --}}
<div 
    x-data="{ modalOpen: false, imageUrl: '' }"
    class="overflow-hidden rounded-xl border shadow-lg mt-6"
>

    <table class="min-w-full text-base text-center">

        <thead class="bg-slate-800 text-white">
            <tr>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3">Movimiento</th>
                <th class="px-4 py-3">Cargo</th>
                <th class="px-4 py-3">Abono</th>
                <th class="px-4 py-3">Saldo Total</th>
                <th class="px-4 py-3">Estado</th>
            </tr>
        </thead>

        @foreach($movements as $move)
        <tbody x-data="{ rowOpen: false }" class="divide-y divide-gray-200 bg-white">

            {{-- ================= FILA PRINCIPAL ================= --}}
            <tr class="hover:bg-slate-50 transition">

                <td class="px-4 py-3">
                    {{ $move->created_at->format('d/m/Y') }}
                </td>

                <td class="px-4 py-3 font-medium">
                    @if($move->type === 'request')
                        Solicitud de entrega
                    @elseif($move->type === 'delivery')
                        Entrega
                    @elseif($move->type === 'commission')
                        Comisión
                    @elseif($move->type === 'payment')
                        Pago
                    @endif
                </td>

                <td class="px-4 py-3 text-red-600 font-semibold">
                    @if($move->type === 'payment')
                        ${{ number_format($move->amount, 2) }}
                    @else
                        —
                    @endif
                </td>

                <td class="px-4 py-3 text-emerald-600 font-semibold">
                    @if(in_array($move->type, ['delivery','commission']))
                        ${{ number_format($move->amount, 2) }}
                    @else
                        —
                    @endif
                </td>

                <td class="px-4 py-3 font-bold 
                    @if($move->balance_after < 0) text-emerald-600 
                    @else text-red-600 
                    @endif">
                    ${{ number_format(abs($move->balance_after), 2) }}
                </td>

                <td class="px-4 py-3 space-y-2">

                    {{-- Estados --}}
                    @if(in_array($move->type, ['delivery','commission']))
                        <span class="block px-4 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-sm">
                            Aprobado
                        </span>
                    @elseif($move->type === 'request')
                        <span class="block px-4 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold text-sm">
                            Pendiente
                        </span>
                    @elseif($move->type === 'payment')
                        @if($move->status === 'received')
                            <span class="block px-4 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-sm">
                                Recibido
                            </span>
                        @elseif($move->status === 'rejected')
                            <span class="block px-4 py-1 rounded-full bg-red-100 text-red-700 font-semibold text-sm">
                                Rechazado
                            </span>
                        @else
                            <span class="block px-4 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold text-sm">
                                Enviado
                            </span>
                        @endif
                    @endif

                    {{-- Botón detalle --}}
                    <button 
                        @click="rowOpen = !rowOpen"
                        class="text-indigo-600 text-sm underline">
                        Ver detalle
                    </button>

                </td>
            </tr>

            {{-- ================= FILA DESPLEGABLE ================= --}}
            <tr x-show="rowOpen" x-transition>
                <td colspan="6" class="bg-gray-50 p-6 text-left">

                    {{-- ================= DETALLE ENTREGA ================= --}}
                    @if(in_array($move->type, ['delivery','commission']))

                        <h3 class="font-bold text-indigo-700 mb-3">
                            Detalle de la Entrega
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p><strong>Monto:</strong> ${{ number_format($move->loan->amount ?? 0,2) }}</p>
                                <p><strong>Comisión:</strong> ${{ number_format($move->loan->commission ?? 0,2) }}</p>
                                <p><strong>Total:</strong> ${{ number_format($move->loan->total ?? 0,2) }}</p>
                            </div>

                            <div>
                                <p><strong>Fecha Solicitud:</strong><br>
                                    {{ optional($move->loan->created_at)->format('d/m/Y h:i A') }}
                                </p>
                                <p><strong>Fecha Entrega:</strong><br>
                                    {{ optional($move->loan->updated_at)->format('d/m/Y h:i A') }}
                                </p>
                            </div>
                        </div>

                    @endif

                    {{-- ================= DETALLE PAGO ================= --}}
                    @if($move->type === 'payment')

                        <h3 class="font-bold text-emerald-700 mb-3">
                            Detalle del Pago
                        </h3>

                        <div class="grid md:grid-cols-2 gap-6">

                            <div>
                                <p><strong>Monto:</strong> ${{ number_format($move->payment->amount ?? 0,2) }}</p>
                                <p><strong>Concepto:</strong> {{ $move->payment->concept ?? '-' }}</p>
                                <p><strong>Fecha envío:</strong><br>
                                    {{ optional($move->payment->created_at)->format('d/m/Y h:i A') }}
                                </p>

                                <p><strong>Fecha Entrega:</strong><br>
                                    {{ optional($move->payment->updated_at)->format('d/m/Y h:i A') }}
                                </p>
                            </div> 

                                @if($move->payment && $move->payment->receipt)

                                    <div class="mt-3">
                                        <p class="font-semibold mb-2">Comprobante:</p>

                                        <img 
                                            src="{{ route('user.receipt', $move->payment) }}"
                                            @click="imageUrl = $el.src; modalOpen = true"
                                            class="w-40 rounded-lg border shadow cursor-pointer hover:scale-105 transition duration-200">
                                    </div>

                                @endif
                            

                        </>

                    @endif

                </td>
            </tr>

        </tbody>
        @endforeach

    </table>

    {{-- ================= MODAL IMAGEN ================= --}}
    <div 
        x-show="modalOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        @click.self="modalOpen = false"
        @keydown.escape.window="modalOpen = false"
        style="display:none;"
    >
        <div class="relative">

            <button 
                @click="modalOpen = false"
                class="absolute -top-10 right-0 text-white text-4xl font-bold hover:scale-110 transition">
                ✕
            </button>

            <img 
                :src="imageUrl"
                class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-2xl">

        </div>
    </div>

</div>
@if($movements->isEmpty())
<p class="text-center text-gray-500">Sin movimientos</p>
@endif

</div>
</div>
</div>
</x-app-layout>
