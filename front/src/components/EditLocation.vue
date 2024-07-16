<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useLocationStore } from '@/stores/useLocationStore'
import type { Location } from '@/types/locations'

// Instantiate the location store
const locationStore = useLocationStore()

// Use router and route hooks
const router = useRouter()
const route = useRoute()

// List of location's status
const status = ref([
  { name: 'Closed', code: 'closed' },
  { name: 'Active', code: 'active' },
  { name: 'Planned', code: 'planned' }
])

// Instantiate an undefined location as reference
const location = ref<Location | undefined>(undefined)

// Fetch the given location once the component is mounted
const fetchLocation = async () => {
  try {
    // Ensure locations are loaded
    await locationStore.fetchLocations()

    // Fetch the individual location
    const fetchedLocation = locationStore.getLocationById(Number(route.params.id))
    if (!fetchedLocation) {
      throw new Error('Location not found')
    }

    location.value = fetchedLocation
  } catch (error: any) {
    // Here we can handle the error with a better way but this is just for demo purpose
    alert(`Error: ${error.message}`)
    // Getting back to the homepage
    router.push('/')
  }
}
onMounted(fetchLocation)

// Method to save the updated location
const saveLocation = () => {
  if (location.value) {
    locationStore.updateLocation(location.value)
  }
}
</script>

<template>
  <div class="edit-location-info">
    <h1>The Locations edit</h1>
    <h3>Feel free to change the data of this location, once you're done click to validate</h3>
  </div>
  <div class="card" v-if="location">
    <label for="name">Name</label>
    <InputText id="name" v-model="location.name" type="text" />
    <label for="address">Address</label>
    <InputText id="address" v-model="location.address" type="text" />
    <label for="countryCode">Country Code</label>
    <InputText id="countryCode" v-model="location.countryCode" type="text" />
    <label for="status">Status</label>
    <Select
      id="status"
      :options="status"
      v-model="location.status"
      optionLabel="name"
      optionValue="code"
      placeholder="Select a status"
      class="w-full md:w-56"
    />
    <label for="description">Description</label>
    <Textarea id="description" v-model="location.description" rows="5" cols="30" />
    <label for="phone-number">Phone number</label>
    <InputText id="phone-number" v-model="location.phoneNumber" type="text" />
    <Button label="Save" icon="pi pi-check" iconPos="right" @click="saveLocation" />
    <Button label="Home Page" icon="pi pi-arrow-left" iconPos="right" @click="router.push('/')" />
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

.edit-location-info {
  text-align: center;
}

.card {
  background-color: white;
  padding: 20px;
  margin-top: 24px;
  border-radius: 2px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.card label {
  color: black;
}
</style>
