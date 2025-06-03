<!-- FORMULARIO PARA CREAR O EDITAR USUARIO

    Al programar la creacion de usuario, he recordado y visto que va a ser más de lo mismo.
    Con lo que se usará la misma vista para ambas acciones, utilizando condiciones para hacer una de estas.
    Es decir, si hay un ID de usuario en la url "/usuarios/editar/id", entonces se muestran los datos del usuario,
    y el metodo es PUT.
    Pero si no hay ID "/usuario/crear", entonces se crea un nuevo usuario, con metodo POST.

    Comentar tambien, que se ha usado mucho el Alpine para ralizar diferentes cosas, ya que esta herramienta
    tiene muchas cosas utiles.
-->

<x-usuario-crear-layout :usuario="$usuario">
    <!-- Para que esta vista se pueda usar para ambos, crear y editar, se usa el props de usuario. -->
    @props(['usuario' => null])
    <!-- TITULO DEL CONTENDIO: cambia depende de is hay usuario o no -->
    <div class="flex flex-col mb-2">
        <h1 class="text-[#295214] text-[30px] font-black mb-2">
            {{ $usuario ? 'EDITAR USUARIO' : 'CREAR USUARIO' }}
        </h1>

        <a href="/usuarios"
            class="w-[100px] rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] hover:bg-gray-400">
            Volver
        </a>
    </div>
    <!-- Este es el div que engloba casi todo el formulario
        Tenemos el `x-data` con una funcion que tendra todos los datos necsarios.
        Luego el `x-init` para inicializar una funcion. Todo esto se hace en JavaScript
    -->
    <div class="flex flex-col h-full bg-[#499424] rounded-[10px] shadow-mainShadow border-2 border-black"
        x-data="formularioUsuario()" x-init="init()">
        <!-- PAGINACION DE LOS PASOS: con el apline nos ayuda a mostrar un paso u otro -->
        <div class="flex flex-col items-center">
            <div class="flex justify-center gap-60 mt-6 mb-2 text-lg text-white font-semibold">
                <span class="py-2 px-5 rounded-lg border-2 border-black"
                    :class="paso === 1 ? 'bg-[#295214]' : 'bg-[#39731C]'">
                    1. Crear usuario
                </span>
                <span class="py-2 px-5 rounded-lg border-2 border-black"
                    :class="paso === 2 ? 'bg-[#295214]' : 'bg-[#39731C]'">
                    2. Asignar rol y clase
                </span>
                <span class="py-2 px-5 rounded-lg border-2 border-black"
                    :class="paso === 3 ? 'bg-[#295214]' : 'bg-[#39731C]'">
                    3. Confirmar datos.
                </span>
            </div>
            <hr class="border-t-2 border-white w-full my-4">
        </div>


        <!-- FORMULARIO DE LA CREACION DE USUARIO: el metodo y ruta cambian dependiendo de si es edicion o creacion -->
        <form action="{{ $usuario ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}" method="POST"
            class="flex items-center justify-center h-full">
            @csrf <!-- El csrf siempre es importante en formularios -->
            @if ($usuario)
                @method('PUT')
            @endif

            <!-- El formulario se separa en pasos, que cada uno se muestra u oculta, dependiendo del paso. Gracias al `x-show`-->
            <!-- PRIMER PASO
                Cada input tiene su `x-model`, que servira para más tarde, mostrar y usar los datos de cada campo.
                Ademas, cada campo, tiene su <p> que muestra un error especifico, y la validacion se realiza en JS.
                El x-cloak sirve para ocultar ocntenido.
            -->
            <div x-show="paso === 1" x-cloak>
                <div class="flex justify-center gap-20">
                    <div class="flex flex-col gap-2">
                        <div>
                            <label for="dni" class="block text-md font-bold text-white">
                                DNI
                            </label>
                            <input type="text" name="dni" id="dni" placeholder="99999999Z" required
                                class="rounded-lg border-2 border-black" x-model="datos.dni" @input="errores.dni =''">
                            <p x-show="errores.dni" class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.dni"></p>
                        </div>
                        <div>
                            <label for="nombre" class="block text-md font-bold text-white">
                                Nombre
                            </label>
                            <input type="text" name="nombre" id="nombre" class="rounded-lg border-2 border-black"
                                placeholder="Introduce nombre..." required x-model="datos.nombre"
                                @input="errores.nombre =''">
                            <p x-show="errores.nombre" class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.nombre"></p>
                        </div>
                        <div>
                            <label for="apellido1" class="block text-md font-bold text-white">
                                Primer Apellido
                            </label>
                            <input type="text" name="apellido1" id="apellido1" x-model="datos.apellido1"
                                class="rounded-lg border-2 border-black" placeholder="Introduce apellido..." required
                                @input="errores.apellido1 =''">
                            <p x-show="errores.apellido1"
                                class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.apellido1">
                            </p>
                        </div>
                        <div>
                            <label for="apellido2" class="block text-md font-bold text-white">
                                Segundo Apellido
                            </label>
                            <input type="text" name="apellido2" id="apellido2" x-model="datos.apellido2"
                                class="rounded-lg border-2 border-black" placeholder="Introduce apellido..." required
                                @input="errores.apellido2 =''">
                            <p x-show="errores.apellido2"
                                class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.apellido2">
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div>
                            <label for="fecha_nacimiento" class="block text-md font-bold text-white">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                class="rounded-lg border-2 border-black" required x-model="datos.fecha_nacimiento"
                                @input="errores.fecha_nacimiento =''">
                            <p x-show="errores.fecha_nacimiento"
                                class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.fecha_nacimiento">
                            </p>
                        </div>
                        <div>
                            <label for="genero" class="block text-md font-bold text-white">
                                Género
                            </label>
                            <select name="genero" id="genero" class="rounded-lg border-2 border-black"
                                x-model="datos.genero" required @input="errores.genero =''">
                                <option value="">Selecciona</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                            <p x-show="errores.genero" class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.genero">
                            </p>
                        </div>
                        <div>
                            <label for="numero_telefono" class="block text-md font-bold text-white">
                                Número e Teléfono
                            </label>
                            <input type="text" name="numero_telefono" id="numero_telefono"
                                x-model="datos.numero_telefono" class="rounded-lg border-2 border-black"
                                placeholder="666 777 666" required @input="errores.numero_telefono =''">
                            <p x-show="errores.numero_telefono"
                                class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.numero_telefono">
                            </p>
                        </div>
                        <div>
                            <label for="email" class="block text-md font-bold text-white">
                                Correo Electrónico
                            </label>
                            <input type="email" name="email" id="email"
                                class="rounded-lg border-2 border-black" placeholder="ejemplo@exemple.es" required
                                x-model="datos.email" @input="errores.email =''">
                            <p x-show="errores.email"
                                class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.email"></p>
                        </div>
                    </div>
                </div>

                <!-- Este boton no deja continuar si hay errores en los inputs al validarlos -->
                <div class="mt-10 flex justify-center">
                    <button type="button" @click="validarPaso1()"
                        class="bg-black text-white text-lg font-bold py-3 px-5 rounded-lg hover:bg-slate-800">
                        Continuar
                    </button>
                </div>
            </div>

            <!-- SEGUNDO PASO
            Aqui, es donde se selecciona el rol y clase.
            Dependiendo de cual rol se eliga, se podra seleccionar o no una clase a asignar.
            ¿Porque el profe no se le asigna? Mas tarde se hace esto, ya que, en este caso, el profe es parte de la clase.
            -->
            <div x-show="paso === 2" class="h-full w-full" x-cloak>
                <div class="flex justify-center items-center gap-28 mt-10 h-1/2">
                    <div class="flex flex-col gap-3">
                        <button type="button"
                            @click="
                        $refs.rol.value = 'alumno';
                        datos.rol = 'alumno';
                        boton_rol_alumno()
                        "
                            id="boton_alumno" class="bg-gray-500 text-white text-lg font-bold py-3 px-5 rounded-lg">
                            Alumno
                        </button>
                        <button type="button"
                            @click="
                        $refs.rol.value = 'profe';
                        datos.rol = 'profe';
                        boton_rol_profe()
                        "
                            id="boton_profe"
                            class="bg-black text-white text-lg font-bold py-3 px-5 rounded-lg hover:bg-slate-800">
                            Profesor
                        </button>
                    </div>
                    <input type="hidden" name="rol" x-ref="rol">

                    <div class="w-px h-32 bg-white mx-4"></div>

                    <!-- Aqui se selecciona la clase. -->
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col justify-center items-center gap-3">
                            <h1 class="text-white text-2xl font-black underline">Rol Seleccionado:</h1>
                            <h3 id="rol_seleccionado" class="text-xl text-white font-bold">
                                Alumno
                            </h3>
                        </div>
                        <div x-show="datos.rol === 'alumno'">
                            <label for="clase" class="block text-lg font-bold text-white mb-2">
                                Asignale una clase al alumno
                            </label>
                            <!-- Si es profesor, no se muestra.
                            Cada seleccion siempre se guarda, para luego ser usada la ultima.
                            -->
                            <select name="clase" id="clase" x-bind:disabled="datos.rol !== 'alumno'"
                                class="rounded-lg border-2 border-black"
                                @change="
                                const nombreClase = $event.target.options[$event.target.selectedIndex].dataset.nombre;
                                datos.nombre_clase = nombreClase;
                                "
                                required>
                                <!-- Se muestran todas las clases.
                                Si es edicion, lo que se haya elegido, se selecciona automaticamente.
                                -->
                                <option value="">Selecciona</option>
                                @foreach ($clases as $clase)
                                    <option value="{{ $clase->id }}" data-nombre="{{ $clase->nombre }}"
                                        @selected(old('clase', optional(optional($usuario)->clase)->id) == $clase->id)>
                                        {{ $clase->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Se puede retroceder. Luego, al continuar, ocurre mas del o mismo que el paso 1.-->
                <div class="mt-6 flex justify-center gap-5">
                    <button type="button" @click="paso--"
                        class="bg-white text-black text-lg font-bold py-3 px-5 rounded-lg hover:bg-slate-400">
                        Retroceder
                    </button>
                    <button type="button" @click="validarPaso2()"
                        class="bg-black text-white text-lg font-bold py-3 px-5 rounded-lg hover:bg-slate-800">
                        Continuar
                    </button>
                </div>
            </div>

            <!-- PASO FINAL
                En este paso final, se muestran todos los datos guardados gracias al Alpine.
            -->
            <div x-show="paso === 3" class="h-full w-full" x-cloak>
                <div class="flex  flex-col justify-center gap-5 items-center mt-10 h-1/2 text-white">
                    <h1 class="mb-4 font-black text-2xl text-center underline">Resumen de los datos.</h1>
                    <div class="flex gap-10 text-lg font-medium">
                        <div class="flex flex-col gap-2">
                            <p>
                                <span class="font-bold">DNI: </span>
                                <span x-text="datos.dni"></span>
                            </p>
                            <p>
                                <span class="font-bold">Nombre: </span>
                                <span x-text="datos.nombre"></span>
                            </p>
                            <p>
                                <span class="font-bold">Primer Apellido: </span>
                                <span x-text="datos.apellido1"></span>
                            </p>
                            <p>
                                <span class="font-bold">Segundo Apellido: </span>
                                <span x-text="datos.apellido2"></span>
                            </p>
                            <p>
                                <span class="font-bold">Fecha de Nacimiento: </span>
                                <span x-text="datos.fecha_nacimiento"></span>
                            </p>
                        </div>

                        <div class="flex flex-col gap-2">
                            <p>
                                <span class="font-bold">Género: </span>
                                <span x-text="datos.genero"></span>
                            </p>
                            <p>
                                <span class="font-bold">Número de Teléfono: </span>
                                <span x-text="datos.numero_telefono"></span>
                            </p>
                            <p>
                                <span class="font-bold">Correo Electrónico: </span>
                                <span x-text="datos.email"></span>
                            </p>
                            <p>
                                <span class="font-bold">Rol Aignado: </span>
                                <span x-text="datos.rol">Alumno</span>
                            </p>
                            <p x-show="datos.rol === 'alumno'">
                                <span class="font-bold">Clase Asignada: </span>
                                <span x-text="datos.nombre_clase"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-center gap-5">
                    <button type="button" @click="paso--"
                        class="bg-white text-black text-lg font-bold py-3 px-5 rounded-lg hover:bg-slate-400">
                        Retroceder
                    </button>
                    <!-- Finalmente, el sumbit, para enviar todo.-->
                    <button type="submit"
                        class="bg-blue-600 text-white text-lg font-bold py-3 px-5 rounded-lg hover:bg-blue-500">
                        Finalizar
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-usuario-crear-layout>

<script>
    // Una funcion simple que cambia textos y clases necesarias al presionar el boton de Alumno.
    function boton_rol_alumno() {
        document.getElementById('rol_seleccionado').innerText = 'Alumno';

        document.getElementById('boton_alumno').classList.add('bg-gray-500');
        document.getElementById('boton_alumno').classList.remove('bg-black');
        document.getElementById('boton_alumno').classList.remove('hover:bg-slate-800');

        document.getElementById('boton_profe').classList.remove('bg-gray-500');
        document.getElementById('boton_profe').classList.add('bg-black');
        document.getElementById('boton_profe').classList.add('hover:bg-slate-800');
    }

    // Igual que la de alumno, pero para profesor.
    function boton_rol_profe() {
        document.getElementById('rol_seleccionado').innerText = 'Profesor';

        document.getElementById('boton_profe').classList.add('bg-gray-500');
        document.getElementById('boton_profe').classList.remove('bg-black');
        document.getElementById('boton_profe').classList.remove('hover:bg-slate-800');

        document.getElementById('boton_alumno').classList.remove('bg-gray-500');
        document.getElementById('boton_alumno').classList.add('bg-black');
        document.getElementById('boton_alumno').classList.add('hover:bg-slate-800');
    }

    /**
     * Esta es la funcion general del formulario, donde se realizan sus aciones.
     * Hay diferentes datos [paso, datos, errores], y funciones [init, validarPaso1].
     *
     * El 'paso' es para saber en que paso esta el formulario.
     *
     * Los 'datos', son de los inputs, que, dependiendo de si es edicion, o no, se muestran los datos
     * del usuario dado la ID, o un campo vacio.
     *
     * Los 'errores' serviran para la validacion.
     */
    function formularioUsuario() {
        return {
            paso: 1,
            datos: {
                dni: @json(old('dni', $usuario->dni ?? '')),
                nombre: @json(old('nombre', $usuario->nombre ?? '')),
                apellido1: @json(old('apellido1', $usuario->apellido1 ?? '')),
                apellido2: @json(old('apellido2', $usuario->apellido2 ?? '')),
                fecha_nacimiento: @json(old('fecha_nacimiento', $usuario->fecha_nacimiento ?? '')),
                genero: @json(old('genero', $usuario->genero ?? '')),
                numero_telefono: @json(old('numero_telefono', $usuario->numero_telefono ?? '')),
                email: @json(old('email', $usuario->email ?? '')),
                rol: @json(old('rol', $usuario->rol ?? '')),
                id_clase: @json(old('id_clase', $usuario->id_clase ?? '')),
            },
            errores: {
                dni: '',
                nombre: '',
                apellido1: '',
                apellido2: '',
                fecha_nacimiento: '',
                genero: '',
                numero_telefono: '',
                email: '',
            },
            /**
             * El init, tan solo "presiona" el boton dependiendo de que
             * rol sea el usuario a editar.
             */
            init() {
                if (this.datos.rol === 'profe')
                    boton_rol_profe();
                else
                    boton_rol_alumno();
            },
            /**
             * Esta funcion es la que valida manualmente cada campo del paso 1.
             * Se usan expresiones regulares "RegEx" para unos campos.
             *
             * Siempre que hay un error, se muestra, y no se deja continuar.
             */
            validarPaso1() {
                let esValido = true;

                // Validacion del DNI
                if (!this.datos.dni.match(/^[0-9]{8}[A-Z]$/)) {
                    this.errores.dni = 'El DNI es erroneo';
                    esValido = false;
                }

                // Validacion del Nombre
                if (!this.datos.nombre.trim()) {
                    this.errores.nombre = 'Introduce un nombre';
                    esValido = false;
                }

                // Validacion del Apellido 1
                if (!this.datos.apellido1.trim()) {
                    this.errores.apellido1 = 'Introduce un apellido';
                    esValido = false;
                }

                // Validacion del Apellido 2
                if (!this.datos.apellido2.trim()) {
                    this.errores.apellido2 = 'Introduce un segundo apellido';
                    esValido = false;
                }

                // Validacion del Fecha Nacimiento
                if (!this.datos.fecha_nacimiento) {
                    this.errores.fecha_nacimiento = 'Selecciona la fecha de nacimiento';
                    esValido = false;
                }

                // Validacion del Genero
                if (!this.datos.genero) {
                    this.errores.genero = 'Selecciona un genero.';
                    esValido = false;
                }

                // Validacion del Numero Telefono
                if (!this.datos.numero_telefono.match(/^[0-9]{9}$/)) {
                    this.errores.numero_telefono = 'El numero de telefono es erroneo';
                    esValido = false;
                }

                // Validacion del Email
                if (!this.datos.email.match(/^[^@\s]+@[^@\s]+\.[^@\s]+$/)) {
                    this.errores.email = 'El email no es correcto';
                    esValido = false;
                }

                if (esValido) this.paso++;
            },
            /**
             * Esta funcion es parecida a la de antes.
             * Sirve para asegurar que se ha seleccionado rol y, si es alumno, clase.
             *
             * TODO-Mostrar errores en inputs en vez de alert
             */
            validarPaso2() {
                let esValido = true;

                if (!this.datos.rol) {
                    alert("Debes seleccionar un rol");
                    esValido = false;
                }

                if (this.datos.rol === 'alumno' && !document.getElementById('clase').value) {
                    alert("Debes seleccionar una clase para el alumno");
                    esValido = false;
                }

                if (esValido) this.paso++;
            }
        }
    }
</script>
