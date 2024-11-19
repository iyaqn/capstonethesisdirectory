<template>
  <div class="dataview">
    <div class="search-filter-container wrap">
      <InputText class="search-input" placeholder="Search" />
      <DatePicker
        v-model="selectedDate"
        view="year"
        dateFormat="yy"
        placeholder="Select Year"
        class="dropdown"
        :max-date="maxDate"
      />
      <Select
        v-model="selectedCourse"
        :options="courses"
        placeholder="Select Course"
        class="dropdown"
      />
      <Select
        v-model="selectedSort"
        :options="sorting"
        placeholder="Sorting"
        class="dropdown"
      />
    </div>
    <div class="data-container wrap">
      <datacard />
      <datacard />
      <datacard />
      <datacard />
      <datacard />
      <datacard />
    </div>
  </div>
</template>

<script>
import datacard from "../card/datacard.vue";
export default {
  components: { datacard },
  data() {
    return {
      selectedCourse: null,
      selectedSort: null,
      selectedDate: null,
      courses: [
        "Computer Science",
        "Information Technology",
        "Information System",
      ],
      sorting: ["Oldest - Newest", "Newest - Oldest", "Alphabetical A - Z"],
      maxDate: new Date(new Date().getFullYear(), 11, 31),
    };
  },
};
</script>
