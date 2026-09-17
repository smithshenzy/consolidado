<script setup lang="ts">
defineProps<{
    show: boolean;
    title?: string;
    icon?: string;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();
</script>

<template>
    <!-- OVERLAY -->
    <div
        v-if="show"
        class="fixed inset-0 z-50
               flex items-center justify-center
               p-4
               bg-black/40"
        @click.self="emit('close')"
    >

        <!-- MODAL -->
        <div
            class="w-full max-w-2xl
                   bg-white
                   rounded-lg
                   shadow-xl
                   overflow-hidden"
        >

            <!-- HEADER -->
            <div
                class="flex items-center justify-between
                       px-5 py-4
                       border-b border-gray-200"
            >

                <!-- TITULO -->
                <div class="flex items-center gap-3">

                    <!-- ICONO -->
                    <div
                        v-if="icon"
                        class="w-9 h-9
                               rounded-lg
                               bg-blue-50
                               flex items-center justify-center"
                    >
                        <i
                            :class="icon"
                            class="text-blue-600"
                        ></i>
                    </div>

                    <!-- TEXTO -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ title }}
                        </h2>

                        <p
                            v-if="$slots.subtitle"
                            class="text-xs text-gray-500 mt-0.5"
                        >
                            <slot name="subtitle" />
                        </p>
                    </div>

                </div>


                <!-- CERRAR -->
                <button
                    type="button"
                    @click="emit('close')"
                    class="w-8 h-8
                           rounded-lg
                           flex items-center justify-center
                           text-gray-400
                           hover:text-gray-700
                           hover:bg-gray-100
                           transition"
                    title="Cerrar"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>


            <!-- CONTENIDO -->
            <div class="px-5 py-5 max-h-[70vh] overflow-y-auto">

                <slot />

            </div>


            <!-- FOOTER -->
            <div
                v-if="$slots.footer"
                class="flex items-center justify-end gap-2
                       px-5 py-4
                       border-t border-gray-200
                       bg-gray-50"
            >
                <slot name="footer" />
            </div>

        </div>

    </div>
</template>
