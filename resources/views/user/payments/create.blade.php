<x-app-layout>
<div class="bg-gray-100 min-h-screen py-12">

<div class="max-w-4xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-8 border">

<h1 class="text-2xl font-bold text-slate-800 mb-6">
Realizar Pago
</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
{{ session('success') }}
</div>
@endif

<form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
@csrf



{{-- Monto --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Monto del pago
</label>

<input type="number" step="0.01" name="amount"
class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500"
placeholder="Ingrese el monto" required>
</div>

{{-- Concepto --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Concepto del pago
</label>

<input type="text" name="concept"
class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-indigo-500"
placeholder="Ej: Diamante" required>
</div>

{{-- Subir comprobante --}}
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Comprobante (imagen)
</label>

<input type="file" name="receipt" accept="image/*"
class="w-full border rounded-xl p-3 bg-white"
required>
</div>

{{-- Botón --}}
<div>
<button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl">
Enviar Pago
</button>
</div>

</form>

</div>

</div>
</div>
</x-app-layout>
