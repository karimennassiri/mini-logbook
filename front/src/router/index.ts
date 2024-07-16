import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'

// Defining routes
const routes: Array<RouteRecordRaw> = [
  { path: '/', name: 'LocationsList', component: () => import('../views/LocationsListView.vue') },
  {
    path: '/edit/:id',
    name: 'EditLocation',
    component: () => import('../views/EditLocationView.vue'),
    props: true
  }
]

// Defining a router
const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
