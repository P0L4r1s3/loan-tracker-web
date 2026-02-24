<div x-data="{ showForm:false }"  class="max-w-1xl mx-auto">

<div class="flex justify-between items-center mb-4">
<h2 class="text-xl font-semibold">Tasas registradas</h2>

<button
 @click="showForm = !showForm"
 class="bg-green-600 hover:bg-green-700 text-white w-10 h-10 rounded-full text-2xl flex items-center justify-center shadow">
+
</button>
</div>

<!-- Formulario oculto -->
<div x-show="showForm" x-transition class="mb-4">

<form method="POST" action="{{ route('interest-rates.store') }}" class="flex gap-2">
@csrf

<input name="name" placeholder="Nombre"
 class="border p-2 rounded w-1/2">

<input name="rate" type="number" step="0.01"
 placeholder="%"
 class="border p-2 rounded w-1/4">

<button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 rounded">
Agregar
</button>

</form>
</div>

<!-- Tabla -->
<table class="max-w-3xl w-full mx-auto border rounded">

<thead class="bg-gray-100">
<tr>
<th class="p-2">Nombre</th>
<th class="p-2">Tasa</th>
<th class="p-2 text-right">Acciones</th>
</tr>
</thead>

<tbody>
@foreach(\App\Models\InterestRate::all() as $rate)

<tr class="border-t" x-data="{ editing:false }">

<form method="POST" action="{{ route('interest-rates.update',$rate) }}">
@csrf
@method('PUT')

<!-- NOMBRE -->
<td class="p-2">

    <!-- Vista texto -->
    <span x-show="!editing" class="block">
        {{ $rate->name }}
    </span>

    <!-- Input edición -->
    <input 
        x-show="editing"
        name="name"
        value="{{ $rate->name }}"
        class="border p-1 rounded w-32">

</td>

<!-- TASA -->
<td class="p-2">

    <!-- Vista texto con % -->
    <span x-show="!editing" class="block font-semibold">
        {{ $rate->rate }}%
    </span>

    <!-- Input edición -->
    <input 
        x-show="editing"
        name="rate"
        type="number"
        step="0.01"
        value="{{ $rate->rate }}"
        class="border p-1 rounded w-32">

</td>

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


<!-- ACTUALIZAR -->
<button 
 x-show="editing"
 class="bg-green-600 hover:bg-green-700 text-white p-2 rounded shadow">

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M5 13l4 4L19 7"/>
</svg>
</button>


<!-- ELIMINAR -->
<form method="POST" action="{{ route('interest-rates.destroy',$rate) }}">
@csrf
@method('DELETE')

<button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded shadow">

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4"/>
</svg>
</button>

</form>

</td>

</tr>



@endforeach
</tbody>


</table>


</div>
