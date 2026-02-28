<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Cliente') }}
            </h2>
            <div class="flex space-x-3">
                <div x-data="{ showRates: false }">
                    <button @click="showRates = !showRates" class="inline-flex items-center px-4 py-2 
                            bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                            border border-transparent rounded-md 
                            font-semibold text-xs text-white uppercase tracking-widest 
                            focus:outline-none focus:ring-2 focus:ring-blue-300
                            disabled:opacity-25 transition ease-in-out duration-150">

                        <i class="fas fa-hand-holding-usd mr-2 text-white"></i>
                        {{ __('Solicitar Entrega') }}
                    </button>

                    <div x-show="showRates" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" x-cloak
                        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                        aria-modal="true">

                        <div
                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showRates" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                @click="showRates = false">
                            </div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                aria-hidden="true">&#8203;</span>

                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                            {{ __('Nueva Solicitud de Entrega') }}
                                        </h3>
                                        <button @click="showRates = false" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-times text-xl"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="px-6 py-4 max-h-[70vh] overflow-y-auto bg-white">
                                    @include('user.loan.index')
                                </div>

                                <div class="bg-gray-50 px-6 py-3 flex justify-end border-t border-gray-200">
                                    <button type="button" @click="showRates = false"
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- =====Realizar pagp==== --}}
                <div x-data="{ showRates: false }">
                    <button @click="showRates = !showRates" class="inline-flex items-center px-4 py-2 
                            bg-green-600 hover:bg-green-700 active:bg-green-800
                            border border-transparent rounded-md 
                            font-semibold text-xs text-white uppercase tracking-widest 
                            focus:outline-none focus:ring-2 focus:ring-green-300
                            disabled:opacity-25 transition ease-in-out duration-150">

                        <i class="fas fa-credit-card mr-2"></i>
                        {{ __('Realizar Pago') }}
                    </button>

                    <div x-show="showRates" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" x-cloak
                        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                        aria-modal="true">

                        <div
                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showRates" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                @click="showRates = false">
                            </div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                aria-hidden="true">&#8203;</span>

                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                            {{ __('Realizar Pago Parcial') }}
                                        </h3>
                                        <button @click="showRates = false" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-times text-xl"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="px-6 py-4 max-h-[70vh] overflow-y-auto bg-white">
                                    @include('user.payments.create')
                                </div>

                                <div class="bg-gray-50 px-6 py-3 flex justify-end border-t border-gray-200">
                                    <button type="button" @click="showRates = false"
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Dashboard Financiero') }}</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Gestión y seguimiento de entregas y pagos de dinero realizadas') }}
                        </p>
                    </div>

                    {{-- ================= FILTRO ================= --}}
                    <div class="bg-gray-100 rounded-2xl p-4 shadow-inner">

                        <form method="GET" action="{{ route('user.loan') }}"
                            class="flex flex-wrap md:flex-nowrap gap-6 items-end">

                            <!-- Desde -->
                            <div class="flex flex-col w-full md:w-64">
                                <label class="text-sm text-gray-600 mb-2">Desde</label>
                                <input type="date" name="from" value="{{ request('from') }}"
                                    class="bg-white border border-gray-200 rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </div>

                            <!-- Hasta -->
                            <div class="flex flex-col w-full md:w-64">
                                <label class="text-sm text-gray-600 mb-2">Hasta</label>
                                <input type="date" name="to" value="{{ request('to') }}"
                                    class="bg-white border border-gray-200 rounded-xl px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            </div>

                            <!-- Botón -->
                            <div>
                                <button
                                    class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition shadow-md">
                                    Filtrar
                                </button>
                            </div>

                            <!-- Limpiar -->
                            <div>
                                <a href="{{ route('user.loan') }}" class="text-gray-500 underline text-sm">
                                    Limpiar
                                </a>
                            </div>

                        </form>
                    </div>

                    <div class="mb-6">
                    </div>

                    {{-- ================= MOVIMIENTOS ================= --}}
                    @php

                        /* ================================
                            MOVIMIENTOS CON FILTRO
                        ================================ */

                        $movements = \App\Models\LoanMovement::with('loan', 'payment')
                            ->whereHas('loan', function ($q) {
                                $q->where('user_id', auth()->id());
                            })
                            ->when(request('from'), fn($q) => $q->whereDate('created_at', '>=', request('from')))
                            ->when(request('to'), fn($q) => $q->whereDate('created_at', '<=', request('to')))
                            ->orderBy('created_at') // ASC
                            ->get();


                        /* ================================
                            ÚLTIMO REQUEST (sin comisión)
                        ================================ */

                        $lastRequest = $movements
                            ->where('type', 'request')
                            ->last();

                        $montoSolicitadoUsuario = $lastRequest->amount ?? 0;


                        /* ================================
                            ÚLTIMA ENTREGA REAL
                        ================================ */

                        $lastDelivery = $movements
                            ->where('type', 'delivery')
                            ->last();

                        $montoUltimaEntrega = $lastDelivery->amount ?? 0;


                        /* ================================
                            SALDO REAL ACTUAL
                        ================================ */

                        $saldoTotalCard = optional($movements->last())->balance_after ?? 0;


                        /* ================================
                            TOTAL SOLICITUDES
                        ================================ */

                        $totalSolicitudes = $movements
                            ->where('type', 'request')
                            ->sum('amount');


                        /* ================================
                            TOTAL ENTREGADO (histórico)
                        ================================ */

                        $totalEntregado = $movements
                            ->where('type', 'delivery')
                            ->sum('amount');


                        /* ================================
                            CÁLCULO MANUAL DE SALDO (opcional)
                        ================================ */

                        $saldoTotal = 0;

                        foreach ($movements as $move) {

                            // 1️⃣ Entrega suma
                            if ($move->type === 'delivery') {
                                $saldoTotal += $move->amount;
                            }

                            // 2️⃣ Comisión suma
                            if ($move->type === 'commission') {
                                $saldoTotal += $move->amount;
                            }

                            // 3️⃣ Pago resta
                            if ($move->type === 'payment') {
                                $saldoTotal -= $move->amount;
                            }
                        }

                    @endphp

                    {{-- ===== RESUMEN ===== --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                        {{-- MONTO SOLICITADO --}}
                        <div
                            class="bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-slate-200 p-3 rounded-full">
                                        <i class="fas fa-hand-holding-usd text-slate-600 text-xl"></i>
                                    </div>
                                    <span
                                        class="text-xs font-medium text-slate-600 bg-slate-200 px-2 py-1 rounded-full">
                                        Solicitud
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">
                                    Monto Solicitado
                                </p>
                                <p class="text-2xl font-bold text-slate-800">
                                    ${{ number_format($montoSolicitadoUsuario ?? 0, 2) }}
                                </p>
                            </div>
                        </div>


                        {{-- MONTO ENTREGADO --}}
                        <div
                            class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-hand-holding-usd text-blue-600 text-xl"></i>
                                    </div>
                                    <span class="text-xs font-medium text-blue-700 bg-blue-100 px-3 py-1 rounded-full">
                                        Entregado
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">
                                    Ultimo Monto Entregado
                                </p>
                                <p class="text-2xl font-bold text-blue-700">
                                    ${{ number_format($montoUltimaEntrega, 2) }}
                                </p>
                            </div>
                        </div>


                        {{-- SALDO ACTUAL --}}
                        <div
                            class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-green-100 p-3 rounded-full">
                                        <i class="fas fa-wallet text-green-600 text-xl"></i>
                                    </div>
                                    <span
                                        class="text-xs font-medium bg-green-100 text-green-600 px-2 py-1 rounded-full">
                                        Saldo
                                    </span>
                                </div>

                                <p class="text-sm font-medium text-gray-600 mb-1">
                                    Saldo actual
                                </p>

                                <p class="text-2xl font-bold 
                @if($saldoTotalCard > 0) 
                    text-red-600 
                @else 
                    text-green-700 
                @endif">
                                    ${{ number_format(abs($saldoTotalCard ?? 0), 2) }}
                                </p>
                            </div>
                        </div>

                    </div>


                    {{-- ===== HISTORIAL ===== --}}
                    <div class="mt-8">

                        <!-- Título -->
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">
                                Historial de Pagos
                            </h2>
                            <p class="text-sm text-gray-600">
                                Mostrando pagos
                            </p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">

                            <div class="overflow-x-auto">

                                <table class="min-w-full divide-y divide-gray-200 text-sm">

                                    <!-- HEADER -->
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Fecha
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Movimiento
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Cargo
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Abono
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Saldo Total
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Estado
                                            </th>
                                        </tr>
                                    </thead>

                                    <!-- BODY -->
                                    @foreach($movements as $move)
                                                <tbody x-data="{ rowOpen: false }" class="bg-white divide-y divide-gray-200">

                                                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                            {{ $move->created_at->format('d/m/Y') }}
                                                        </td>

                                                        <td class="px-6 py-4 font-medium text-gray-900">
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

                                                        <td class="px-6 py-4 font-semibold text-red-600">
                                                            @if($move->type === 'payment')
                                                                ${{ number_format($move->amount, 2) }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        <td class="px-6 py-4 font-semibold text-emerald-600">
                                                            @if(in_array($move->type, ['delivery', 'commission']))
                                                                ${{ number_format($move->amount, 2) }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        <td class="px-6 py-4 font-bold 
                                        @if($move->balance_after < 0) text-emerald-600 
                                        @else text-red-600 
                                        @endif">
                                                            ${{ number_format(abs($move->balance_after), 2) }}
                                                        </td>

                                                        <td class="px-6 py-4 space-y-2">

                                                            @if(in_array($move->type, ['delivery', 'commission']))
                                                                <span
                                                                    class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                                                    Aprobado
                                                                </span>

                                                            @elseif($move->type === 'request')
                                                                <span
                                                                    class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                                                    Pendiente
                                                                </span>

                                                            @elseif($move->type === 'payment')

                                                                @if($move->status === 'received')
                                                                    <span
                                                                        class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                                                        Recibido
                                                                    </span>

                                                                @elseif($move->status === 'rejected')
                                                                    <span
                                                                        class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                                        Rechazado
                                                                    </span>

                                                                @else
                                                                    <span
                                                                        class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                                                        Enviado
                                                                    </span>
                                                                @endif

                                                            @endif

                                                            <div>
                                                                <button @click="rowOpen = !rowOpen"
                                                                    class="text-indigo-600 text-xs font-medium hover:text-indigo-800 transition">
                                                                    Ver detalle
                                                                </button>
                                                            </div>

                                                        </td>

                                                    </tr>

                                                    {{-- ================= FILA DESPLEGABLE ================= --}}
                                                    <tr x-show="rowOpen" x-transition>
                                                        <td colspan="6" class="bg-gray-50 p-6 text-left">

                                                            {{-- ================= DETALLE ENTREGA ================= --}}
                                                            @if(in_array($move->type, ['delivery', 'commission']))

                                                                <h3 class="font-bold text-indigo-700 mb-3">
                                                                    Detalle de la Entrega
                                                                </h3>

                                                                <div class="grid md:grid-cols-2 gap-6">
                                                                    <div>
                                                                        <p><strong>Monto:</strong>
                                                                            ${{ number_format($move->loan->amount ?? 0, 2) }}</p>
                                                                        <p><strong>Comisión:</strong>
                                                                            ${{ number_format($move->loan->commission ?? 0, 2) }}</p>
                                                                        <p><strong>Total:</strong>
                                                                            ${{ number_format($move->loan->total ?? 0, 2) }}</p>
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
                                                                        <p><strong>Monto:</strong>
                                                                            ${{ number_format($move->payment->amount ?? 0, 2) }}</p>
                                                                        <p><strong>Concepto:</strong>
                                                                            {{ $move->payment->concept ?? '-' }}</p>
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

                                                                            <img src="{{ route('user.receipt', $move->payment) }}"
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

                            </div>

                        </div>

                    </div>

                    {{-- ================= MODAL IMAGEN ================= --}}
                    <div x-show="modalOpen" x-transition.opacity
                        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
                        @click.self="modalOpen = false" @keydown.escape.window="modalOpen = false"
                        style="display:none;">
                        <div class="relative">

                            <button @click="modalOpen = false"
                                class="absolute -top-10 right-0 text-white text-4xl font-bold hover:scale-110 transition">
                                ✕
                            </button>

                            <img :src="imageUrl" class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-2xl">

                        </div>
                    </div>

                    @if($movements->isEmpty())
                        <p class="text-center text-gray-500">Sin movimientos</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>