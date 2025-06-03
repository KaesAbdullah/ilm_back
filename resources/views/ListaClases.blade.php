<x-classes-layout>
    <!-- TITULO DEL CONTENDIO -->
    <h1 class="text-[#295214] text-[30px] font-black mb-3">CLASES</h1>

    <div class="flex flex-col h-full">

        <!-- BUSQUEDA + BOTON CREAR CLASE -->
        <div class="flex justify-between items-center mb-3">
            <!-- Creo un pequeño formulario para la busqueda de clase por nombre.-->
            <form method="GET" action="{{ route('classes') }}">
                <input type="text" name="nombre_clase" id="busqueda" placeholder="Buscar por Nombre"
                    value="{{ request('nombre') }}"
                    class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px]">
            </form>

            <a href="/classes/crear"
                class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] hover:bg-gray-400">
                {{ __('Crear Clase') }}
            </a>
        </div>

        <!-- LISTA CLASES -->
        <div class="flex-1 bg-[#499424] shadow-mainShadow overflow-auto rounded-[10px]">
            <table class="w-full table-auto border-collapse text-white">
                <!-- CABECERA -->
                <thead class="text-center">
                    <tr>
                        <th class="p-3">Imagen</th>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Profesor</th>
                        <th class="p-3">Tipo</th>
                        <th class="p-3">Nivel</th>
                        <th class="p-3">Número Alumnos</th>
                        <th class="p-3"></th> <!-- Esapcio para las acciones -->
                    </tr>
                </thead>

                <!-- CUERPO -->
                <tbody class="text-center">
                    <!-- Se usa el forelse, para hacer uso del empty, que se mostrara si no hay registros. -->
                    @forelse ($clases as $i => $clase)
                        <tr class="{{ $i % 2 === 0 ? 'bg-[#295214]' : 'bg-[#39731C]' }}">
                            <td class="py-2">
                                @php
                                    // Aqui, dependiendo del tipo, se muestra una imagen, o otra.
                                    $imagen =
                                        $clase->tipo === 'arabe'
                                            ? '/images/class_arab_img.png'
                                            : '/images/class_din_img.png';
                                    // Y esto es para mostrar mejor el el tipo
                                    $tipo_clase = $clase->tipo === 'arabe' ? 'Árabe' : 'Religión';
                                @endphp
                                <img src="{{ $imagen }} " alt="imagen" draggable="false"
                                    class="w-[50px] h-auto mx-auto">
                            </td>
                            <td class="p-3">{{ $clase->nombre }}</td>
                            <td class="p-3">{{ $clase->profesor->nombre }}</td>
                            <td class="p-3">{{ $tipo_clase }}</td>
                            <td class="p-3">{{ $clase->nivel }}</td>
                            <td class="p-3">{{ $clase->alumnos()->count() }}</td>
                            <td class="p-3 flex gap-3">
                                <img src="/images/add_icon.png" alt="añadir_alumno" draggable="false"
                                    onclick="window.location.href='/classes/{{ $clase->id }}/alumnos'"
                                    class="h-10 hover:cursor-pointer">
                                <img src="/images/edit_icon.png" alt="editar_clase" draggable="false"
                                    onclick="window.location.href='/classes/editar/{{ $clase->id }}'"
                                    class="h-10 hover:cursor-pointer">
                                <img src="/images/delete_icon.png" alt="eliminar_clase" draggable="false"
                                    onclick="mostrar_modal_eliminarClase('{{ $clase->id }}', '{{ $clase->nombre }}')"
                                    class="h-10 hover:cursor-pointer">
                            </td>
                        @empty
                        <tr>
                            <td colspan="7">
                                No se encontraron clases.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINACION -->
            <div class="flex justify-start mt-4 pl-4 pb-4 gap-2 text-white font-bold">

                <!-- Este boton se mostrara si la pagina es mayor que 1. -->
                @if ($pagina > 1)
                    <a href="{{ route('classes', ['page' => $pagina - 1]) }}"
                        class="hover:underline hover:text-gray-300">Anterior</a>
                @endif

                <span class="mx-4">{{ $pagina }}</span>

                <!-- Y este, se muestra si hay mas clases en la siguiente -->
                @if ($tieneMas)
                    <a href="{{ route('classes', ['page' => $pagina + 1]) }}"
                        class="hover:underline hover:text-gray-300">Siguiente</a>
                @endif
            </div>

        </div>
    </div>

    <!-- POP-UP Eliminar Clase-->
    <div id="modal-eliminar-clase"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-red-500 bg-opacity-50 backdrop-blur-sm">
        <div class="bg-[#D9D9D9] rounded-[10px] shadow-mainShadow border-black border-2 p-6 w-[500px] text-xl relative">
            <!-- Info Eliminacion -->
            <h2 class="text-2xl font-black mb-4 text-center"> ¿Eliminar esta clase? </h2>
            <div class="flex flex-col items-center underline">
                <p>
                    <strong>Nombre: </strong>
                    <span id="nombre_clase"></span>
                </p>
            </div>

            <!-- Botones -->
            <div class="flex justify-around mt-5">
                <button onclick="cerrar_modal_eliminarClase()"
                    class="bg-white text-black font-bold px-4 py-2 rounded-lg hover:bg-slate-400">
                    Cancelar
                </button>

                <button onclick="confirmar_eliminar_clase()"
                    class="bg-red-700 text-white font-bold px-4 py-2 rounded-lg hover:bg-red-500">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <!-- POP-UP de notificacion exitosa de eliminacion de usuario. -->
    @if (session('success'))
        <div id="notificacion_exito"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-[10px] shadow-mainShadow z-[999]">
            {{ session('success') }}
        </div>
    @endif

    <!-- POP-UP de notificacion erronea de eliminacion de usuario. -->
    @if (session('error'))
        <div id="notificacion_error"
            class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-[10px] shadow-mainShadow z-[999]">
            {{ session('error') }}
        </div>
    @endif

    <!-- Este es un formulatio oculto para eliminar usuarios. -->
    <form id="form_eliminar_clase" method="POST">
        @csrf
        @method('DELETE')
    </form>
    </x-users-layout>

    <script>
        let id_clase = null;
        let nombre_clase;

        /**
         * Este metodo mostrara una modal de confirmacion de Eliminacion
         **/
        function mostrar_modal_eliminarClase(id, nombre) {
            id_clase = id;

            document.getElementById('nombre_clase').innerText = nombre;
            document.getElementById('modal-eliminar-clase').classList.remove('hidden');
            document.getElementById('modal-eliminar-clase').classList.add('flex');
        }

        function cerrar_modal_eliminarClase() {
            document.getElementById('modal-eliminar-clase').classList.remove('flex');
            document.getElementById('modal-eliminar-clase').classList.add('hidden');
        }

        /**
         * Este otra funcion, es para hacer funcional la eliminacion de un Clase.
         * Obteniendo el ID de la clase de la BD, se realica la eliminacion.
         **/
        function confirmar_eliminar_clase() {
            if (!id_clase) return;

            const form = document.getElementById('form_eliminar_clase');
            form.action = `/classes/${id_clase}`;

            form.submit();
        }


        // Este timeout es para las notificaciones, eliminan dado un tiempo.
        setTimeout(() => {
            const notificacion_exito = document.getElementById('notificacion_exito');
            if (notificacion_exito) notificacion_exito.remove();

            const notificacion_error = document.getElementById('notificacion_error');
            if (notificacion_error) notificacion_error.remove();

        }, 5000);
    </script>
