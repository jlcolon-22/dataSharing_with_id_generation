import { createWebHistory, createRouter } from "vue-router";
import login from './components/LoginComponent.vue'

import saso_dashboard from './dashboard/SasoDashboard.vue'



import cashier_dashboard from './dashboard/CashierDashboard.vue'
import clinic_dashboard from './dashboard/ClinicDashboard.vue'
import guidance_dashboard from './dashboard/GuidanceDashboard.vue'

const routes = [
    {
        path: '/examples',
        name: 'examples',
        component: () => import('./dashboard_resources/saso/TemplateID.vue'),
        meta:{
            requiresAuth:false
        },
    },
    {
        path: '/example',
        name: 'example',
        component: () => import('./components/Example.vue'),
        meta:{
            requiresAuth:false
        },
    },
    {
        path: '/login',
        name: 'Login',
        component: login,
        meta:{
            requiresAuth:false
        },
    },

     // ####################### Saso Route ################
    {
        path: '/saso-dashboard',
        name: 'saso-Dashboard',
        component: () => import('./dashboard/Saso/Dashboard.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/saso-records',
        name: 'saso-Record',
        component: () => import('./dashboard/Saso/Records.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/saso-template',
        name: 'saso-Template',
        component: () => import('./dashboard/Saso/Template.vue'),
        meta:{
            requiresAuth:true
        },
    },
    // ####################### Cashier Route ################
    {
        path: '/cashier-dashboard',
        name: 'cashier-Dashboard',
        component: () => import('./dashboard/Cashier/Dashboard.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/cashier-records',
        name: 'cashier-Record',
        component: () => import('./dashboard/Cashier/Records.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/cashier-reports',
        name: 'cashier-Reports',
        component: () => import('./dashboard/Cashier/Reports.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/cashier-other',
        name: 'cashier-Other',
        component: () => import('./dashboard/Cashier/Other.vue'),
        meta:{
            requiresAuth:true
        },
    },

    // ###################### Clinic Routes ##############
    {
        path: '/clinic-dashboard',
        name: 'clinic-Dashboard',
        component: () => import('./dashboard/Clinic/Dashboard.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/clinic-records',
        name: 'clinic-Record',
        component: () => import('./dashboard/Clinic/Records.vue'),
        meta:{
            requiresAuth:true
        },
    },
    {
        path: '/clinic-reports',
        name: 'clinic-Reports',
        component: () => import('./dashboard/Clinic/Reports.vue'),
        meta:{
            requiresAuth:true
        },
    },
       // ###################### Guidance Routes ##############
    {
        path: '/guidance-dashboard',
        name: 'guidance-Dashboard',
        component: () => import('./dashboard/GuidanceDashboard.vue'),
        meta:{
            requiresAuth:true
        },
    },
]
// Retrieve isLoggedIn from localStorage
let auth = localStorage.getItem('isLoggedIn')
let credentials = JSON.parse(localStorage.getItem('credentials'));
let isLoggedIn = auth === "true";
// If isLoggedIn is null, set it to false
if (auth === null) {
    localStorage.setItem('isLoggedIn', false);
    isLoggedIn = false;
  }
// If credentials is null, initialize it with an empty name field
if (credentials === null) {
    const cred = { "name": "" };
    localStorage.setItem('credentials', JSON.stringify(cred));
    credentials = cred;
  }
const router = createRouter({
    history:createWebHistory(),
    routes
})
router.beforeEach(async(to, from,next)=>{
    if(to.meta.requiresAuth && auth == false){
        next({ name:"Login" })
    }else{

        next();
    }
})
export default router;
