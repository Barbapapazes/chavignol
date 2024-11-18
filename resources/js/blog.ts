import { PiniaColada } from '@pinia/colada'
import { createPinia } from 'pinia'
import { createApp } from 'vue'

import Blog from './blog/Blog.vue'

const app = createApp(Blog)
app.use(createPinia())
app.use(PiniaColada)

app.mount('#app')
