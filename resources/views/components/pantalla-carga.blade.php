<!--
    Pantalla de carga que se muestra antes de mostrar la pagina.
    Se necesitará el Apline para usar estos recursos.
    El "data", es una instancia que ocultara los elementos al finalizar el tiempo.

    Este tiempo se define en el "init", en este caso 1 segundo. Cuando pasen estos
    segundos, los elementos desaparecen.

    Los "transition" se encargan de manejar la opacidad, dandole un tiempo, comienzo y fin.
-->
<div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)" x-show="loading" x-transition:leave="transition-opacity duration-700"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-[#499424]">
    <div class="flex flex-col items-center space-y-4">
        <img src="/images/ILM_icon.png" alt="Cargando..." class="w-56 h-auto animate-bounce" draggable="false">
        <span class="text-2xl font-semibold text-white animate-pulse">Cargando...</span>
    </div>
</div>
