<x-main-layout>
    <!-- TITULO DEL CONTENDIO -->
    <h1 class="text-[#295214] text-[30px] font-black">PANEL DE CONTROL</h1>

    <!-- CONTENIDO -->
    <div class="flex justify-between max-h-screen">
        <!-- CAJAS CON DATOS GENERALES -->
        <div class="flex flex-col text-white gap-4 w-1/3 py-3 box-border">
            <!-- CAJA: Total Usuarios -->
            <div class="flex flex-col bg-[#499424] p-5 rounded-lg shadow-mainShadow flex-1">
                <h1 class="text-center text-4xl font-bold mb-2">Total Usuarios</h1>
                <div class="flex justify-center items-center gap-4">
                    <span class="text-center text-6xl font-black">{{ $totalUsuarios }}</span>
                    <img src="/images/total_users_icon.png" alt="icono_usuarios" draggable="false" class="w-24 h-auto">
                </div>
            </div>

            <!-- CAJA: Total Profesores -->
            <div class="flex flex-col bg-[#499424] p-5 rounded-lg shadow-mainShadow flex-1">
                <h1 class="text-center text-4xl font-bold mb-2">Profesores</h1>
                <div class="flex justify-center items-center gap-4">
                    <span class="text-center text-6xl font-black">{{ $totalPorfes }}</span>
                    <img src="/images/teacher_icon.png" alt="icono_usuarios" draggable="false" class="w-24 h-auto">
                </div>
            </div>

            <!-- CAJA: Total Alumnos -->
            <div class="flex flex-col bg-[#499424] p-5 rounded-lg shadow-mainShadow flex-1">
                <h1 class="text-center text-4xl font-bold mb-2">Alumnos</h1>
                <div class="flex justify-center items-center gap-4">
                    <span class="text-center text-6xl font-black">{{ $totalAlumnos }}</span>
                    <img src="/images/student_icon.png" alt="icono_usuarios" draggable="false" class="w-24 h-auto">
                </div>
            </div>
        </div>

        <!-- LISTA RESUMIDA USUARIOS -->
        <div
            class="bg-[#295214] text-white rounded-lg shadow-mainShadow p-6 w-full max-w-md flex flex-col items-center">
            <!-- TITULO -->
            <h1 class="font-bold text-2xl mb-4">Lista de Usuarios</h1>

            <!-- CAJAS DE USUARIO -->
            <div class="w-full flex flex-col mb-6 gap-3">
                <!-- CAJA: Usuario 1 -->
                @foreach ($usuariosLista as $usuario)
                    <div class="flex items-center bg-[#499424] px-4 py-2 rounded-lg shadow-inner">
                        @php
                            // Aqui, dependiendo del rol, se muestra una imagen, o otra.
                            $imagen =
                                $usuario->rol === 'profe'
                                    ? '/images/teacher_profile.png'
                                    : '/images/student_profile.png';
                            // Y esto es para mostrar mejor el Rol
                            $rol_usuario = $usuario->rol === 'profe' ? 'Profesor' : 'Alumno';
                        @endphp
                        <img src="{{ $imagen }}" alt="imagen" class="w-10 h-10 mr-4" draggable="false">
                        <span class="font-semibold">
                            {{ $rol_usuario }}
                            |
                            {{ $usuario->nombre }} {{ $usuario->apellido1 }} {{ $usuario->apellido2 }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- BOTON -->
            <a href="/usuarios"
                class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] select-none hover:bg-gray-400">
                {{ __('VER TODOS') }}
            </a>
        </div>
    </div>

    <!-- SIDEBAR -->
    <x-slot name="menu_sidebar">
        <div
            class="flex flex-col justify-between bg-[#499424] text-white rounded-[15px] w-44 select-none shadow-mainShadow">
            <div>
                <!-- ICONO -->
                <div class="flex justify-center mb-2">
                    <img src="/images/ILM_icon.png" draggable="false" alt="icono" class="w-[150px] h-auto">
                </div>

                <!-- MENU PRINCIPAL -->
                <nav class="space-y-2">
                    <div class="flex items-center gap-2 px-4 py-2 bg-[#295214] rounded-lg border-2 border-black">
                        <img src="/images/admin_panel_icon.png" draggable="false" alt="icono_panel" class="w-6 h-6">
                        <span class="font-semibold">Panel</span>
                    </div>
                    <a href="/usuarios" class="flex items-center gap-2 px-4 py-2 bg-[#39731C] hover:bg-[#295214]">
                        <img src="/images/admin_user_icon.png" draggable="false" alt="icono_usuario" class="w-6 h-6">
                        <span class="font-semibold">Usuarios</span>
                    </a>
                    <a href="/classes" class="flex items-center gap-2 px-4 py-2 bg-[#39731C] hover:bg-[#295214]">
                        <img src="/images/admin_class_icon.png" draggable="false" alt="icono_clase" class="w-6 h-6">
                        <span class="font-semibold">Clases</span>
                    </a>
                </nav>
            </div>

            <!-- BOTON LOGOUT -->
            <div class="mb-7">
                <a href="/logout" class="flex items-center gap-3 px-4 py-2 bg-[#D9D9D9] text-black">
                    <img src="/images/logout.png" draggable="false" alt="logout" class="w-6 h-6">
                    <span class="font-semibold">Salir</span>
                </a>
            </div>
        </div>
    </x-slot>
</x-main-layout>
