<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema de Entrega</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

{{-- NAVBAR --}}
<header class="bg-white shadow fixed w-full z-20">
<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<h1 class="text-2xl font-bold text-indigo-700">
Entrega Express
</h1>

<div class="space-x-4">

@auth
<a href="{{ route('user.loan') }}" 
class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
Ir al panel
</a>
@else
<a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">
Iniciar sesión
</a>
<a href="{{ route('register') }}" 
class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
Registrarse
</a>
@endauth

</div>

</div>
</header>

{{-- HERO --}}
<section class="pt-32 pb-24 bg-gradient-to-br from-indigo-700 to-indigo-500 text-white">

<div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

<div>
<h2 class="text-5xl font-extrabold leading-tight mb-6">
Entregas rápidos, claros y seguros
</h2>

<p class="text-lg opacity-90 mb-8">
Administra tus entregas, pagos y estados de cuenta desde una sola plataforma moderna.
</p>

<div class="flex gap-4">
<a href="{{ route('login') }}"
class="bg-white text-indigo-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100">
Solicitar entrega
</a>

<a href="{{ route('login') }}"
class="border border-white px-6 py-3 rounded-xl hover:bg-white hover:text-indigo-700 transition">
Ingresar
</a>
</div>
</div>

<div class="hidden md:block">
<img src="{{ asset('images/finanzas.jpg') }}"
class="rounded-2xl shadow-2xl">

</div>

</div>
</section>

{{-- BENEFICIOS --}}
<section class="py-24 bg-gray-100">

<div class="max-w-7xl mx-auto px-6">

<h3 class="text-4xl font-bold text-center mb-16">
¿Por qué elegirnos?
</h3>

<div class="grid md:grid-cols-3 gap-10">

<div class="bg-white p-8 rounded-2xl shadow hover:shadow-xl transition">
<h4 class="text-xl font-bold text-indigo-700 mb-3">Rápido</h4>
<p>Solicita tu entrega en minutos y recibe aprobación inmediata.</p>
</div>

<div class="bg-white p-8 rounded-2xl shadow hover:shadow-xl transition">
<h4 class="text-xl font-bold text-indigo-700 mb-3">Transparente</h4>
<p>Sin letras pequeñas. Ves tu estado de cuenta en tiempo real.</p>
</div>

<div class="bg-white p-8 rounded-2xl shadow hover:shadow-xl transition">
<h4 class="text-xl font-bold text-indigo-700 mb-3">Seguro</h4>
<p>Tus datos protegidos con autenticación y control de accesos.</p>
</div>

</div>
</div>
</section>

{{-- CTA --}}
<section class="py-24 bg-indigo-700 text-white text-center">

<h3 class="text-4xl font-bold mb-6">
Empieza hoy mismo
</h3>

<p class="mb-8 opacity-90 text-lg">
Crea tu cuenta y administra tus entergas de forma profesional
</p>

<a href="{{ route('register') }}"
class="bg-white text-indigo-700 px-8 py-4 rounded-xl font-bold hover:bg-gray-100">
Crear cuenta gratis
</a>

</section>

{{-- FOOTER --}}
<footer class="bg-slate-900 text-gray-300 py-10">

<div class="max-w-7xl mx-auto px-6 text-center space-y-2">

<p class="font-semibold text-white">
Sistema de Entrega © {{ date('Y') }}
</p>

<p class="text-sm">
Desarrollado con Laravel & Tailwind Julia Mis
</p>

</div>

</footer>

</body>
</html>
