
<!--
    Este componente sirve para mostrar mensajes de error segun la validacion.
    Usando un if, se comprueba si hay errores. Luego con el bucle for, se muestras cuantos errores esten.
-->
@props(['mensajes_error'])

@if ($mensajes_error && count($mensajes_error) > 0)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 font-bold mt-2']) }}>
        @foreach ((array) $mensajes_error as $mensaje)
            <li>{{ $mensaje }}</li>
        @endforeach
    </ul>
@endif
