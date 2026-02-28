<x-app-layout>

    <div class="max-w-7xl mx-auto py-10 px-4">

        <h1 class="text-3xl font-bold mb-8 text-slate-700">
            Pagos Parciales
        </h1>

        {{-- MENSAJES AUTO OCULTABLES --}}
        @if(session('success'))
            <div x-data="{ show:true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" x-transition
                class="bg-green-100 text-green-700 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show:true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" x-transition
                class="bg-red-100 text-red-700 p-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-2xl p-8 space-y-10">
            <div>
                <div class="mb-8">

                    <!-- Título -->
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Gestión de Pagos
                        </h2>
                        <p class="text-sm text-gray-600">
                            Mostrando pagos registrados
                        </p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">

                        <div x-data="{ open:false, imageUrl:'' }">

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">

                                    <!-- HEADER -->
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Cliente</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Monto</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Concepto</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Comprobante</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Estado</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Acciones</th>
                                        </tr>
                                    </thead>

                                    <!-- BODY -->
                                    <tbody class="bg-white divide-y divide-gray-200">

                                        @forelse($payments as $payment)

                                            <tr class="hover:bg-gray-50 transition-colors duration-150">

                                                <!-- Cliente -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $payment->user->name }}
                                                </td>

                                                <!-- Monto -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                                    ${{ number_format($payment->amount, 2) }}
                                                </td>

                                                <!-- Concepto -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                    {{ $payment->concept }}
                                                </td>

                                                <!-- Comprobante -->
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <img src="{{ route('admin.receipt', $payment) }}"
                                                        @click="open=true; imageUrl=$el.src"
                                                        class="w-20 rounded-lg border shadow cursor-pointer hover:scale-105 transition duration-200">
                                                </td>

                                                <!-- Estado -->
                                                <td class="px-6 py-4 whitespace-nowrap">

                                                    @if($payment->status == 'received')
                                                        <span
                                                            class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                            Recibido
                                                        </span>

                                                    @elseif($payment->status == 'not_received')
                                                        <span
                                                            class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                            No recibido
                                                        </span>

                                                    @else
                                                        <span
                                                            class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                            Pendiente
                                                        </span>
                                                    @endif

                                                </td>

                                                <!-- Acciones -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">

                                                    @if($payment->status == 'sent')

                                                        <div class="flex space-x-2">

                                                            <form action="{{ route('admin.payment.confirm', $payment) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button onclick="return confirm('¿Confirmar este pago?')"
                                                                    class="px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition-colors">
                                                                    Confirmar
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('admin.payment.reject', $payment) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button onclick="return confirm('¿Rechazar este pago?')"
                                                                    class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition-colors">
                                                                    Rechazar
                                                                </button>
                                                            </form>

                                                        </div>

                                                    @else
                                                        <span class="text-gray-400 text-xs">
                                                            Procesado
                                                        </span>
                                                    @endif

                                                </td>

                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                                    No hay pagos registrados
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>
                            </div>

                            <!-- MODAL IMAGEN -->
                            <div x-show="open" x-transition.opacity @click.self="open=false"
                                class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
                                style="display:none;">

                                <div class="relative">

                                    <button @click="open=false"
                                        class="absolute -top-10 right-0 text-white text-4xl font-bold">
                                        ✕
                                    </button>

                                    <img :src="imageUrl" class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ================= RESUMEN DE ENTREGAS ================= --}}
                <div class="mb-8">

                    <!-- Título -->
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Resumen General de Entregas
                        </h2>
                        <p class="text-sm text-gray-600">
                            Consolidado financiero actual
                        </p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">

                                <!-- HEADER -->
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Entregado
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Comisiones
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Entregado + Comisión
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Pagos Recibidos
                                        </th>
                                    </tr>
                                </thead>

                                <!-- BODY -->
                                <tbody class="bg-white divide-y divide-gray-200">

                                    <tr class="hover:bg-gray-50 transition-colors duration-150 font-semibold text-base">

                                        <td class="px-6 py-4 text-indigo-600">
                                            ${{ number_format($totalEntregado, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-purple-600">
                                            ${{ number_format($totalComisiones, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-blue-600">
                                            ${{ number_format($totalConComision, 2) }}
                                        </td>

                                        <td class="px-6 py-4 text-green-600">
                                            ${{ number_format($totalPagosRecibidos, 2) }}
                                        </td>

                                    </tr>

                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>