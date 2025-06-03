        <div
            class="flex flex-col justify-between bg-[#499424] text-white rounded-[15px] w-44 select-none shadow-mainShadow">
            <div>
                <!-- ICONO -->
                <div class="flex justify-center mb-2">
                    <img src="/images/ILM_icon.png" draggable="false" alt="icono" class="w-[150px] h-auto">
                </div>

                <!-- MENU PRINCIPAL -->
                <nav class="space-y-2">
                    <a href="/inicio" class="flex items-center gap-2 px-4 py-2 bg-[#39731C] hover:bg-[#295214] ">
                        <img src="/images/admin_panel_icon.png" draggable="false" alt="icono_panel" class="w-6 h-6">
                        <span class="font-semibold">Panel</span>
                    </a>
                    <div class="flex items-center gap-2 px-4 py-2 bg-[#295214] rounded-lg border-2 border-black">
                        <img src="/images/admin_user_icon.png" draggable="false" alt="icono_usuario" class="w-6 h-6">
                        <span class="font-semibold">Usuarios</span>
                    </div>
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
