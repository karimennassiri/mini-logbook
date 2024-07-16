import axios from 'axios'

// Create an axios instance for the backend api
const api = axios.create({
  // We can put the base URL in a env variable and use it here to make it more clean
  baseURL: 'http://localhost/api/locations'
})

export default api
