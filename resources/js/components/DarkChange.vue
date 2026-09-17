<template>
    <div>
        <button @click="changeDark" class="1921

          bg-gradient-to-l
          from-gray-100
          via-gray-300
          to-gray-600

          hover:bg-gray-500
          focus:ring-2 focus:ring-gray-600 dark:focus:ring-gray-300

          active:text-opacity-75
          bg-gray-400
          dark:bg-gray-300
          rounded-full
          w-9 h-9
          max-md:w-8
          max-md:h-8
         ">
            <i v-if="!toggleDarkMode" class="fa-solid fa-moon "></i>
            <i v-else class="fa-solid fa-sun "></i>
        </button>
    </div>


</template>

<script setup>
import { ref, onMounted } from 'vue';
const toggleDarkMode = ref(false);
const changeDark = () => {
    toggleDarkMode.value = !toggleDarkMode.value;
    document.documentElement.classList.toggle('dark', toggleDarkMode.value);
    localStorage.theme = toggleDarkMode.value ? 'dark' : 'light';

};

onMounted(() => {
    if (
        localStorage.theme === 'dark' ||
        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        toggleDarkMode.value = true;
        document.documentElement.classList.add('dark');
    } else {
        toggleDarkMode.value = false;
        document.documentElement.classList.remove('dark');
    }
});
</script>
