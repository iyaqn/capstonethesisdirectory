<template>
  <div class="card">
    <div class="header">
      <h1>{{ title }}</h1>
    </div>
    <img :src="img" />
    <p>{{ total }}</p>
  </div>
</template>

<script>
export default {
  props: ["title", "total", "img"],
};
</script>

<style></style>
