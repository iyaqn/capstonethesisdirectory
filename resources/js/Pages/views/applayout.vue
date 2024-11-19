<template>
    <div>
        <navbar />
        <router-view />
        <customfooter />
    </div>
</template>

<script>
import navbar from "@/layouts/navbar.vue";
import customfooter from "@/layouts/customfooter.vue";
export default {
    components: { navbar, customfooter },
};
</script>

<style></style>
