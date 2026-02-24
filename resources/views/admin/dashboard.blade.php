<x-app-layout>
<div class="py-10 max-w-7xl mx-auto px-4">

<h1 class="text-3xl font-bold mb-10">Panel de Administración</h1>

{{-- ===================== CARDS ===================== --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-600">
        <p class="text-gray-500 text-base">Total Entregas</p>
        <h2 class="text-3xl font-bold text-slate-800 mt-2">
            {{ \App\Models\Loan::count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
        <p class="text-gray-500 text-base">Aprobados</p>
        <h2 class="text-3xl font-bold text-blue-600 mt-2">
            {{ \App\Models\Loan::where('status','approved')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
        <p class="text-gray-500 text-base">Pendientes</p>
        <h2 class="text-3xl font-bold text-yellow-500 mt-2">
            {{ \App\Models\Loan::where('status','pending')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
        <p class="text-gray-500 text-base">Rechazados</p>
        <h2 class="text-3xl font-bold text-slate-600 mt-2">
            {{ \App\Models\Loan::where('status','rejected')->count() }}
        </h2>
    </div>

</div>

{{-- Acciones rápidas --}}
<div class="flex flex-wrap gap-6 mb-12">

<div x-data="{ showRates:false }">

<button
@click="showRates=!showRates"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 flex items-center gap-3">

    <img src="{{ asset('images/tasas.png') }}" 
         alt="Icono Tasas" 
         class="w-8 h-8 brightness-0 invert">

    Tasas de interés
</button>

<div 
x-show="showRates" 
x-transition.scale
x-cloak
class="mt-8 bg-white p-8 rounded-2xl shadow-xl border">

@include('admin.interest_rates.index')

</div>

</div>

<div>
<a href="{{ route('admin.payments') }}"
class="bg-indigo-600 hover:bg-blue-800 text-white px-8 py-3 rounded-xl shadow-md hover:shadow-xl transition duration-300 inline-flex items-center gap-3 focus:outline-none focus:ring-0">

    <img src="{{ asset('images/pagos.png') }}" 
         alt="Icono Pagos" 
         class="w-8 h-8 brightness-0 invert">

    Ver Pagos Parciales
</a>

</div>

</div>

{{-- ===================== TABLA PRINCIPAL ===================== --}}
<div class="bg-white rounded-xl shadow-lg overflow-hidden">

<div class="overflow-x-auto">
<table class="min-w-full">

<thead class="bg-slate-800 text-white">
<tr>
<th class="px-4 py-3">Entrega</th>
<th class="px-4 py-3">Interés</th>
<th class="px-4 py-3">Comisión</th>
<th class="px-4 py-3">Monto Total</th>
<th class="px-4 py-3">Estado</th>
<th class="px-4 py-3">Acciones</th>
</tr>
</thead>

<tbody class="divide-y">

@foreach(\App\Models\Loan::with('interestRate')->latest()->get() as $loan)

@php
$rate = $loan->interestRate->rate ?? 0;
$commission = $loan->amount * ($rate / 100);
$total = $loan->amount + $commission;
@endphp

<tr class="hover:bg-gray-50 text-center">

<td class="px-4 py-3 font-semibold">
${{ number_format($loan->amount,2) }}
</td>

<td class="px-4 py-3">
{{ $rate }}%
</td>

<td class="px-4 py-3 font-semibold text-orange-600">
${{ number_format($commission,2) }}
</td>

<td class="px-4 py-3 font-bold text-indigo-600">
${{ number_format($total,2) }}
</td>

<td class="px-4 py-3">
@if($loan->status == 'pending')
<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
Pendiente
</span>
@elseif($loan->status == 'approved')
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
Aprobado
</span>
@else
<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
Rechazado
</span>
@endif
</td>

<td class="px-4 py-3 space-x-2">

@if($loan->status == 'pending')

<form action="{{ route('loans.approve', $loan) }}" method="POST" class="inline">
@csrf
<button class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-lg">
Aprobar
</button>
</form>

<form action="{{ route('loans.reject', $loan) }}" method="POST" class="inline">
@csrf
<button class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded-lg">
Rechazar
</button>
</form>

@endif

</td>

</tr>

@endforeach

</tbody>
</table>
</div>
</div>

{{-- ===================== RESUMEN GENERAL ===================== --}}

@php
$totalEntregado = \App\Models\LoanMovement::where('type','delivery')->sum('amount');

$totalComisiones = \App\Models\LoanMovement::where('type','commission')->sum('amount');

$totalPagos = \App\Models\LoanMovement::where('type','payment')
                ->where('status','received')
                ->sum('amount');

$totalConComision = $totalEntregado + $totalComisiones;

$saldoGlobal = $totalConComision - $totalPagos;
@endphp

<div class="mt-16 bg-white rounded-2xl shadow-2xl overflow-hidden border">

<div class="bg-slate-900 text-white px-6 py-4">
<h2 class="text-xl font-bold tracking-wide">
Resumen General de Entregas
</h2>
</div>

<div class="overflow-x-auto">
<table class="min-w-full text-center">

<thead class="bg-slate-800 text-white text-sm uppercase">
<tr>
<th class="px-6 py-4">Total Entregado</th>
<th class="px-6 py-4">Total Comisiones</th>
<th class="px-6 py-4">Total + Comisión</th>
</tr>
</thead>

<tbody class="text-lg font-semibold divide-y">
<tr class="bg-gray-50 hover:bg-gray-100 transition">

<td class="px-6 py-5 text-blue-600">
${{ number_format($totalEntregado,2) }}
</td>

<td class="px-6 py-5 text-orange-600">
${{ number_format($totalComisiones,2) }}
</td>

<td class="px-6 py-5 font-bold 
@if($saldoGlobal > 0)
text-red-600
@else
text-green-600
@endif">
${{ number_format($totalConComision,2) }}
</td>

</tr>
</tbody>

</table>
</div>
</div>

</div>
</x-app-layout>