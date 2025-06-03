<x-users-layout>
    <!-- TITULO DEL CONTENDIO -->
    <h1 class="text-[#295214] text-[30px] font-black mb-3">USUARIOS</h1>

    <div class="flex flex-col h-full">

        <!-- BUSQUEDA + BOTON CREAR USUARIO -->
        <div class="flex justify-between items-center mb-3">
            <!-- Creo un pequeño formulario para la busqueda de DNI, con request dni-->
            <form method="GET" action="{{ route('usuarios') }}">
                <input type="text" name="dni" id="busqueda" placeholder="Buscar por DNI" value="{{ request('dni') }}"
                    class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px]">
            </form>

            <a href="/usuarios/crear"
                class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] hover:bg-gray-400">
                {{ __('Crear Usuario') }}
            </a>
        </div>

        <!-- LISTA USUARIOS -->
        <div class="flex-1 bg-[#499424] shadow-mainShadow overflow-auto rounded-[10px]">
            <table class="w-full table-auto border-collapse text-white">
                <!-- CABECERA -->
                <thead class="text-center">
                    <tr>
                        <th class="p-3">Imagen</th>
                        <th class="p-3">DNI</th>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">1er Apellido</th>
                        <th class="p-3">2do Apellido</th>
                        <th class="p-3">Rol</th>
                        <th class="p-3"></th> <!-- Esapcio para el boton -->
                    </tr>
                </thead>

                <!-- CUERPO -->
                <tbody class="text-center">
                    <!-- Se usa el forelse, para hacer uso del empty, que se mostrara si no hay registros. -->
                    @forelse ($usuarios as $i => $usuario)
                        <tr class="{{ $i % 2 === 0 ? 'bg-[#295214]' : 'bg-[#39731C]' }}">
                            <td class="py-2">
                                @php
                                    // Aqui, dependiendo del rol, se muestra una imagen, o otra.
                                    $imagen =
                                        $usuario->rol === 'profe'
                                            ? '/images/teacher_profile.png'
                                            : '/images/student_profile.png';
                                    // Y esto es para mostrar mejor el Rol y el genero
                                    $rol_usuario = $usuario->rol === 'profe' ? 'Profesor' : 'Alumno';
                                    $genero_usuario = $usuario->genero === 'M' ? 'Masculino' : 'Femenino';
                                @endphp
                                <img src="{{ $imagen }} " alt="imagen" draggable="false"
                                    class="w-[50px] h-auto mx-auto">
                            </td>
                            <td class="p-3">{{ $usuario->dni }}</td>
                            <td class="p-3">{{ $usuario->nombre }}</td>
                            <td class="p-3">{{ $usuario->apellido1 }}</td>
                            <td class="p-3">{{ $usuario->apellido2 }}</td>
                            <td class="p-3">{{ $rol_usuario }}</td>
                            <td class="p-3">
                                <button
                                    onclick="abrirInfo('{{ $usuario->id }}', '{{ $usuario->dni }}', '{{ $usuario->nombre }}', '{{ $usuario->apellido1 }}', '{{ $usuario->apellido2 }}',
                                '{{ $rol_usuario }}', '{{ $imagen }}', '{{ $usuario->fecha_nacimiento }}', '{{ $genero_usuario }}', '{{ $usuario->email }}',
                                '{{ $usuario->numero_telefono }}')"
                                    class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] hover:bg-gray-400">
                                    {{ __('Ver más') }}
                                </button>
                            </td>
                        @empty
                        <tr>
                            <td colspan="7">
                                No se encontraron usuarios.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINACION -->
            <div class="flex justify-start mt-4 pl-4 pb-4 gap-2 text-white font-bold">

                <!-- Este boton se mostrara si la pagina es mayor que 1. -->
                @if ($pagina > 1)
                    <a href="{{ route('usuarios', ['page' => $pagina - 1]) }}"
                        class="hover:underline hover:text-gray-300">Anterior</a>
                @endif

                <span class="mx-4">{{ $pagina }}</span>

                <!-- Y este, se muestra si hay mas usuarios en la siguiente -->
                @if ($tieneMas)
                    <a href="{{ route('usuarios', ['page' => $pagina + 1]) }}"
                        class="hover:underline hover:text-gray-300">Siguiente</a>
                @endif
            </div>

        </div>
    </div>

    <!-- POP-UP Informacion usuario.
    Este pop-up "modal", se mostrara segun que usuario se apriete el boton "ver más".
    Como se nota, el boton esta programado para que use los "parametros" de los datos necesarios.

    Estos datos se obtienen de la bd, correspondiente al usuario elegido.
    Para trabajar con los botones, usaremos js, para usar metodos como "onclick"
    -->
    <div id="modal-info-usuarios"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-[#499424] bg-opacity-50 backdrop-blur-sm">
        <div class="bg-[#499424] rounded-[10px] shadow-mainShadow p-6 w-[500px] text-xl text-white relative">

            <!-- Boton para cerrar la modal -->
            <button onclick="cerrarInfo()"
                class="absolute top-0 right-0 text-white text-2xl font-bold bg-red-600 hover:bg-red-400
                rounded-r-[3px] rounded-t-[3px] w-16">
                &times;
            </button>

            <!-- Titulo Modal -->
            <h2 class="text-2xl font-black mb-4 text-center underline"> Informacion del Usuario </h2>

            <!-- Imagen + Datos principales -->
            <div class="flex justify-center my-5 gap-4">
                <img id="modal-imagen" src="" alt="imagen" draggable="false"
                    class="w-[150px] border-white border-4 rounded-full" />

                <div class="flex flex-col justify-center gap-3">
                    <p> <strong>Nombre:</strong> <span id="modal-nombre"></span></p>
                    <p>
                        <strong>Apellidos:</strong>
                        <span id="modal-apellido1"></span>
                        <span id="modal-apellido2"></span>
                    </p>
                    <p>
                        <strong>DNI:</strong> <span id="modal-dni"></span>
                    </p>
                </div>
            </div>

            <!-- Datos adicionales -->
            <div class="flex flex-col justify-end gap-1">
                <p>
                    <strong>Rol:</strong> <span id="modal-rol"></span>
                </p>
                <p>
                    <strong>Fecha Nacimiento:</strong> <span id="modal-fecha"></span>
                </p>
                <p>
                    <strong>Genero:</strong> <span id="modal-genero"></span>
                </p>
                <p>
                    <strong>Email:</strong> <span id="modal-email"></span>
                </p>
                <p>
                    <strong>Numero Telefono:</strong> <span id="modal-numero"></span>
                </p>
            </div>

            <!-- Botones Editar y Eliminar -->
            <div class="flex justify-around mt-5">
                <button onclick="mostrar_modal_eliminarUsuario()"
                    class="bg-red-700 text-white font-bold px-4 py-2 rounded-lg hover:bg-red-500">
                    Eliminar
                </button>

                <button onclick="window.location.href= `/usuarios/editar/${id_usuario}`"
                class="bg-white text-black font-bold px-4 py-2 rounded-lg hover:bg-slate-400">
                    Editar
                </button>
            </div>
        </div>
    </div>

    <!-- POP-UP Eliminar Usuario-->
    <div id="modal-eliminar-usuario"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-red-500 bg-opacity-50 backdrop-blur-sm">
        <div class="bg-[#D9D9D9] rounded-[10px] shadow-mainShadow border-black border-2 p-6 w-[500px] text-xl relative">
            <!-- Info Eliminacion -->
            <h2 class="text-2xl font-black mb-4 text-center"> ¿Eliminar a este usuario? </h2>
            <div class="flex flex-col items-center underline">
                <p>
                    <strong>Nombre: </strong>
                    <span id="nombre_usuario"></span>
                    <span id="apellido1_usuario"></span>
                    <span id="apellido2_usuario"></span>
                </p>
                <p>
                    <strong>DNI: </strong>
                    <span id="dni_usuario"></span>
                </p>
            </div>

            <!-- Botones -->
            <div class="flex justify-around mt-5">
                <button onclick="cerrar_modal_eliminarUsuario()"
                    class="bg-white text-black font-bold px-4 py-2 rounded-lg hover:bg-slate-400">
                    Cancelar
                </button>

                <button onclick="confirmar_eliminar_usuario()"
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
    <form id="form_eliminar_usuario" method="POST">
        @csrf
        @method('DELETE')
    </form>
</x-users-layout>

<script>
    /**
     * Este metodo de js, se usara para la modal de informacion. Se crean muchas variables, que son datos
     * obtenidos de la BD. Estos corresponded a los del usuario el cual se ha querido ver su informacion.
     *
     * Se usa el metodo getElementById, para obtener cada elemento necesario del POP-UP.
     * Una vez obtenidos, se usa 'innerText' o 'src' para cambiar lo necesario, como imagen o el texto que se muestran.
     *
     * Finalmente, se quita la clase 'hidden', que usa tailwind para ocultar la modal, y luego se añade
     * 'flex'. Esto mostrara la modal.
     *
     * Se han definido diferentes variables que almacenaran datos necesarios para otras funciones, como
     * el nombre, los apellidos y el dni.
     **/
    let id_usuario = null;
    let dni_usuario, nombre_usuario, apellido1_usuario, apellido2_usuario;

    function abrirInfo(id, dni, nombre, apellido1, apellido2, rol, imagen, fecha_nac, genero, email, numero_telef) {
        id_usuario = id;
        dni_usuario = dni;
        nombre_usuario = nombre;
        apellido1_usuario = apellido1;
        apellido2_usuario = apellido2;

        document.getElementById('modal-imagen').src = imagen;
        document.getElementById('modal-dni').innerText = dni;
        document.getElementById('modal-nombre').innerText = nombre;
        document.getElementById('modal-apellido1').innerText = apellido1;
        document.getElementById('modal-apellido2').innerText = apellido2;
        document.getElementById('modal-rol').innerText = rol;
        document.getElementById('modal-fecha').innerText = fecha_nac;
        document.getElementById('modal-genero').innerText = genero;
        document.getElementById('modal-email').innerText = email;
        document.getElementById('modal-numero').innerText = numero_telef;

        document.getElementById('modal-info-usuarios').classList.remove('hidden');
        document.getElementById('modal-info-usuarios').classList.add('flex');
    }

    // Estas funciones simples, hacen que sus modales sean visibles o no.
    function cerrarInfo() {
        document.getElementById('modal-info-usuarios').classList.remove('flex');
        document.getElementById('modal-info-usuarios').classList.add('hidden');
    }

    function mostrar_modal_eliminarUsuario() {
        document.getElementById('dni_usuario').innerText = dni_usuario;
        document.getElementById('nombre_usuario').innerText = nombre_usuario;
        document.getElementById('apellido1_usuario').innerText = apellido1_usuario;
        document.getElementById('apellido2_usuario').innerText = apellido2_usuario;

        document.getElementById('modal-eliminar-usuario').classList.remove('hidden');
        document.getElementById('modal-eliminar-usuario').classList.add('flex');
    }

    function cerrar_modal_eliminarUsuario() {
        document.getElementById('modal-eliminar-usuario').classList.remove('flex');
        document.getElementById('modal-eliminar-usuario').classList.add('hidden');
    }

    /**
     * Este otra funcion, es para hacer funcional la eliminacion de un Usuario.
     * Obteniendo el ID del usuario de la BD, se realica la eliminacion.
     *
     * Usando el metodo que he preparado en "web.php", se elimina al usuario,
     * dado su ID.
     *
     * Primero, se le "dice" que la accion del formulario da a la ruta correspondiente,
     * luego, se envia.
     **/
    function confirmar_eliminar_usuario() {
        if (!id_usuario) return;

        const form = document.getElementById('form_eliminar_usuario');
        form.action = `/usuarios/${id_usuario}`;

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
