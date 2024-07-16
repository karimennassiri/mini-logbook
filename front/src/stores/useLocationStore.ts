import { defineStore } from 'pinia'
import api from '@/plugins/api'
import type { Location } from '@/types/locations'

// Define the state interface
interface LocationState {
  locations: Location[]
  error: string | null
}

export const useLocationStore = defineStore('location', {
  state: (): LocationState => ({
    locations: [],
    error: null
  }),
  actions: {
    async fetchLocations() {
      // If the locations are aleady loaded, return them
      if (this.locations && this.locations.length > 0) return this.locations

      try {
        // Perform the get request
        const { data } = await api.get<Location[]>('/', {
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json'
          }
        })
        // Getting the locations array
        this.locations = data
      } catch (error) {
        // Setting the error to the state
        this.error = error instanceof Error ? error.message : 'An unexpected error occurred'
        // To basic way to throw an error to the user but it is for demo purpose
        alert(this.error)
      }
    },
    async updateLocation(location: Location) {
      try {
        // Perform the put request to update a location
        const { data } = await api.put<Location>(`/${location.id}`, location, {
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json'
          }
        })
        // Update the local state
        const index = this.locations.findIndex((item) => item.id === location.id)
        if (index !== -1) {
          this.locations.splice(index, 1, data)
        }
        // An ugly alert
        alert('Location modified')
      } catch (error) {
        // Setting the error to the state
        this.error = error instanceof Error ? error.message : 'An unexpected error occurred'
        // To basic way to throw an error to the user but it is for demo purpose
        alert(this.error)
      }
    },
    addLocations(newLocations: Array<Location>) {
      this.locations = [...this.locations, ...newLocations]
    }
  },
  getters: {
    getLocationById: (state) => (id: number) => {
      return state.locations.find((location: Location) => location.id === id)
    }
  }
})
