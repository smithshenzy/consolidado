
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Modal from '../../components/Modal.vue';

const search = ref('');

const equipments = ref<any[]>([]);

const showModal = ref(false);
const modalMode = ref<'create' | 'edit' | 'view'>('create');

const selectedEquipment = ref<any>(null);

const form = ref({
    area: '',
    encargado_area: '',
    encargado_equipo: '',
    asset_code: '',
    brand: 'Generico',
    type: 'PC',
    operational_status: 'Operativo',
    decommissioned: false,
    ram: '',
    ram_type: '',
    disk: '',
    disk_capacity: '',
    procedure: '',
    priority: '',
    descripcion: '',
});

const stickerInventario = ref('');

const hardwareDetalle = ref([
    {
        tipo: '',
        marca: '',
        modelo: '',
        detalle: '',
        numero_serie: '',
    },
]);

const crearHardwareGeneral = () => [
    {
        item: 'PROCESADOR',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'PLACA',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'DISCO DURO',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'MEMORIA RAM',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'UNID./LECTOR CD O DVD',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'T. RED',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'T. VIDEO',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'OTRO - FUENTE',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
    {
        item: 'OTRO - COOLER CPU',
        tipo: '',
        marca: '',
        serie: '',
        modelo: '',
        capacidad: '',
        generacion: '',
    },
];

const hardwareGeneral = ref(crearHardwareGeneral());

/*
|--------------------------------------------------------------------------
| LISTAR EQUIPOS
|--------------------------------------------------------------------------
*/

const loadEquipments = async () => {

    try {

        const response = await axios.get('/equipment');

        equipments.value = response.data;

    } catch (error) {

        console.error('Error al cargar los equipos:', error);

    }

};


/*
|--------------------------------------------------------------------------
| BUSCAR
|--------------------------------------------------------------------------
*/

const filteredEquipments = () => {

    const value = search.value.toLowerCase().trim();

    if (!value) {
        return equipments.value;
    }

    return equipments.value.filter((equipment) =>
        String(equipment.asset_code ?? '').toLowerCase().includes(value) ||
        String(equipment.area ?? '').toLowerCase().includes(value) ||
        String(equipment.encargado_area ?? '').toLowerCase().includes(value) ||
        String(equipment.encargado_equipo ?? '').toLowerCase().includes(value) ||
        String(equipment.type ?? '').toLowerCase().includes(value) ||
        String(equipment.brand ?? '').toLowerCase().includes(value)
    );

};


/*
|--------------------------------------------------------------------------
| NUEVO
|--------------------------------------------------------------------------
*/

const createEquipment = () => {

    resetForm();

    modalMode.value = 'create';

    showModal.value = true;

};


/*
|--------------------------------------------------------------------------
| EDITAR
|--------------------------------------------------------------------------
*/

const editEquipment = (equipment: any) => {
    modalMode.value = 'edit';
    selectedEquipment.value = equipment;

    form.value = {
        area: equipment.area ?? '',
        encargado_area: equipment.encargado_area ?? '',
        encargado_equipo: equipment.encargado_equipo ?? '',
        asset_code: equipment.asset_code ?? '',
        brand: equipment.brand ?? 'Generico',
        type: equipment.type ?? 'PC',
        operational_status: equipment.operational_status ?? 'Operativo',
        decommissioned: equipment.decommissioned ?? false,
        ram: equipment.ram ?? '',
        ram_type: equipment.ram_type ?? '',
        disk: equipment.disk ?? '',
        disk_capacity: equipment.disk_capacity ?? '',
        procedure: equipment.procedure ?? '',
        priority: equipment.priority ?? '',
        descripcion: equipment.descripcion ?? '',
    };

    stickerInventario.value = equipment.sticker_inventario ?? '';

    hardwareDetalle.value = equipment.hardware_detalle?.length
        ? [...equipment.hardware_detalle]
        : [
            {
                tipo: '',
                marca: '',
                modelo: '',
                detalle: '',
                numero_serie: '',
            },
        ];
    hardwareGeneral.value = equipment.hardware_general?.length
        ? [...equipment.hardware_general]
        : crearHardwareGeneral();

    showModal.value = true;
};



/*
|--------------------------------------------------------------------------
| VER
|--------------------------------------------------------------------------
*/

const viewEquipment = (equipment: any) => {

    selectedEquipment.value = equipment;

    modalMode.value = 'view';

    showModal.value = true;

};


/*
|--------------------------------------------------------------------------
| VALIDAR FORMULARIO
|--------------------------------------------------------------------------
*/

const validateForm = () => {

    if (!form.value.area.trim()) {

        alert('El campo Área es obligatorio.');

        return false;

    }

    if (!form.value.encargado_area.trim()) {

        alert('El campo Encargado de Área es obligatorio.');

        return false;

    }

    return true;

};


/*
|--------------------------------------------------------------------------
| GUARDAR
|--------------------------------------------------------------------------
*/

const saveEquipment = async () => {

    if (!validateForm()) {
        return;
    }

    try {

        const data = {
            ...form.value,

            ...(modalMode.value === 'edit' && {
                sticker_inventario: stickerInventario.value,
                hardware_detalle: hardwareDetalle.value,
                hardware_general: hardwareGeneral.value,
            }),
        };

        if (modalMode.value === 'create') {

            await axios.post('/equipment/add', data);

        } else if (modalMode.value === 'edit') {

            await axios.post('/equipment/update', {
                id: selectedEquipment.value.id,
                ...data,
            });

        }

        closeModal();

        await loadEquipments();

    } catch (error) {

        console.error('Error al guardar el equipo:', error);

    }

};


/*
|--------------------------------------------------------------------------
| ELIMINAR
|--------------------------------------------------------------------------
*/

const deleteEquipment = async (id: number) => {

    const confirmed = confirm(
        '¿Está seguro de eliminar este equipo?'
    );

    if (!confirmed) {
        return;
    }

    try {

        await axios.delete(`/equipment/delete/${id}`);

        await loadEquipments();

    } catch (error) {

        console.error('Error al eliminar el equipo:', error);

    }

};


/*
|--------------------------------------------------------------------------
| CERRAR MODAL
|--------------------------------------------------------------------------
*/

const closeModal = () => {

    showModal.value = false;

    selectedEquipment.value = null;

};


/*
|--------------------------------------------------------------------------
| LIMPIAR FORMULARIO
|--------------------------------------------------------------------------
*/

const resetForm = () => {

    form.value = {
        area: '',
        encargado_area: '',
        encargado_equipo: '',
        asset_code: '',
        brand: 'Generico',
        type: 'PC',
        operational_status: 'Operativo',
        decommissioned: false,
        ram: '',
        ram_type: '',
        disk: '',
        disk_capacity: '',
        procedure: '',
        priority: '',
        descripcion: '',
    };

    stickerInventario.value = '';

    hardwareDetalle.value = [
        {
            tipo: '',
            marca: '',
            modelo: '',
            detalle: '',
            numero_serie: '',
        },
    ];

    hardwareGeneral.value = crearHardwareGeneral();
};


/*
|--------------------------------------------------------------------------
| INICIO
|--------------------------------------------------------------------------
*/

onMounted(() => {

    loadEquipments();

});
</script>


<template>

    <div class="min-h-screen bg-gray-100 p-4 sm:p-6">

        <div class="max-w-screen-2xl mx-auto">

            <!-- HEADER -->

            <div
                class="flex flex-col sm:flex-row
                       sm:items-center sm:justify-between
                       gap-4 mb-6"
            >

                <div>

                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">
                        Inventario de Equipos
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Registro y control de equipos informáticos
                    </p>

                </div>


                <!-- NUEVO -->

                <button
                    @click="createEquipment"
                    type="button"
                    class="inline-flex items-center justify-center gap-2
                           px-4 py-2.5
                           rounded-lg
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           font-medium
                           text-sm
                           transition"
                >

                    <i class="fa-solid fa-plus"></i>

                    Nuevo Equipo

                </button>

            </div>


            <!-- PANEL -->

            <div
                class="bg-white
                       border border-gray-200
                       rounded-lg
                       shadow-sm
                       overflow-hidden"
            >

                <!-- TOOLBAR -->

                <div
                    class="p-4
                           border-b border-gray-200
                           flex flex-col sm:flex-row
                           gap-3
                           sm:items-center
                           sm:justify-between"
                >

                    <!-- BUSCADOR -->

                    <div class="relative w-full sm:max-w-md">

                        <i
                            class="fa-solid fa-magnifying-glass
                                   absolute left-3 top-1/2
                                   -translate-y-1/2
                                   text-gray-400"
                        ></i>

                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar por código, área, encargado..."
                            class="w-full
                                   bg-white
                                   border border-gray-300
                                   rounded-lg
                                   pl-10 pr-4 py-2.5
                                   text-sm text-gray-700
                                   placeholder-gray-400
                                   focus:outline-none
                                   focus:border-blue-500
                                   focus:ring-1
                                   focus:ring-blue-500"
                        />

                    </div>


                    <!-- TOTAL -->

                    <div class="text-sm text-gray-500">

                        Total:

                        <span class="font-semibold text-gray-800">
                            {{ filteredEquipments().length }}
                        </span>

                        equipos

                    </div>

                </div>


                <!-- TABLA -->

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50">

                        <tr class="text-left text-gray-600">

                            <th class="px-4 py-3 font-semibold">
                                Código Patrimonial
                            </th>

                            <th class="px-4 py-3 font-semibold">
                                Tipo
                            </th>

                            <th class="px-4 py-3 font-semibold">
                                Marca
                            </th>

                            <th class="px-4 py-3 font-semibold">
                                Área
                            </th>

                            <th class="px-4 py-3 font-semibold">
                                Encargado de Área
                            </th>

                            <th class="px-4 py-3 font-semibold">
                                Encargado de Equipo
                            </th>

                            <th class="px-4 py-3 font-semibold">
                                Estado
                            </th>

                            <th class="px-4 py-3 font-semibold text-center">
                                Acciones
                            </th>

                        </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-200">

                        <tr
                            v-for="equipment in filteredEquipments()"
                            :key="equipment.id"
                            class="hover:bg-gray-50 transition"
                        >

                            <!-- CÓDIGO -->

                            <td class="px-4 py-3">

                                <span class="font-medium text-gray-700">
                                    {{ equipment.asset_code || '—' }}
                                </span>

                            </td>


                            <!-- TIPO -->

                            <td class="px-4 py-3 text-gray-700">

                                <div class="flex items-center gap-2">

                                    <i class="fa-solid fa-desktop text-gray-400"></i>

                                    {{ equipment.type || '—' }}

                                </div>

                            </td>


                            <!-- MARCA -->

                            <td class="px-4 py-3 text-gray-700">
                                {{ equipment.brand || '—' }}
                            </td>


                            <!-- ÁREA -->

                            <td class="px-4 py-3 text-gray-600">
                                {{ equipment.area || '—' }}
                            </td>


                            <!-- ENCARGADO ÁREA -->

                            <td class="px-4 py-3 text-gray-600">
                                {{ equipment.encargado_area || '—' }}
                            </td>


                            <!-- ENCARGADO EQUIPO -->

                            <td class="px-4 py-3 text-gray-600">
                                {{ equipment.encargado_equipo || '—' }}
                            </td>


                            <!-- ESTADO -->

                            <td class="px-4 py-3">

                                <span
                                    class="inline-flex items-center gap-1.5
                                           px-2.5 py-1
                                           rounded-full
                                           text-xs font-medium"
                                    :class="
                                        equipment.operational_status === 'Operativo'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-700'
                                    "
                                >

                                    <span
                                        class="w-1.5 h-1.5 rounded-full"
                                        :class="
                                            equipment.operational_status === 'Operativo'
                                                ? 'bg-green-500'
                                                : 'bg-red-500'
                                        "
                                    ></span>

                                    {{ equipment.operational_status || '—' }}

                                </span>

                            </td>


                            <!-- ACCIONES -->

                            <td class="px-4 py-3">

                                <div
                                    class="flex items-center
                                           justify-center gap-1"
                                >

                                    <!-- VER -->

                                    <button
                                        @click="viewEquipment(equipment)"
                                        type="button"
                                        title="Ver"
                                        class="w-8 h-8
                                               rounded-lg
                                               flex items-center justify-center
                                               text-gray-500
                                               hover:text-blue-600
                                               hover:bg-blue-50
                                               transition"
                                    >

                                        <i class="fa-solid fa-eye"></i>

                                    </button>


                                    <!-- EDITAR -->

                                    <button
                                        @click="editEquipment(equipment)"
                                        type="button"
                                        title="Editar"
                                        class="w-8 h-8
                                               rounded-lg
                                               flex items-center justify-center
                                               text-gray-500
                                               hover:text-blue-600
                                               hover:bg-blue-50
                                               transition"
                                    >

                                        <i class="fa-solid fa-pen"></i>

                                    </button>


                                    <!-- ELIMINAR -->

                                    <button
                                        @click="deleteEquipment(equipment.id)"
                                        type="button"
                                        title="Eliminar"
                                        class="w-8 h-8
                                               rounded-lg
                                               flex items-center justify-center
                                               text-gray-500
                                               hover:text-red-600
                                               hover:bg-red-50
                                               transition"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>


                        <!-- SIN RESULTADOS -->

                        <tr v-if="filteredEquipments().length === 0">

                            <td
                                colspan="8"
                                class="px-4 py-12 text-center"
                            >

                                <i
                                    class="fa-solid fa-box-open
                                           text-3xl
                                           text-gray-300
                                           mb-3"
                                ></i>

                                <p class="text-gray-500">
                                    No se encontraron equipos
                                </p>

                            </td>

                        </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- =====================================================
             MODAL
        ====================================================== -->

        <Modal
            :show="showModal"

            :title="
                modalMode === 'create'
                    ? 'Registrar Equipo'
                    : modalMode === 'edit'
                        ? 'Editar Equipo'
                        : 'Detalle del Equipo'
            "

            :icon="
                modalMode === 'create'
                    ? 'fa-solid fa-plus'
                    : modalMode === 'edit'
                        ? 'fa-solid fa-pen'
                        : 'fa-solid fa-eye'
            "

            @close="closeModal"
        >

            <!-- =================================================
                 FORMULARIO
            ================================================== -->

            <div
                v-if="modalMode === 'create' || modalMode === 'edit'"
                class="space-y-6"
            >

                <!-- INFORMACIÓN GENERAL -->

                <div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-3">
                        Información General
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- ÁREA -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Área <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.area"
                                type="text"
                                class="form-input"
                            >

                        </div>


                        <!-- ENCARGADO DE ÁREA -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Encargado de Área <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.encargado_area"
                                type="text"
                                class="form-input"
                            >

                        </div>


                        <!-- ENCARGADO DE EQUIPO -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Encargado de Equipo
                            </label>

                            <input
                                v-model="form.encargado_equipo"
                                type="text"
                                class="form-input"
                            >

                        </div>


                        <!-- CÓDIGO PATRIMONIAL -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Código Patrimonial
                            </label>

                            <input
                                v-model="form.asset_code"
                                type="text"
                                class="form-input"
                            >

                        </div>


                        <!-- MARCA -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Marca
                            </label>

                            <input
                                v-model="form.brand"
                                type="text"
                                class="form-input"
                            >

                        </div>


                        <!-- TIPO DE EQUIPO -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Equipo
                            </label>

                            <select
                                v-model="form.type"
                                class="form-input"
                            >

                                <option value="PC">
                                    PC
                                </option>

                                <option value="Laptop">
                                    Laptop
                                </option>

                                <option value="Todo en uno">
                                    Todo en uno
                                </option>

                                <option value="Impresora">
                                    Impresora
                                </option>

                            </select>

                        </div>


                        <!-- ESTADO OPERATIVIDAD -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Estado de Operatividad
                            </label>

                            <select
                                v-model="form.operational_status"
                                class="form-input"
                            >

                                <option value="Operativo">
                                    Operativo
                                </option>

                                <option value="Inoperativo">
                                    Inoperativo
                                </option>

                            </select>

                        </div>


                        <!-- BAJA -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Baja
                            </label>

                            <select
                                v-model="form.decommissioned"
                                class="form-input"
                            >

                                <option :value="false">
                                    No
                                </option>

                                <option :value="true">
                                    Sí
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- HARDWARE -->

                <div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-3">
                        Características del Equipo
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- RAM -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                RAM
                            </label>

                            <input
                                v-model="form.ram"
                                type="text"
                                placeholder="Ej. 8 GB"
                                class="form-input"
                            >

                        </div>


                        <!-- TIPO RAM -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo RAM
                            </label>

                            <select
                                v-model="form.ram_type"
                                class="form-input"
                            >

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="DDR2">
                                    DDR2
                                </option>

                                <option value="DDR3">
                                    DDR3
                                </option>

                                <option value="DDR4">
                                    DDR4
                                </option>

                                <option value="DDR5">
                                    DDR5
                                </option>

                            </select>

                        </div>


                        <!-- DISCO -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Disco
                            </label>

                            <select
                                v-model="form.disk"
                                class="form-input"
                            >

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="HDD">
                                    HDD
                                </option>

                                <option value="SSD SATA">
                                    SSD SATA
                                </option>

                                <option value="SSD NVMe">
                                    SSD NVMe
                                </option>

                            </select>

                        </div>


                        <!-- CAPACIDAD DISCO -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Capacidad Disco
                            </label>

                            <input
                                v-model="form.disk_capacity"
                                type="text"
                                placeholder="Ej. 480 GB"
                                class="form-input"
                            >

                        </div>

                    </div>

                </div>


                <!-- GESTIÓN TÉCNICA -->

                <div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-3">
                        Gestión Técnica
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- PROCEDIMIENTO -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Procedimiento
                            </label>

                            <select
                                v-model="form.procedure"
                                class="form-input"
                            >

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="Preventivo">
                                    Preventivo
                                </option>

                                <option value="Correctivo">
                                    Correctivo
                                </option>

                                <option value="Reparación">
                                    Reparación
                                </option>

                            </select>

                        </div>


                        <!-- PRIORIDAD -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prioridad
                            </label>

                            <select
                                v-model="form.priority"
                                class="form-input"
                            >

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="Leve">
                                    Leve
                                </option>

                                <option value="Puede esperar">
                                    Puede esperar
                                </option>

                                <option value="Urgente">
                                    Urgente
                                </option>

                                <option value="Superurgente">
                                    Superurgente
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- DESCRIPCIÓN -->

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción
                    </label>

                    <textarea
                        v-model="form.descripcion"
                        rows="3"
                        class="form-input"
                        placeholder="Ingrese una descripción..."
                    ></textarea>

                </div>


                <!-- =================================================
   DATOS DEL HARDWARE
================================================== -->

                <div
                    v-if="modalMode === 'edit'"
                    class="mt-8 border border-gray-200 rounded-xl bg-gray-50 overflow-hidden"
                >

                    <!-- CABECERA -->
                    <div class="px-5 py-4 bg-white border-b border-gray-200">

                        <div class="flex items-center gap-2">


                            <div>
                                <h3 class="text-base font-semibold text-gray-800">
                                    Datos del Hardware
                                </h3>

                            </div>

                        </div>

                    </div>


                    <div class="p-5 space-y-7">

                        <!-- =================================================
                             STICKER DE INVENTARIO
                        ================================================== -->

                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">

                                Sticker de Inventario

                            </label>

                            <input
                                v-model="stickerInventario"
                                type="text"
                                class="form-input"
                                placeholder="Ingrese el sticker de inventario (2021)"
                            >

                        </div>


                        <!-- =================================================
                             HARDWARE DETALLE
                        ================================================== -->

                        <div>

                            <h4 class="text-sm font-semibold text-gray-800 mb-3">
                                Detalles
                            </h4>

                            <div
                                class="overflow-x-auto
               border border-gray-200
               rounded-lg
               bg-white"
                            >

                                <div class="overflow-x-auto border border-gray-300 rounded-lg bg-white">

                                    <table
                                        id="tabla-detalle"
                                        class="w-full border-collapse text-sm"
                                    >

                                        <thead>
                                        <tr class="bg-gray-50">

                                            <th
                                                class="border border-gray-300 px-3 py-2.5
                           text-left text-xs font-semibold
                           text-gray-700 whitespace-nowrap"
                                                style="width: 24%"
                                            >
                                                Detalle
                                            </th>

                                            <th
                                                class="border border-gray-300 px-3 py-2.5
                           text-left text-xs font-semibold
                           text-gray-700 whitespace-nowrap"
                                                style="width: 18%"
                                            >
                                                N° de serie
                                            </th>

                                            <th
                                                class="border border-gray-300 px-3 py-2.5
                           text-left text-xs font-semibold
                           text-gray-700 whitespace-nowrap"
                                                style="width: 18%"
                                            >
                                                Marca
                                            </th>

                                            <th
                                                class="border border-gray-300 px-3 py-2.5
                           text-left text-xs font-semibold
                           text-gray-700 whitespace-nowrap"
                                                style="width: 20%"
                                            >
                                                Modelo
                                            </th>

                                            <th
                                                class="border border-gray-300 px-3 py-2.5
                           text-left text-xs font-semibold
                           text-gray-700 whitespace-nowrap"
                                                style="width: 20%"
                                            >
                                                Tipo
                                            </th>

                                        </tr>
                                        </thead>


                                        <tbody>

                                        <tr
                                            v-for="(row, index) in hardwareDetalle"
                                            :key="index"
                                            class="hover:bg-gray-50"
                                        >

                                            <!-- DETALLE -->

                                            <td class="border border-gray-300 p-1.5">

                                                <input
                                                    v-model="row.detalle"
                                                    type="text"
                                                    placeholder="Detalle"
                                                    class="w-full border border-gray-200
                               rounded-md px-2.5 py-2
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:border-blue-500
                               focus:ring-1
                               focus:ring-blue-500"
                                                >

                                            </td>


                                            <!-- N° DE SERIE -->

                                            <td class="border border-gray-300 p-1.5">

                                                <input
                                                    v-model="row.numero_serie"
                                                    type="text"
                                                    placeholder="N° de serie"
                                                    class="w-full border border-gray-200
                               rounded-md px-2.5 py-2
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:border-blue-500
                               focus:ring-1
                               focus:ring-blue-500"
                                                >

                                            </td>


                                            <!-- MARCA -->

                                            <td class="border border-gray-300 p-1.5">

                                                <input
                                                    v-model="row.marca"
                                                    type="text"
                                                    placeholder="Marca"
                                                    class="w-full border border-gray-200
                               rounded-md px-2.5 py-2
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:border-blue-500
                               focus:ring-1
                               focus:ring-blue-500"
                                                >

                                            </td>


                                            <!-- MODELO -->

                                            <td class="border border-gray-300 p-1.5">

                                                <input
                                                    v-model="row.modelo"
                                                    type="text"
                                                    placeholder="Modelo"
                                                    class="w-full border border-gray-200
                               rounded-md px-2.5 py-2
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:border-blue-500
                               focus:ring-1
                               focus:ring-blue-500"
                                                >

                                            </td>


                                            <!-- TIPO -->

                                            <td class="border border-gray-300 p-1.5">

                                                <input
                                                    v-model="row.tipo"
                                                    type="text"
                                                    placeholder="Tipo"
                                                    class="w-full border border-gray-200
                               rounded-md px-2.5 py-2
                               text-sm text-gray-700
                               placeholder-gray-400
                               focus:outline-none
                               focus:border-blue-500
                               focus:ring-1
                               focus:ring-blue-500"
                                                >

                                            </td>

                                        </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>


                        <!-- =================================================
                             HARDWARE GENERAL
                        ================================================== -->

                        <div>

                            <div class="mb-3">

                                <h4 class="text-sm font-semibold text-gray-800">
                                    Datos generales del equipo
                                </h4>

                                <p class="text-xs text-gray-500 mt-0.5">
                                    Información de los componentes principales del equipo
                                </p>

                            </div>

                            <div class="overflow-x-auto border border-gray-300 rounded-lg bg-white">

                                <table class="w-full border-collapse text-xs">

                                    <thead>
                                    <tr class="bg-gray-50">

                                        <!-- ITEM -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:150px"
                                        >
                                            Item
                                        </th>

                                        <!-- MARCA -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:120px"
                                        >
                                            Marca
                                        </th>

                                        <!-- TIPO -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:120px"
                                        >
                                            Tipo
                                        </th>

                                        <!-- MODELO -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:120px"
                                        >
                                            Modelo
                                        </th>

                                        <!-- GENERACIÓN -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:110px"
                                        >
                                            Generación
                                        </th>

                                        <!-- CAPACIDAD -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:120px"
                                        >
                                            Capacidad
                                        </th>

                                        <!-- SERIE -->
                                        <th
                                            class="border border-gray-300 px-2 py-2 text-left text-[11px] font-semibold text-gray-700 whitespace-nowrap"
                                            style="min-width:140px"
                                        >
                                            Serie
                                        </th>

                                    </tr>
                                    </thead>


                                    <tbody>

                                    <tr
                                        v-for="(row, index) in hardwareGeneral"
                                        :key="index"
                                        class="hover:bg-gray-50"
                                    >

                                        <!-- ITEM -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                type="text"
                                                :value="row.item"
                                                readonly
                                                class="w-full
                           bg-gray-100
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           font-medium
                           text-gray-700
                           cursor-not-allowed"
                                            >

                                        </td>


                                        <!-- MARCA -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                v-model="row.marca"
                                                type="text"
                                                placeholder="Marca"
                                                class="w-full
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-1
                           focus:ring-blue-500"
                                            >

                                        </td>


                                        <!-- TIPO -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                v-model="row.tipo"
                                                type="text"
                                                placeholder="Tipo"
                                                class="w-full
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-1
                           focus:ring-blue-500"
                                            >

                                        </td>


                                        <!-- MODELO -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                v-model="row.modelo"
                                                type="text"
                                                placeholder="Modelo"
                                                class="w-full
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-1
                           focus:ring-blue-500"
                                            >

                                        </td>


                                        <!-- GENERACIÓN -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                v-model="row.generacion"
                                                type="text"
                                                placeholder="Generación"
                                                class="w-full
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-1
                           focus:ring-blue-500"
                                            >

                                        </td>


                                        <!-- CAPACIDAD -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                v-model="row.capacidad"
                                                type="text"
                                                placeholder="Capacidad"
                                                class="w-full
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-1
                           focus:ring-blue-500"
                                            >

                                        </td>


                                        <!-- SERIE -->

                                        <td class="border border-gray-300 p-1">

                                            <input
                                                v-model="row.serie"
                                                type="text"
                                                placeholder="N° serie"
                                                class="w-full
                           border border-gray-200
                           rounded-md
                           px-2 py-1.5
                           text-xs
                           text-gray-700
                           placeholder-gray-400
                           focus:outline-none
                           focus:border-blue-500
                           focus:ring-1
                           focus:ring-blue-500"
                                            >

                                        </td>

                                    </tr>

                                    </tbody>

                                </table>

                            </div>


                        </div>

                    </div>

                </div>
            </div>


            <!-- =================================================
                 VER
            ================================================== -->

            <div
                v-else
                class="space-y-6"
            >

                <!-- INFORMACIÓN GENERAL -->

                <div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-3">
                        Información General
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <p class="text-xs text-gray-500">
                                Área
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.area || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Encargado de Área
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.encargado_area || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Encargado de Equipo
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.encargado_equipo || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Código Patrimonial
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.asset_code || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Marca
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.brand || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Tipo de Equipo
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.type || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Estado de Operatividad
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.operational_status || '—' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-xs text-gray-500">
                                Baja
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.decommissioned ? 'Sí' : 'No' }}
                            </p>
                        </div>

                    </div>

                </div>


                <!-- HARDWARE -->

                <div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-3">
                        Características del Equipo
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <p class="text-xs text-gray-500">
                                RAM
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.ram || '—' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-gray-500">
                                Tipo RAM
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.ram_type || '—' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-gray-500">
                                Disco
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.disk || '—' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-gray-500">
                                Capacidad Disco
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.disk_capacity || '—' }}
                            </p>

                        </div>

                    </div>

                </div>


                <!-- GESTIÓN TÉCNICA -->

                <div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-3">
                        Gestión Técnica
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <p class="text-xs text-gray-500">
                                Procedimiento
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.procedure || '—' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-xs text-gray-500">
                                Prioridad
                            </p>

                            <p class="text-sm font-medium text-gray-800">
                                {{ selectedEquipment?.priority || '—' }}
                            </p>

                        </div>

                    </div>

                </div>


                <!-- DESCRIPCIÓN -->

                <div>

                    <p class="text-xs text-gray-500">
                        Descripción
                    </p>

                    <p class="text-sm text-gray-800 whitespace-pre-line">
                        {{ selectedEquipment?.descripcion || '—' }}
                    </p>

                </div>



            </div>




            <!-- FOOTER -->

            <template #footer>

                <button
                    type="button"
                    @click="closeModal"
                    class="px-4 py-2
                           rounded-lg
                           border border-gray-300
                           text-gray-700
                           hover:bg-gray-100
                           text-sm
                           transition"
                >
                    Cancelar
                </button>


                <button
                    v-if="modalMode === 'create' || modalMode === 'edit'"
                    @click="saveEquipment"
                    type="button"
                    class="px-4 py-2
                           rounded-lg
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           text-sm
                           font-medium
                           transition"
                >

                    <i
                        :class="
                            modalMode === 'create'
                                ? 'fa-solid fa-save'
                                : 'fa-solid fa-check'
                        "
                        class="mr-1"
                    ></i>

                    {{ modalMode === 'create' ? 'Guardar' : 'Actualizar' }}

                </button>

            </template>

        </Modal>

    </div>

</template>


<style scoped>

.form-input {
    @apply w-full
    px-3 py-2
    border border-gray-300
    rounded-lg
    text-sm text-gray-700
    bg-white
    focus:outline-none
    focus:border-blue-500
    focus:ring-1
    focus:ring-blue-500;
}

</style>
