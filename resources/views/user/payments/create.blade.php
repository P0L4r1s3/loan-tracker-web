

    <div class="max-w-3xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-slate-800">
                Realizar Pago
            </h2>
            <p class="text-sm text-gray-500">
                Completa los datos para registrar tu pago
            </p>
        </div>

        {{-- MENSAJE SUCCESS --}}
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-6 border border-green-200">
            {{ session('success') }}
        </div>
        @endif

        {{-- FORMULARIO --}}
        <form action="{{ route('payments.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white border rounded-xl shadow-sm p-6 space-y-5">
            @csrf

            {{-- Monto --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Monto del pago
                </label>
                <input type="number" 
                       step="0.01" 
                       name="amount"
                       placeholder="Ej: 1500"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400"
                       required>
            </div>

            {{-- Concepto --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Concepto del pago
                </label>
                <input type="text" 
                       name="concept"
                       placeholder="Ej: Diamante"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-400"
                       required>
            </div>

            {{-- Comprobante --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Comprobante (imagen)
                </label>
                <input type="file" 
                       name="receipt" 
                       accept="image/*"
                       class="w-full border rounded-lg p-3 bg-white"
                       required>
            </div>

            {{-- BOTÓN --}}
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition shadow-sm">
                    Enviar Pago
                </button>
            </div>

        </form>

    </div>