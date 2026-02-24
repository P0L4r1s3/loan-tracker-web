<x-app-layout>
<div class="max-w-md mx-auto py-8">

<h2 class="text-xl font-bold mb-4">Nueva tasa</h2>

<form method="POST" action="{{ route('interest-rates.store') }}">
@csrf

<input name="name" placeholder="Nombre"
 class="w-full border p-2 mb-3 rounded">

<input name="rate" type="number" step="0.01"
 placeholder="Tasa %"
 class="w-full border p-2 mb-3 rounded">

<button class="bg-blue-500 text-white px-4 py-2 rounded">
Guardar
</button>

</form>
</div>
</x-app-layout>
