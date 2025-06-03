<!-- ALUMNOS EN CLASE
    En esta vista se gestionara la agregacion y eliminacion de alumnos de la
    clase elegida.

    La URL, tiene un ID, que es el de la clase elegida. Esto mostrara 2 tablas:
    USUARIOS DE CLASE: Son los alumnos que ya estan en esta clase.
    ALUMNOS EN GENERAL: Son todos los alumnos (menos los que ya estan en esta clase).

    Se podra eliminar alumnos de la clase, o añadir.

    Notese que el delete Oncascade servira aqui, para que cuando se quiera
    eliinar una clase con alumnos, se pueda.
-->
<x-clase-alumno-layout>
    <div class="mb-2 flex flex-col">
        <!-- DATOS CLAROS DE LO NECESARIO -->
        <h1 class="text-[#295214] text-[30px] font-black mb-1">
            GESTION DE LA CLASE <span class="ml-2 underline text-[#499424]">{{ $clase->nombre }}</span>
            DEL PROFESOR <span class="ml-2 underline text-[#499424]">{{ $clase->profesor->nombre }}</span>
        </h1>

        <a href="/classes"
            class="w-[100px] rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[3px] hover:bg-gray-400">
            Volver
        </a>
    </div>

    <div class="flex flex-row gap-6 h-full text-white">

        <!-- ALUMNOS EN LA CLASE ELEGIDA -->
        <div class="w-1/2 p-4 bg-[#499424] rounded-[10px] shadow-mainShadow border-2 border-black"
            x-data="{ dniBusquedaClase: '' }">
            <h2 class="text-xl font-bold underline mb-2 text-center">
                ALUMNOS EN LA CLASE
            </h2>
            <input type="text" placeholder="Buscar Por DNI" x-model="dniBusquedaClase"
                class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[10px] py-[2px] mb-2">
            <div class="max-h-[460px] overflow-y-auto border-2 border-black rounded-lg">
                <!-- LAS TABLAS FUNCIONAN IGUAL QUE LAS ANTERIORES, USANDO UN FOREACH -->
                <table class="w-full text-center">
                    <thead class="font-bold">
                        <tr>
                            <th class="py-1 border-r-2 border-r-black">DNI</th>
                            <th class="py-1 border-r-2 border-r-black">Nombre</th>
                            <th class="py-1 border-r-2 border-r-black">Apellidos</th>
                            <th class="py-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumnos_en_clase as $i => $alumno)
                        <!-- El x-show es para hacer funcional la busqueda por DNI. -->
                            <tr x-show="{{ json_encode($alumno->dni) }}.toLowerCase().includes(dniBusquedaClase.toLowerCase())"
                                class="{{ $i % 2 === 0 ? 'bg-[#295214]' : 'bg-[#39731C]' }}">
                                <td class="py-2 border-r-2 border-r-black">{{ $alumno->dni }}</td>
                                <td class="py-2 border-r-2 border-r-black">{{ $alumno->nombre }}</td>
                                <td class="py-2 border-r-2 border-r-black">{{ $alumno->apellido1 }},
                                    {{ $alumno->apellido2 }}</td>
                                <td class="py-2 flex justify-center">
                                    <!-- Para eliminar alumno de clase, se usa un form oculto-->
                                    <form method="POST"
                                        action="{{ route('classes.eliminarAlumno', ['id' => $clase->id, 'id_alumno' => $alumno->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <img src="/images/delete_icon.png" alt="eliminar" class="w-[30px]">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($alumnos_en_clase->isEmpty())
                            <tr>
                                <td colspan="4">No hay alumnos en esta clase.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ALUMNOS EN GENERAL: las funciones son las mismas -->
        <div class="w-1/2 p-4 bg-[#499424] rounded-[10px] shadow-mainShadow border-2 border-black"
            x-data="{ dniBusquedaGeneral: '' }">
            <h2 class="text-xl font-bold underline mb-3 text-center">
                AÑADIR NUEVOS ALUMNOS
            </h2>
            <input type="text" placeholder="Buscar Por DNI" x-model="dniBusquedaGeneral"
                class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[10px] py-[2px] mb-2">
            <div class="max-h-[460px] overflow-y-auto border-2 border-black rounded-lg">
                <table class="w-full text-center">
                    <thead class="font-black">
                        <tr>
                            <th class="py-1 border-r-2 border-r-black">DNI</th>
                            <th class="py-1 border-r-2 border-r-black">Nombre</th>
                            <th class="py-1 border-r-2 border-r-black">Apellidos</th>
                            <th class="py-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumnosGeneral as $i => $alumno)
                            <tr x-show="{{ json_encode($alumno->dni) }}.toLowerCase().includes(dniBusquedaGeneral.toLowerCase())"
                                class="{{ $i % 2 === 0 ? 'bg-[#295214]' : 'bg-[#39731C]' }}">
                                <td class="py-2 border-r-2 border-r-black">{{ $alumno->dni }}</td>
                                <td class="py-2 border-r-2 border-r-black">{{ $alumno->nombre }}</td>
                                <td class="py-2 border-r-2 border-r-black">{{ $alumno->apellido1 }},
                                    {{ $alumno->apellido2 }}</td>
                                <td class="py-2 flex justify-center">
                                    <form method="POST" action="{{ route('classes.agregarAlumno', $clase->id) }}">
                                        @csrf
                                        <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                                        <button type="submit">
                                            <img src="/images/add_icon.png" alt="agregar" class="w-[30px]">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($alumnosGeneral->isEmpty())
                            <tr>
                                <td colspan="4">No hay alumnos en esta clase.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Estas son notificaciones, para hacer saber al usuario sus acciones. -->
    @if (session('agregado'))
        <div id="notificacion_add"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-[10px] shadow-mainShadow z-[999]">
            {{ session('agregado') }}
        </div>
    @endif

    @if (session('eliminado'))
        <div id="notificacion_delete"
            class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-[10px] shadow-mainShadow z-[999]">
            {{ session('eliminado') }}
        </div>
    @endif
</x-clase-alumno-layout>
<script>
    // Timeout que quitara las notificaciones en u tinempo
    setTimeout(() => {
        const notificacion_add = document.getElementById('notificacion_add');
        if (notificacion_add) notificacion_add.remove();

        const notificacion_delete = document.getElementById('notificacion_delete');
        if (notificacion_delete) notificacion_delete.remove();

    }, 5000);
</script>
