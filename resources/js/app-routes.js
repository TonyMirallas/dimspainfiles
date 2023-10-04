import { createWebHistory, createRouter } from "vue-router";

const routes = [
   
   // TEST
   { name: 'test', path: '/technical/test', component: require('./pages/tests/testView.vue').default },

   // Technical
   { name: 'technical', path: '/technical', component: require('./pages/technical/routes/Technical.vue').default },
   { name: 'settings', path: '/technical/account/settings', component: require('./pages/technical/routes/TechnicalAccountExit.vue').default},
   { name: 'exit', path: '/technical/account/exit', component: require('./pages/technical/routes/TechnicalAccountSettings.vue').default},

   // Technical Customer

   // Technical Lead
   { name: 'customer_list', path: '/technical/:entityType/list', component: require('./pages/technical/routes/profile/TechnicalCustomerList.vue').default},
   { name: 'customer_create', path: '/technical/:entityType/create', component: require('./pages/technical/routes/profile/TechnicalCustomerCreate.vue').default},
   { name: 'customer_profile_company', path: '/technical/:entityType/profile/company/:entityId', component: require('./pages/technical/routes/profile/TechnicalCustomerProfileCompany.vue').default},
   { name: 'customer_profile_contacts', path: '/technical/:entityType/profile/contacts/:entityId', component: require('./pages/technical/routes/profile/TechnicalCustomerProfileContacts.vue').default},
   { name: 'customer_profile_tracing', path: '/technical/:entityType/profile/tracing/:entityId', component: require('./pages/technical/routes/profile/TechnicalCustomerProfileTracing.vue').default},
   { name: 'customer_profile_invoice', path: '/technical/:entityType/profile/invoice/:entityId', component: require('./pages/technical/routes/profile/TechnicalCustomerProfileInvoice.vue').default},
   
   // Technical Invoice
   { name: 'invoice_list', path: '/technical/invoice/list', component: require('./pages/technical/routes/invoice/TechnicalInvoiceList.vue').default},
   { name: 'invoice_create', path: '/technical/invoice/create', component: require('./pages/technical/routes/invoice/TechnicalInvoiceCreate.vue').default},
   { name: 'invoice_create_id', path: '/technical/invoice/create/:entityId', component: require('./pages/technical/routes/invoice/TechnicalInvoiceCreate.vue').default},

   // Technical tracing
   { name: 'tracing_list', path: '/technical/tracing/list', component: require('./pages/technical/routes/tracing/TechnicalTracingList.vue').default},
   { name: 'tracing_create', path: '/technical/tracing/create', component: require('./pages/technical/routes/tracing/TechnicalTracingCreate.vue').default},
   { name: 'tracing_create_id', path: '/technical/tracing/create/:entityId', component: require('./pages/technical/routes/tracing/TechnicalTracingCreate.vue').default},

   // Technical Product
   { name: 'products_activated', path: '/technical/products/activated', component: require('./pages/technical/routes/products/TechnicalProductsListActivated.vue').default},
   { name: 'products_all', path: '/technical/products/all', component: require('./pages/technical/routes/products/TechnicalProductsListAll.vue').default},
   
]

const router = createRouter({
   history: createWebHistory('/dim/public/'),
   routes
})


export default router