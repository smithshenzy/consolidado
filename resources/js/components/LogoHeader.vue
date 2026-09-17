<template>
    <div class="ml-2 mt-2">
        <img :src="logoOriginal" alt="Systrue" class="dark:hidden block w-40 " />
        <img :src="logoWith" alt="Systrue"  class="dark:block hidden  w-40"  />
    </div>

</template>
<script setup>
const logoWith = '/storage/LogoSystrue/header-icon-white.png';
const logoOriginal = '/storage/LogoSystrue/header-icon.png';
</script>
