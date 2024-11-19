<template>
    <div>
        <banner />
        <dashboard />
        <dataview />
    </div>
</template>

<script>
import banner from "@/components/home/sections/banner.vue";
import dashboard from "@/components/home/sections/dashboard.vue";
import Dataview from "@/components/home/sections/dataview.vue";
export default {
    components: { banner, dashboard, Dataview },
};
</script>

<style></style>
