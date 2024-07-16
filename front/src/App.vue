<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>
<template>
  <div class="container">
    <div class="section section-file">
      <img alt="LogBook logo" class="logo" src="@/assets/logbook.svg" />
    </div>
    <div class="section section-data">
      <RouterView />
    </div>
  </div>
</template>

<style scoped>
.container {
  display: block;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  height: 100vh;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto;
}

.section-file {
  padding: 44px;
}

.section-data {
  margin-top: 32px;
}

@media (max-width: 1024px) {
  .section-data {
    margin-top: 12px;
  }
}
</style>
