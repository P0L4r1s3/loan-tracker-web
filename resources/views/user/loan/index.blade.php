<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="text-xl font-semibold">
            Nueva Solicitud de Entrega
        </h2>
        <p class="text-sm text-gray-500">
            Completa el monto para realizar tu solicitud
        </p>
    </div>

    @php
        $latestRate = \App\Models\InterestRate::latest()->first();
    @endphp

    {{-- FORMULARIO SIEMPRE VISIBLE --}}
    <form 
        method="POST" 
        action="{{ route('loans.store') }}"
        class="bg-white border rounded-xl shadow-sm p-6 flex flex-wrap gap-4 items-end">

        @csrf

        {{-- MONTO --}}
        <div class="w-full md:w-1/3">
            <label class="block text-sm text-gray-600 mb-1">
                Monto solicitado
            </label>
            <input 
                type="number"
                name="amount"
                required
                placeholder="Ej: 5000"
                class="border p-2 rounded w-full focus:ring-2 focus:ring-indigo-400">
        </div>

        {{-- TASA --}}
        <div class="w-full md:w-1/4">
            <label class="block text-sm text-gray-600 mb-1">
                Comisión aplicada
            </label>
            <input 
                type="text"
                value="{{ $latestRate->rate ?? 0 }}%"
                disabled
                class="border p-2 rounded w-full bg-gray-100 font-semibold text-center">
        </div>

        {{-- ID OCULTO --}}
        <input type="hidden" 
               name="interest_rate_id"
               value="{{ $latestRate->id ?? '' }}">

        {{-- BOTÓN --}}
        <div>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md shadow transition">
                Solicitar
            </button>
        </div>

    </form>

</div>