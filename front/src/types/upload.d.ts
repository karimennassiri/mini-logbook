import type { Location } from './locations'

/**
 * upload's type
 */
export interface UploadType {
  message: string
  imported: Array<Location>
  failed: Array<{
    locationData: Location
    errors: Array<string, Array<string>>
  }>
}
