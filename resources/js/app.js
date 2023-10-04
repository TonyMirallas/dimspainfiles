import { createApp } from 'vue'
// import VCalendar from 'v-calendar';
import { SetupCalendar, Calendar, DatePicker } from 'v-calendar';

import appElementPlus from './app-element-plus'
import appRoutes from './app-routes'
import appComponents from './app-components'
import appIcons from './app-icons'

// Create Apps
const app = createApp({});

// Load Components
appElementPlus.icons.forEach( ({ name, component }) => app.component(name, component) )
appComponents.forEach( ({ name, component }) => app.component(name, component) )
appIcons.forEach( ({ name, component }) => app.component(name, component) )

// Use
app.use(appElementPlus.ElementPlus, {locale: appElementPlus.locale})
app.use(appRoutes)
// app.use(VCalendar, {})

app.use(SetupCalendar, {})
// Use the components
app.component('Calendar', Calendar)
app.component('DatePicker', DatePicker)
 
app.mount('#app');

require('./bootstrap');