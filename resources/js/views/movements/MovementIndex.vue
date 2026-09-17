<template>
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">
            Movimientos
        </h1>

        <table class="w-full border-collapse border">
            <thead>
            <tr>
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Tipo</th>
                <th class="border p-2">Categoría</th>
                <th class="border p-2">Concepto</th>
                <th class="border p-2">Monto</th>
            </tr>
            </thead>

            <tbody>
            <tr
                v-for="movement in movements"
                :key="movement.id"
            >
                <td class="border p-2">
                    {{ movement.date }}
                </td>

                <td class="border p-2">
                    {{ movement.type }}
                </td>

                <td class="border p-2">
                    {{ movement.category }}
                </td>

                <td class="border p-2">
                    {{ movement.concept }}
                </td>

                <td class="border p-2">
                    {{ movement.amount }}
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const movements = ref([]);

onMounted(async () => {
    const response = await axios.get('/api/movements');

    movements.value = response.data;
});
</script>
