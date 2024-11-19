<template>
  <div class="menubar">
    <i class="pi pi-times close-icon" @click="this.$emit('close')"></i>
    <div class="menu-links col">
      <div class="main-links col">
        <router-link to="/">Home</router-link>
        <router-link to="/">IP-Registered</router-link>
        <router-link to="/">Upload</router-link>
        <router-link to="/">Approvals</router-link>
      </div>
      <div class="admin-links col">
        <router-link to="/">Users</router-link>
        <router-link to="/">Groups</router-link>
      </div>
    </div>
    <div class="user-links col">
      <p to="/">Profile</p>
      <p to="/">Logout</p>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
