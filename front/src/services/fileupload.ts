import api from '@/plugins/api'
import type { UploadType } from '@/types/upload'
import type { FileUploadSelectEvent } from 'primevue/fileupload'
import { useLocationStore } from '@/stores/useLocationStore'

/**
 * Upload a file to the API for processing.
 *
 * @param {FileUploadSelectEvent} event - The file upload select event.
 * @returns {Promise<void>} A promise that resolves when the process is complete.
 */
const onSelect = async (event: FileUploadSelectEvent): Promise<void> => {
  // Instantiate the location store
  const locationStore = useLocationStore()

  try {
    // Extract the first selected file
    const file = event.files[0]

    // Prepare FormData with the file
    const formData = new FormData()
    formData.append('locations', file)

    // Send the upload request with proper headers
    const config = {
      headers: {
        'Content-Type': 'multipart/form-data',
        Accept: 'application/json'
      }
    }
    const { data } = await api.post<UploadType>('/import', formData, config)

    // Merge imported locations with existing locations in the store
    locationStore.addLocations(data.imported)

    // Process the response
    const importedNames = data.imported.map((location) => location.name)
    const failedNames = data.failed.map((location) => location.locationData.name)

    // Alert user about import results
    alert(
      `Imported locations: ${importedNames.join(', ')}\nFailed locations: ${failedNames.join(', ')}`
    )
  } catch (error) {
    // Provide more detailed error feedback
    const errorMessage = error instanceof Error ? error.message : 'An unexpected error occurred'
    alert(errorMessage)
  }
}

export default onSelect
