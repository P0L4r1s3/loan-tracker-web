<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 px-4">

<div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-10">

{{-- TITULO --}}
<div class="text-center mb-8">
<h1 class="text-3xl font-extrabold text-indigo-700 tracking-tight">
Entrega De Dinero
</h1>
<p class="text-gray-500 mt-2">
Accede a tu panel financiero
</p>
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" class="space-y-6">
@csrf

<!-- EMAIL -->
<div>
<x-input-label for="email" value="Correo electrónico" class="text-gray-700 font-medium"/>

<x-text-input
id="email"
type="email"
name="email"
:value="old('email')"
required
autofocus
class="mt-2 block w-full rounded-xl border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
/>

<x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- PASSWORD CON OJO -->
<div>
<x-input-label for="password" value="Contraseña" class="text-gray-700 font-medium"/>

<div class="relative mt-2">
<input
id="password"
type="password"
name="password"
required
class="block w-full rounded-xl border-gray-300 pr-12 focus:border-indigo-600 focus:ring-indigo-600"
/>

<button
type="button"
onclick="togglePassword()"
class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-indigo-600 transition">
👁
</button>
</div>

<x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- REMEMBER + RESET -->
<div class="flex items-center justify-between text-sm">

<label class="flex items-center gap-2 text-gray-600">
<input type="checkbox" name="remember"
class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
Recordarme
</label>

@if (Route::has('password.request'))
<a href="{{ route('password.request') }}"
class="text-indigo-600 hover:text-indigo-800 font-medium">
¿Olvidaste tu contraseña?
</a>
@endif

</div>

<!-- BOTON LOGIN -->
<button
type="submit"
class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl shadow-lg transition">
Ingresar
</button>

</form>

{{-- REGISTRO --}}
@if (Route::has('register'))
<p class="text-center mt-6 text-sm text-gray-600">
¿No tienes cuenta?
<a href="{{ route('register') }}"
class="text-indigo-600 font-semibold hover:underline">
Crear una ahora
</a>
</p>
@endif

{{-- FOOTER LINK A WELCOME --}}
<p class="text-center text-sm mt-8">
<a href="{{ url('/') }}"
class="text-gray-500 hover:text-indigo-600 transition font-medium">
Plataforma financiera segura
</a>
</p>

</div>
</div>

<!-- SCRIPT OJO -->
<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</x-guest-layout>
