<div x-data class="max-w-1xl mx-auto">

<div class="flex justify-between items-center mb-4">
<h2 class="text-xl font-semibold">Comisiones registradas</h2>

<button
 @click="showForm = !showForm"
 class="bg-green-600 hover:bg-green-700 text-white w-10 h-10 rounded-full text-2xl flex items-center justify-center shadow">
+
</button>
</div>

<table class="max-w-3xl w-full mx-auto border rounded">

<thead class="bg-gray-100">
<tr>
<th class="p-2">Nombre</th>
<th class="p-2">Comisión</th>
<th class="p-2 text-right">Acciones</th>
</tr>
</thead>

<tbody>
@foreach(\App\Models\Commission::all() as $commission)

<tr class="border-t" x-data="{ editing:false }">

<form method="POST" action="{{ route('commissions.update',$commission) }}">
@csrf
@method('PUT')

<td class="p-2">
<input 
 name="name"
 x-bind:readonly="!editing"
 value="{{ $commission->name }}"
 class="border p-1 rounded w-32"
 :class="editing ? 'bg-white' : 'bg-gray-100 cursor-not-allowed'">
</td>

<td class="p-2">
<input 
 name="amount"
 x-bind:readonly="!editing"
 value="{{ $commission->amount }}"
 class="border p-1 rounded w-32"
 :class="editing ? 'bg-white' : 'bg-gray-100 cursor-not-allowed'">
</td>

<td class="p-2 text-right space-x-2">

<button 
 type="button"
 x-show="!editing"
 @click="editing = true"
 class="bg-blue-500 text-white px-3 py-1 rounded">
Editar
</button>

<button 
 type="button"
 x-show="editing"
 @click="editing = false"
 class="bg-gray-500 text-white px-3 py-1 rounded">
Cancelar
</button>

<button 
 x-show="editing"
 class="bg-green-600 text-white px-3 py-1 rounded">
Actualizar
</button>

</form>

<form method="POST" action="{{ route('commissions.destroy',$commission) }}" class="inline">
@csrf
@method('DELETE')

<button class="bg-red-500 text-white px-3 py-1 rounded">
Eliminar
</button>
</form>

</td>
</tr>

@endforeach
</tbody>

</table>
</div>
