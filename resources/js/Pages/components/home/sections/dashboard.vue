<template>
  <div class="dashboard wrap">
    <card
      :title="'BEST'"
      :total="45"
      :img="'https://res.cloudinary.com/dpm5vdakr/image/upload/v1731589100/capstone_directory/d3cccfab-1083-4f0f-a4fd-97698c0914f2.png'"
      class="first"
    />
    <card
      :title="'ALL'"
      :total="200"
      :img="'https://res.cloudinary.com/dpm5vdakr/image/upload/v1731589080/capstone_directory/d15d3f3c-51c4-4a1d-83ac-89d3309d8e27.png'"
      class="last"
    />
  </div>
</template>

<script>
import card from "../card/card.vue";
export default {
  components: { card },
};
</script>

<style></style>
