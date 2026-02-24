<x-app-layout>

<div class="max-w-7xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold mb-8 text-slate-700">
        Gestion de Pagos
    </h1>

    {{-- MENSAJES AUTO OCULTABLES --}}
    @if(session('success'))
        <div 
            x-data="{ show:true }"
            x-init="setTimeout(() => show = false, 8000)"
            x-show="show"
            x-transition
            class="bg-green-100 text-green-700 p-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div 
            x-data="{ show:true }"
            x-init="setTimeout(() => show = false, 8000)"
            x-show="show"
            x-transition
            class="bg-red-100 text-red-700 p-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif


    <div class="bg-white shadow rounded-lg overflow-hidden">

        <div x-data="{ open:false, imageUrl:'' }">

            <table class="min-w-full text-sm">

                <thead class="bg-slate-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Cliente</th>
                        <th class="px-4 py-3 text-left">Monto</th>
                        <th class="px-4 py-3 text-left">Concepto</th>
                        <th class="px-4 py-3 text-left">Comprobante</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                @forelse($payments as $payment)

                    <tr class="hover:bg-gray-50">

                        {{-- Usuario --}}
                        <td class="px-4 py-3">
                            {{ $payment->user->name }}
                        </td>

                        {{-- Monto --}}
                        <td class="px-4 py-3 font-semibold text-blue-600">
                            ${{ number_format($payment->amount,2) }}
                        </td>

                        {{-- Concepto --}}
                        <td class="px-4 py-3">
                            {{ $payment->concept }}
                        </td>

                        {{-- Comprobante --}}
                        <td class="px-4 py-3">
                            <img 
                                src="{{ route('admin.receipt',$payment) }}"
                                @click="open=true; imageUrl=$el.src"
                                class="w-24 rounded-lg border shadow cursor-pointer hover:scale-105 transition duration-200">
                        </td>

                        {{-- ESTADO --}}
                        <td class="px-4 py-3">

                            @if($payment->status == 'received')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ✔ Recibido
                                </span>

                            @elseif($payment->status == 'not_received')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    ✖ No recibido
                                </span>

                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Pendiente
                                </span>
                            @endif

                        </td>

                        {{-- ACCIONES --}}
                        <td class="px-4 py-3">

                            @if($payment->status == 'sent')

                                <div class="flex gap-2">

                                    <form action="{{ route('admin.payment.confirm',$payment) }}"
                                          method="POST">
                                        @csrf
                                        <button
                                            onclick="return confirm('¿Confirmar este pago?')"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs transition">
                                            Confirmar
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.payment.reject',$payment) }}"
                                          method="POST">
                                        @csrf
                                        <button
                                            onclick="return confirm('¿Rechazar este pago?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition">
                                            Rechazar
                                        </button>
                                    </form>

                                </div>

                            @else
                                <span class="text-gray-400 text-xs font-semibold">
                                    Procesado
                                </span>
                            @endif

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            No hay pagos pendientes
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

            

            {{-- MODAL IMAGEN --}}
            <div x-show="open"
                 x-transition.opacity
                 @click.self="open=false"
                 class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
                 style="display:none;">

                <div class="relative">

                    <button @click="open=false"
                            class="absolute -top-10 right-0 text-white text-4xl font-bold">
                        ✕
                    </button>

                    <img :src="imageUrl"
                         class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl">

                </div>

            </div>

        </div>

    </div>

    {{-- ================= RESUMEN DE ENTREGAS ================= --}}
<div class="mt-10 bg-white shadow-xl rounded-xl overflow-hidden border">

    <div class="bg-slate-900 text-white px-6 py-4">
        <h2 class="text-xl font-bold tracking-wide">
             Resumen General de Entregas
        </h2>
    </div>

    <table class="min-w-full text-sm text-center">

        <thead class="bg-slate-800 text-white">
            <tr>
                <th class="px-4 py-3">Total Entregado</th>
                <th class="px-4 py-3">Total Comisiones</th>
                <th class="px-4 py-3">Total Entregado + Comisión</th>
                <th class="px-4 py-3">Total Pagos Recibidos</th>
            </tr>
        </thead>

        <tbody class="divide-y text-base font-semibold">

            <tr class="bg-gray-50 hover:bg-gray-100 transition">

                <td class="px-4 py-4 text-blue-600">
                    ${{ number_format($totalEntregado,2) }}
                </td>

                <td class="px-4 py-4 text-purple-600">
                    ${{ number_format($totalComisiones,2) }}
                </td>

                <td class="px-4 py-4 text-indigo-600">
                    ${{ number_format($totalConComision,2) }}
                </td>

                <td class="px-4 py-4 text-green-600">
                    ${{ number_format($totalPagosRecibidos,2) }}
                </td>

            </tr>

        </tbody>

    </table>

</div>

</div>

</x-app-layout>
