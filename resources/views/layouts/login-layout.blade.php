<!--
    Parece que laravel mismo ya crea su propio login y auth.
    Dandole provecho, tan solo modifico cosas y uso las necesarias.

    Este es el layout del login, que sirve para darle forma a la pagina.
    Con esto, tan solo es necesario darle maquetacion y luego meter los componentes.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <!-- Con el vite, carga lo necesario para que los estilos o scripts, funcionen -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex flex-row bg-white">
        <!-- IZQUIERDA: LOGO + LOGIN -->
        <div class="w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <!-- El Logo -->
                <div>
                    <img src="/images/ILM_icon.png" class="w-[200px] h-[200px] select-none" draggable="false" alt="Logo ILM">
                </div>

                <!-- El Login -->
                <div
                    class="w-full sm:max-w-md mt-5 px-24 py-16 bg-[#499424] border-black border-[2px]
                    shadow-mainShadow rounded-[10px]">
                    {{ $slot }} <!-- Aqui va el form del login -->
                </div>
            </div>
        </div>

        <!-- LA IMAGEN DE BIENVENIDA -->
        <div class="w-1/2 relative">
            <div class="absolute w-1/2 h-1/2 flex items-center justify-center z-10">
                <h1 class="text-[#499424] text-[48px] font-bold drop-shadow-lg mx-6 select-none">BIENVENIDO A LA PLATAFORMA ILM</h1>
            </div>
            <img src="/images/kid_study.png" alt="Imagen bienvenida"
                class="w-full h-full object-cover shadow-mainShadow">
        </div>
    </div>
</body>

</html>
