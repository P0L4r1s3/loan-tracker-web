<x-app-layout>
<div class="max-w-md mx-auto py-8">

<h2 class="text-xl font-bold mb-4">Editar tasa</h2>

<form method="POST" action="{{ route('interest-rates.update',$interest_rate) }}">
@csrf
@method('PUT')

<input name="name"
 value="{{ $interest_rate->name }}"
 class="w-full border p-2 mb-3 rounded">

<input name="rate" type="number" step="0.01"
 value="{{ $interest_rate->rate }}"
 class="w-full border p-2 mb-3 rounded">

<button class="bg-green-500 text-white px-4 py-2 rounded">
Actualizar
</button>

</form>
</div>
</x-app-layout>
