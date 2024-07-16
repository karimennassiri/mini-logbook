<script setup lang="ts">
import onSelect from '@/services/fileupload'
</script>

<template>
  <div class="csv-import">
    <h1>The Locations import</h1>
    <h3>You can load here a CSV file with a list of locations</h3>
    <h3>The result will be displayed in the table once the data is uploaded</h3>
    <FileUpload
      mode="basic"
      name="file"
      accept=".csv"
      :maxFileSize="1000000"
      @select="onSelect"
      :multiple="false"
      chooseLabel="Browse"
    />
  </div>
</template>

<style scoped>
h1 {
  font-weight: 500;
  font-size: 2rem;
  position: relative;
  color: #ed6d1d;
}

h3 {
  font-size: 1rem;
}

.csv-import {
  text-align: center;
}

.p-fileupload-basic {
  margin-top: 40px;
}

.p-fileupload-choose-button {
  background: #ed6d1d;
}
</style>
