<template>
  <div v-if="locations && locations.length > 0" class="card data-table">
    <DataTable :value="locations" tableStyle="min-width: 50rem">
      <Column field="name" header="Name"></Column>
      <Column field="address" header="Address"></Column>
      <Column field="countryCode" header="country code"></Column>
      <Column field="status" header="Status"></Column>
      <Column field="description" header="Description"></Column>
      <Column field="phoneNumber" header="Phone number"></Column>
      <Column header="Edit">
        <template #body="slotProps">
          <i class="pi pi-pencil clickable" @click="editLocation(slotProps.data.id)"></i>
        </template>
      </Column>
    </DataTable>
  </div>
</template>

<script setup lang="ts">
import { onMounted, toRefs } from 'vue'
import { useRouter } from 'vue-router'
import { useLocationStore } from '@/stores/useLocationStore'

// Instantiate the location sotre
const locationStore = useLocationStore()

// Instantiate a router
const router = useRouter()

// Edition location routing method
const editLocation = (id: number) => {
  router.push({ name: 'EditLocation', params: { id: id } })
}

// Fetch the location once the component is mounted
onMounted(() => {
  locationStore.fetchLocations()
})

// Get the fetched locations
const { locations } = toRefs(locationStore)
</script>

<style scoped>
.data-table {
  text-align: center;
  margin-top: 24px;
  padding: 40px;
}

.clickable {
  cursor: pointer;
}
</style>
