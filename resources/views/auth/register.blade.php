<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 px-4">

<div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-10">

{{-- TITULO --}}
<div class="text-center mb-8">
<h1 class="text-3xl font-extrabold text-indigo-700 tracking-tight">
Crear cuenta
</h1>
<p class="text-gray-500 mt-2">
Regístrate para acceder al sistema financiero
</p>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-6">
@csrf

<!-- Name -->
<div>
<x-input-label for="name" value="Nombre completo" class="text-gray-700 font-medium"/>

<x-text-input
id="name"
type="text"
name="name"
:value="old('name')"
required
autofocus
class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
/>

<x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Email -->
<div>
<x-input-label for="email" value="Correo electrónico" class="text-gray-700 font-medium"/>

<x-text-input
id="email"
type="email"
name="email"
:value="old('email')"
required
class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
/>

<x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Password -->
<div>
<x-input-label for="password" value="Contraseña" class="text-gray-700 font-medium"/>

<x-text-input
id="password"
type="password"
name="password"
required
class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
/>

<x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm -->
<div>
<x-input-label for="password_confirmation" value="Confirmar contraseña" class="text-gray-700 font-medium"/>

<x-text-input
id="password_confirmation"
type="password"
name="password_confirmation"
required
class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
/>

<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<!-- Button -->
<button
type="submit"
class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl shadow-lg transition">
Crear cuenta
</button>

</form>

{{-- Volver al login --}}
<p class="text-center mt-6 text-sm text-gray-600">
¿Ya tienes cuenta?
<a href="{{ route('login') }}"
class="text-indigo-600 font-semibold hover:underline">
Inicia sesión
</a>
</p>

{{-- FOOTER --}}
<p class="text-center text-sm mt-8">
<a 
    href="{{ url('/') }}" 
    class="text-gray-500 hover:text-indigo-600 transition font-medium"
>
Plataforma financiera segura
</a>
</p>


</div>
</div>

</x-guest-layout>
