<template>
  <menubar
    :class="menubarActive ? 'active' : ''"
    @close="menubarActive = false"
  />
  <nav class="row">
    <div class="logo row">
      <img
        src="https://res.cloudinary.com/dpm5vdakr/image/upload/v1731330211/capstone_directory/cics-logo.png"
      />
      <div class="col">
        <small>UST-CICS</small>
        <small>Capstone Directory</small>
      </div>
    </div>
    <div
      class="burger-icon"
      @click="
        () => {
          menubarActive = true;
        }
      "
    >
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M5 8H13.75M5 12H19M10.25 16L19 16"
          stroke="#464455"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </div>
  </nav>
</template>

<script>
import menubar from "./menubar.vue";
export default {
  components: { menubar },
  data() {
    return {
      menubarActive: false,
    };
  },
};
</script>

<style></style>
