<x-login-layout>
    <!-- Session Status: Esto generado por default. Al paecer, manda mensajes del estado del logeo. -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- INPUT DEL EMAIL -->
        <div>
            <label for="email" class="text-white font-bold text-lg select-none">Correo electrónico</label>
            <input id="email" class="block mt-1 border-black border-[2px] rounded-lg" type="email" name="email"
                required autofocus placeholder="ejemplo@gmail.com">
            <x-input_error :mensajes_error="$errors->get('email')" />
        </div>

        <!-- INPUT DE LA CONTRASEÑA -->
        <div class="mt-4">
            <label for="email" class="text-white font-bold text-lg select-none">Contraseña</label>
            <input id="password" class="block mt-1 border-black border-[2px] rounded-lg" type="password"
                name="password" required placeholder="contraseña">
        </div>

        <div class="flex items-center justify-center mt-4">
            <button
                class="rounded-[10px] bg-[#D9D9D9] border-black border-[2px] text-black font-bold px-[20px] py-[4px] select-none hover:bg-gray-400">
                {{ __('Entrar') }}
            </button>
        </div>
    </form>
</x-login-layout>
