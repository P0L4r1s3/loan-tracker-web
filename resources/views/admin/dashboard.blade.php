<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Administración') }}
            </h2>
            <div class="flex space-x-3">
                <div x-data="{ showRates: false }">
                    <button @click="showRates = !showRates" 
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-percentage mr-2"></i>
                        {{ __('Comisión Porcentual') }}
                    </button>

                    <div x-show="showRates" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         x-cloak
                         class="fixed inset-0 z-50 overflow-y-auto" 
                         aria-labelledby="modal-title" 
                         role="dialog" 
                         aria-modal="true">
                        
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showRates" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                 @click="showRates = false">
                            </div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                            {{ __('Configuración de Comisiones') }}
                                        </h3>
                                        <button @click="showRates = false" class="text-gray-400 hover:text-gray-500">
                                            <i class="fas fa-times text-xl"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="px-6 py-4 max-h-[70vh] overflow-y-auto bg-white">
                                    @include('admin.interest_rates.index')
                                </div>

                                <div class="bg-gray-50 px-6 py-3 flex justify-end border-t border-gray-200">
                                    <button type="button" 
                                            @click="showRates = false"
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.payments') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-credit-card mr-2"></i>
                    {{ __('Ver Pagos Parciales') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @php
                        // OBTENER CONTEO RÁPIDO
                        $totalEntregas = DB::table('loans')->count();
                        $aprobados = DB::table('loans')->where('status', 'approved')->count();
                        $pendientes = DB::table('loans')->where('status', 'pending')->count();
                        $rechazados = DB::table('loans')->where('status', 'rejected')->count();
                        
                        // OBTENER SOLO 20 REGISTROS (NO TODOS)
                        $loans = DB::table('loans')
                            ->leftJoin('interest_rates', 'loans.interest_rate_id', '=', 'interest_rates.id')
                            ->select('loans.*', 'interest_rates.rate as interest_rate_rate')
                            ->orderBy('loans.created_at', 'desc')
                            ->limit(20)
                            ->get();
                        
                        // MOVEMENTS
                        $totalEntregado = DB::table('loan_movements')->where('type', 'delivery')->sum('amount') ?? 0;
                        $totalComisiones = DB::table('loan_movements')->where('type', 'commission')->sum('amount') ?? 0;
                        $totalPagos = DB::table('loan_movements')->where('type', 'payment')->where('status', 'received')->sum('amount') ?? 0;
                        $totalConComision = $totalEntregado + $totalComisiones;
                        $saldoGlobal = $totalConComision - $totalPagos;
                    @endphp

                    <div class="mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Dashboard Financiero') }}</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Gestión y seguimiento de todas las entregas de dinero realizadas') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-gray-200 p-3 rounded-full">
                                        <i class="fas fa-hand-holding-usd text-gray-600 text-xl"></i>
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 bg-gray-200 px-2 py-1 rounded-full">Total</span>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Entregas</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalEntregas }}</p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-green-100 p-3 rounded-full">
                                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                    </div>
                                    <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">Aprobados</span>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Aprobados</p>
                                <p class="text-2xl font-bold text-green-700">{{ $aprobados }}</p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-yellow-100 p-3 rounded-full">
                                        <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                                    </div>
                                    <span class="text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Pendientes</span>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Pendientes</p>
                                <p class="text-2xl font-bold text-yellow-700">{{ $pendientes }}</p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex flex-col">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="bg-red-100 p-3 rounded-full">
                                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                    </div>
                                    <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-1 rounded-full">Rechazados</span>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Rechazados</p>
                                <p class="text-2xl font-bold text-red-700">{{ $rechazados }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Listado de Entregas de Dinero') }}</h2>
                            <p class="text-sm text-gray-600">{{ __('Mostrando las últimas 20 entregas') }}</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrega</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comisión Porcentual</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comisión</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Total</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($loans as $loan)
                                            @php
                                                $rate = $loan->interest_rate_rate ?? 0;
                                                $commission = $loan->amount * ($rate / 100);
                                                $total = $loan->amount + $commission;
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-hand-holding-usd text-indigo-600"></i>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                Entrega #{{ $loan->id }}
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ \Carbon\Carbon::parse($loan->created_at)->format('d/m/Y H:i') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                                        {{ $rate }}%
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-600 font-medium">
                                                    ${{ number_format($commission,2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                                    ${{ number_format($total,2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($loan->status == 'pending')
                                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                            Pendiente
                                                        </span>
                                                    @elseif($loan->status == 'approved')
                                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                            Aprobado
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                            Rechazado
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($loan->status == 'pending')
                                                        <div class="flex space-x-2">
                                                            <form action="{{ route('loans.approve', $loan->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition-colors"
                                                                        onclick="return confirm('¿Aprobar esta entrega?')">
                                                                    Aprobar
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('loans.reject', $loan->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                        class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition-colors"
                                                                        onclick="return confirm('¿Rechazar esta entrega?')">
                                                                    Rechazar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 text-xs">Sin acciones</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                                    No hay entregas registradas
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center">
                            <i class="fas fa-chart-pie text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-blue-700">
                                    <span class="font-medium">{{ __('Resumen General de Entregas') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 shadow-sm">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-blue-100 p-3 rounded-full mb-3">
                                    <i class="fas fa-hand-holding-usd text-blue-600 text-xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Entregado</p>
                                <p class="text-2xl font-bold text-blue-700">${{ number_format($totalEntregado,2) }}</p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-6 shadow-sm">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-amber-100 p-3 rounded-full mb-3">
                                    <i class="fas fa-percentage text-amber-600 text-xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Comisiones</p>
                                <p class="text-2xl font-bold text-amber-700">${{ number_format($totalComisiones,2) }}</p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 border border-green-600 rounded-xl p-6 shadow-sm">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-white bg-opacity-20 p-3 rounded-full mb-3">
                                    <i class="fas fa-coins text-white text-xl"></i>
                                </div>
                                <p class="text-sm font-medium text-white mb-1">Total + Comisión</p>
                                <p class="text-2xl font-bold text-white">${{ number_format($totalConComision,2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Saldo Global</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-gray-100 p-3 rounded-full mr-4">
                                        <i class="fas fa-scale-balanced text-gray-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Saldo Global</p>
                                        <p class="text-2xl font-bold {{ $saldoGlobal > 0 ? 'text-red-600' : 'text-green-600' }}">
                                            ${{ number_format($saldoGlobal,2) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Total Pagos</p>
                                    <p class="text-xl font-bold text-green-600">${{ number_format($totalPagos,2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>