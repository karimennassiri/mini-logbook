import './assets/main.css'

import PrimeVue from 'primevue/config'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import FileUpload from 'primevue/fileupload'
import Aura from '@primevue/themes/aura'
import ToastService from 'primevue/toastservice'
import Toast from 'primevue/toast'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import App from './App.vue'
import DataTable from 'primevue/datatable'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'
import Column from 'primevue/column'
import ColumnGroup from 'primevue/columngroup'
import Row from 'primevue/row'
import router from './router'
import EditLocation from '@/components/EditLocation.vue'
import LocationsList from '@/components/LocationsList.vue'
import CsvImport from '@/components/CsvImport.vue'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(PrimeVue, {
  theme: {
    preset: Aura,
    options: {
      darkModeSelector: 'dark'
    }
  }
})
app.use(ToastService)

app.component('FileUpload', FileUpload)
app.component('Toast', Toast)
app.component('DataTable', DataTable)
app.component('Column', Column)
app.component('ColumnGroup', ColumnGroup)
app.component('Row', Row)
app.component('InputText', InputText)
app.component('Select', Select)
app.component('Textarea', Textarea)
app.component('Button', Button)
app.component('LocationsList', LocationsList)
app.component('EditLocation', EditLocation)
app.component('CsvImport', CsvImport)

app.mount('#app')
