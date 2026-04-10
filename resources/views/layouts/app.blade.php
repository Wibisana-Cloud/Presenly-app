<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Presenly</title>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#d9e4f5] font-sans antialiased pb-24">

<!-- HEADER -->

<div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-center py-6 shadow">

<h1 class="text-lg font-semibold">
{{ $header ?? 'Presenly' }}
</h1>

</div>


<!-- CONTENT -->

<div class="p-4">

{{ $slot }}

</div>


<!-- NAVBAR -->

<div class="fixed bottom-0 w-full bg-white shadow-inner p-3 flex justify-around text-xs">

<a href="/dashboard" class="text-gray-600 text-center">
Dashboard
</a>

<a href="/riwayat" class="text-gray-600 text-center">
Riwayat
</a>

<a href="/profil" class="text-gray-600 text-center">
Profil
</a>

</div>

</body>
</html>