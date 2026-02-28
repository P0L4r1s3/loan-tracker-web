<div x-data="{ showForm:false }"  class="max-w-1xl mx-auto">

<div class="flex justify-between items-center mb-4">
<h2 class="text-xl font-semibold">Comisiones registradas</h2>

<button
 @click="showForm = !showForm"
 class="bg-green-600 hover:bg-green-700 text-white w-10 h-10 rounded-full text-2xl flex items-center justify-center shadow">
+
</button>
</div>

<!-- Formulario oculto -->
<form 
    x-show="showForm"
    x-transition
    method="POST" 
    action="{{ route('interest-rates.store') }}" 
    class="flex gap-2 mb-4">
@csrf

<div class="w-1/2">
    <input 
        name="name" 
        placeholder="Nombre"
        value="{{ old('name') }}"
        required
        class="border p-2 rounded w-full @error('name') border-red-500 @enderror">

    @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="w-1/4">
    <input 
        name="rate" 
        type="number" 
        step="0.01"
        min="0"
        placeholder="%"
        value="{{ old('rate') }}"
        required
        class="border p-2 rounded w-full @error('rate') border-red-500 @enderror">

    @error('rate')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<button type="submit"
 class="bg-green-600 hover:bg-green-700 text-white px-4 rounded shadow">
Agregar
</button>

</form>

<!-- Tabla -->
<table class="max-w-3xl w-full mx-auto border rounded">

<thead class="bg-gray-100">
<tr>
<th class="p-2">Nombre</th>
<th class="p-2">Tasa</th>
<th class="p-2">Fecha</th>
<th class="p-2 text-right">Acciones</th>
</tr>
</thead>

<tbody>
@foreach(\App\Models\InterestRate::all() as $rate)

<tr class="border-t" x-data="{ editing:false }">

<!-- NOMBRE -->
<td class="p-2">
    <span x-show="!editing" class="block">
        {{ $rate->name }}
    </span>

    <form x-show="editing"
          method="POST"
          action="{{ route('interest-rates.update',$rate) }}"
          class="flex gap-2">
        @csrf
        @method('PUT')

        <input 
            name="name"
            value="{{ $rate->name }}"
            class="border p-1 rounded w-32"
            required>

        <button type="submit"
            x-show="editing"
            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded shadow">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 13l4 4L19 7"/>
            </svg>
        </button>

        <!-- CANCELAR -->
        <button 
            type="button"
            x-show="editing"
            @click="editing = false"
            class="bg-gray-500 hover:bg-gray-600 text-white p-2 rounded shadow">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </form>
</td>

<!-- TASA SOLO LECTURA -->
<td class="p-2 font-semibold">
    {{ $rate->rate }}%
</td>

<!-- FECHA -->
<td class="p-2 font-semibold">
    {{ $rate->created_at->format('d/m/Y') }}
</td>

<!-- ACCIONES -->
<td class="p-2 text-right flex justify-end gap-2">

    <!-- EDITAR -->
    <button 
            type="button"
        x-show="!editing"
        @click="editing = true"
        class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded shadow">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M11 5h2m2 0h.01M4 21h4l11-11a2.828 2.828 0 00-4-4L4 17v4z"/>
        </svg>
    </button>

    <!-- ELIMINAR 
    <form method="POST"
          action="{{ route('interest-rates.destroy',$rate) }}">
        @csrf
        @method('DELETE')

        <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded shadow">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4"/>
            </svg>
        </button>
    </form> -->

</td>

</tr>

@endforeach
</tbody>


</table>


</div>
