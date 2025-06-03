<!-- FORMULARIO PARA CREAR O EDITAR UNA CLASE

    Como se nota, he rehusado mucho del codigo de la parte de usuarios, para que el trabajo se mas
    facil. Y funciona igual. Con lo que dejare varios de los comentarios tanmbien.
-->

<x-clase-crear-layout :clase="$clase">
    <!-- Para que esta vista se pueda usar para ambos, crear y editar, se usa el props de clase. -->
    @props(['clase' => null])
    <!-- TITULO DEL CONTENDIO: cambia depende de is hay clase o no -->
    <div class="flex flex-col mb-2">
        <h1 class="text-[#295214] text-[30px] font-black mb-2">
            {{ $clase ? 'EDITAR CLASE' : 'CREAR CLASE' }}
        </h1>

        <a href="/classes"
            class="w-[100px] rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] hover:bg-gray-400">
            Volver
        </a>
    </div>

    <!-- Este es el div que engloba casi todo el formulario
        Tenemos el `x-data` con una funcion que tendra todos los datos necsarios.
    -->
    <div class="flex flex-col h-full bg-[#499424] rounded-[10px] shadow-mainShadow border-2 border-black"
        x-data="formularioClase()">
        <!-- PAGINACION DE LOS PASOS: con el apline nos ayuda a mostrar un paso u otro -->
        <div class="flex flex-col items-center">
            <div class="flex justify-center gap-60 mt-6 mb-2 text-lg text-white font-semibold">
                <span class="py-2 px-5 rounded-lg border-2 border-black"
                    :class="paso === 1 ? 'bg-[#295214]' : 'bg-[#39731C]'">
                    1. Crear clase
                </span>
                <span class="py-2 px-5 rounded-lg border-2 border-black"
                    :class="paso === 2 ? 'bg-[#295214]' : 'bg-[#39731C]'">
                    2. Confirmar datos.
                </span>
            </div>
            <hr class="border-t-2 border-white w-full my-4">
        </div>


        <!-- FORMULARIO DE LA CREACION DE CLASE: el metodo y ruta cambian dependiendo de si es edicion o creacion -->
        <form action="{{ $clase ? route('classes.update', $clase->id) : route('classes.store') }}" method="POST"
            class="flex items-center justify-center h-full">
            @csrf <!-- El csrf siempre es importante en formularios -->
            @if ($clase)
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
                            <label for="tipo" class="block text-md font-bold text-white">
                                Tipo
                            </label>
                            <select name="tipo" id="tipo" class="rounded-lg border-2 border-black"
                                x-model="datos.tipo" required @input="errores.tipo =''">
                                <option value="">Selecciona</option>
                                <option value="religion">Religion</option>
                                <option value="arabe">Arabe</option>
                            </select>
                            <p x-show="errores.tipo" class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.tipo">
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div>
                            <label for="nivel" class="block text-md font-bold text-white">
                                Nivel
                            </label>
                            <input type="text" name="nivel" id="nivel" class="rounded-lg border-2 border-black"
                                placeholder="Introduce nivel..." required x-model="datos.nivel"
                                @input="errores.nivel =''">
                            <p x-show="errores.nivel" class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.nivel"></p>
                        </div>
                        <div>
                            <label for="profe" class="block text-md font-bold text-white">
                                Profesor Asignado
                            </label>
                            <select name="profe_id" id="profe" class="rounded-lg border-2 border-black"
                                x-model="datos.profe" required @input="errores.profe =''">
                                <option value="">Selecciona</option>
                                @foreach ($profesores as $profe)
                                    <option value="{{ $profe->id }}">{{ $profe->nombre }}</option>
                                @endforeach
                            </select>
                            <p x-show="errores.profe" class="bg-red-600 text-white text-center text-sm rounded-lg mt-1"
                                x-text="errores.profe">
                            </p>
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

            <!-- PASO FINAL
                En este paso final, se muestran todos los datos guardados gracias al Alpine.
            -->
            <div x-show="paso === 2" class="h-full w-full" x-cloak>
                <div class="flex  flex-col justify-center gap-5 items-center mt-10 h-1/2 text-white">
                    <h1 class="mb-4 font-black text-2xl text-center underline">Resumen de los datos.</h1>
                    <div class="flex gap-10 text-lg font-medium" x-init="console.log('Profesores:', profesores)">
                        <div class="flex flex-col gap-2">
                            <p>
                                <span class="font-bold">Nombre: </span>
                                <span x-text="datos.nombre"></span>
                            </p>
                            <p>
                                <span class="font-bold">Tipo: </span>
                                <span x-text="datos.tipo"></span>
                            </p>
                        </div>

                        <div class="flex flex-col gap-2">
                            <p>
                                <span class="font-bold">Nivel: </span>
                                <span x-text="datos.nivel"></span>
                            </p>
                            <p>
                                <span class="font-bold">Profesor: </span>
                                <span x-text="getNombreProfe()"></span>
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
</x-clase-crear-layout>

<script>
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
    function formularioClase() {
        return {
            paso: 1,
            datos: {
                nombre: @json(old('nombre', $clase->nombre ?? '')),
                tipo: @json(old('tipo', $clase->tipo ?? '')),
                nivel: @json(old('nivel', $clase->nivel ?? '')),
                profe: @json(old('profe', $clase->profe_id ?? '')),
            },
            errores: {
                nombre: '',
                tipo: '',
                nivel: '',
                profe: '',
            },
            profesores: @json($profesores),

            getNombreProfe () {
                const profe = this.profesores.find(profesor => profesor.id == this.datos.profe);
                return profe ? profe.nombre : '';
            },

            /**
             * Esta funcion es la que valida manualmente cada campo del paso 1.
             * Se usan expresiones regulares "RegEx" para unos campos.
             *
             * Siempre que hay un error, se muestra, y no se deja continuar.
             */
            validarPaso1() {
                let esValido = true;

                // Validacion del Nombre
                if (!this.datos.nombre.trim()) {
                    this.errores.nombre = 'Introduce un nombre';
                    esValido = false;
                }

                // Validacion del tipo
                if (!this.datos.tipo) {
                    this.errores.tipo = 'Selecciona un tipo.';
                    esValido = false;
                }

                // Validacion del nivel
                if (!this.datos.nivel.trim()) {
                    this.errores.nivel = 'Introduce un nivel';
                    esValido = false;
                }

                // Validacion del Profesor
                if (!this.datos.profe) {
                    this.errores.profe = 'Selecciona un profesor.';
                    esValido = false;
                }

                if (esValido) this.paso++;
            }
        }
    }
</script>
