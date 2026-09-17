
<template>
    <header class="sticky top-0 z-50">

        <nav class="bg-slate-900 border-b border-cyan-400/20 shadow-lg">

            <div class="max-w-screen-2xl mx-auto px-3">

                <div class="flex items-center justify-between h-12">

<!--LOGO-->

                    <router-link
                        to="/"
                        class="flex items-center gap-3 min-w-0"
                    >

                        <div class="">

                            <h1
                                class="text-sm lg:text-base
                                       font-bold text-white
                                       font-orbitron tracking-wide
                                       truncate"
                            >
                                GESTIÓN INFORMÁTICA
                            </h1>

                        </div>

                    </router-link>


                    <!-- ================================================= -->
                    <!-- MENÚ DESKTOP -->
                    <!-- ================================================= -->

                    <div class="hidden md:flex items-center gap-1">

                        <!-- INICIO -->
                        <router-link
                            to="/finance"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-house"></i>
                            <span>Inicio</span>
                        </router-link>


                        <!-- INVENTARIO DE EQUIPOS -->
                        <router-link
                            to="/equipment-inventory"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-desktop"></i>
                            <span>Inventario de Equipos</span>
                        </router-link>


                        <!-- MESA DE AYUDA -->
                        <router-link
                            to="/helpdesk"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-headset"></i>
                            <span>Mesa de Ayuda</span>
                        </router-link>


                        <!-- INCIDENCIAS -->
                        <router-link
                            to="/incidents"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Incidencias</span>
                        </router-link>

                    </div>


                    <!-- ================================================= -->
                    <!-- USUARIO + HAMBURGUESA -->
                    <!-- ================================================= -->

                    <!-- USUARIO + HAMBURGUESA -->
                    <div class="flex items-center gap-2">

                        <!-- ========================================== -->
                        <!-- USUARIO -->
                        <!-- ========================================== -->

                        <div class="relative">

                            <button
                                @click="userMenuOpen = !userMenuOpen"
                                type="button"
                                class="flex items-center gap-2
                   rounded-lg
                   px-2 py-1.5
                   hover:bg-white/5
                   transition"
                            >

                                <!-- ICONO USUARIO -->
                                <div
                                    class="w-9 h-9 rounded-full
                       border border-cyan-400/30
                       bg-cyan-400/10
                       flex items-center justify-center
                       flex-shrink-0"
                                >
                                    <i class="fa-solid fa-user-astronaut text-cyan-400 text-sm"></i>
                                </div>


                                <!-- DATOS -->
                                <div
                                    v-if="user"
                                    class="hidden lg:block text-left"
                                >
                                    <p class="text-xs text-white">
                                        {{ user.name }}
                                    </p>

                                    <p class="text-[10px] text-slate-400">
                                        {{ user.email }}
                                    </p>
                                </div>


                                <!-- FLECHA -->
                                <i
                                    class="fa-solid fa-chevron-down
                       text-[10px] text-slate-400
                       hidden lg:block"
                                ></i>

                            </button>


                            <!-- ====================================== -->
                            <!-- DROPDOWN USUARIO -->
                            <!-- ====================================== -->

                            <div
                                v-if="userMenuOpen"
                                class="absolute right-0 mt-2
                   w-64
                   bg-slate-900
                   border border-cyan-400/20
                   rounded-xl
                   shadow-2xl
                   overflow-hidden
                   z-50"
                            >

                                <!-- INFORMACIÓN -->
                                <div class="px-4 py-4 border-b border-slate-700">

                                    <div class="flex items-center gap-3">

                                        <!-- ICONO USUARIO -->
                                        <div
                                            class="w-11 h-11

                               flex items-center justify-center
                               flex-shrink-0"
                                        >
                                            <i class="fa-solid fa-user-astronaut text-cyan-400 text-xl"></i>
                                        </div>


                                        <!-- DATOS -->
                                        <div
                                            v-if="user"
                                            class="min-w-0"
                                        >
                                            <p class="text-sm font-semibold text-white truncate">
                                                {{ user.name }}
                                            </p>

                                            <p class="text-xs text-slate-400 truncate">
                                                {{ user.email }}
                                            </p>
                                        </div>

                                    </div>

                                </div>


                                <!-- ====================================== -->
                                <!-- CERRAR SESIÓN -->
                                <!-- ====================================== -->

                                <div class="p-2">

                                    <button
                                        @click="logout"
                                        type="button"
                                        class="user-menu-item logout-item text-white"
                                    >
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                        <span>Cerrar sesión</span>
                                    </button>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- HAMBURGUESA -->
                        <!-- ========================================== -->

                        <button
                            @click="menuOpen = !menuOpen"
                            type="button"
                            class="md:hidden w-10 h-10
               flex items-center justify-center
               rounded-lg
               text-slate-300
               hover:text-cyan-400
               hover:bg-white/5
               transition"
                        >

                            <i
                                :class="menuOpen
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-bars'"
                                class="text-xl"
                            ></i>

                        </button>

                    </div>

                </div>


                <!-- ===================================================== -->
                <!-- MENÚ MOBILE -->
                <!-- ===================================================== -->

                <div
                    v-if="menuOpen"
                    class="md:hidden border-t border-slate-700/70 py-3"
                >

                    <div class="grid grid-cols-2 gap-2">

                        <router-link
                            to="/finance"
                            @click="menuOpen = false"
                            class="mobile-item"
                            active-class="mobile-active"
                        >
                            <i class="fa-solid fa-house"></i>
                            <span>Inicio</span>
                        </router-link>


                        <!-- INVENTARIO DE EQUIPOS -->
                        <router-link
                            to="/equipment-inventory"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-desktop"></i>
                            <span>Inventario de Equipos</span>
                        </router-link>


                        <!-- MESA DE AYUDA -->
                        <router-link
                            to="/helpdesk"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-headset"></i>
                            <span>Mesa de Ayuda</span>
                        </router-link>


                        <!-- INCIDENCIAS -->
                        <router-link
                            to="/incidents"
                            class="menu-item"
                            active-class="menu-active"
                        >
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>Incidencias</span>
                        </router-link>





                    </div>

                </div>

            </div>

        </nav>

    </header>
</template>


<script setup lang="ts">

import { ref, onMounted } from 'vue';
import axios from 'axios';

const menuOpen = ref(false);

const user = ref<any>(null);

const userPhoto = '/storage/clients/users/default.jpg';

const userMenuOpen = ref(false);
const logout = async () => {

    try {

        await axios.post('/logout');

        window.location.href = '/login';

    } catch (error) {

        console.error('Error al cerrar sesión:', error);

    }

};
onMounted(async () => {

    try {

        const response = await axios.get('/api/user');

        user.value = response.data;

    } catch (error) {

        console.error('No se pudo obtener el usuario:', error);

    }

});

</script>


<style scoped>

.menu-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 0.8rem;
    border-radius: 0.5rem;
    color: #cbd5e1;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.menu-item:hover {
    color: #22d3ee;
    background: rgba(255, 255, 255, 0.05);
}

.menu-active {
    color: #22d3ee;
    background: rgba(34, 211, 238, 0.08);
}


.mobile-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.8rem;
    border-radius: 0.5rem;
    color: #cbd5e1;
    background: rgba(255, 255, 255, 0.03);
    transition: all 0.2s ease;
}

.mobile-item:hover {
    color: #22d3ee;
    background: rgba(34, 211, 238, 0.08);
}

.mobile-active {
    color: #22d3ee;
    border: 1px solid rgba(34, 211, 238, 0.2);
}

.user-menu-item {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.7rem 0.75rem;
    border-radius: 0.5rem;
    color: #cbd5e1;
    font-size: 0.875rem;
    text-align: left;
    transition: all 0.2s ease;
}

.user-menu-item:hover {
    color: #22d3ee;
    background: rgba(34, 211, 238, 0.08);
}

.logout-item {
    color: #f87171;
}

.logout-item:hover {
    color: #fca5a5;
    background: rgba(239, 68, 68, 0.08);
}
</style>
