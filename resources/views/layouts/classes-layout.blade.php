<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clases</title>
    <!-- Con el vite, carga lo necesario para que los estilos o scripts, funcionen -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <div class="flex max-h-screen">
        <!-- MENU SIDEBAR -->
        <div class="w-1/6 h-screen px-5 py-5 flex justify-center">
            <x-menu-clases />
        </div>

        <!-- CONTENIDO CON LISTA DE LAS CLASES -->
        <div class="w-full h-screen p-6 flex flex-col select-none">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
