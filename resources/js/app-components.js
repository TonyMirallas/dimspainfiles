
export default [
   
   // TEST
   { name: 'TestComponent', component: require('./pages/tests/testComponent.vue').default },

   // Globals Components
   { name: 'TablePro', component: require('./components/TablePro.vue').default },
   { name: 'SearchPro', component: require('./components/SearchPro.vue').default },
   { name: 'SelectorCountries', component: require('./components/SelectorCountries.vue').default },
   { name: 'ListappForm', component: require('./components/ListappForm.vue').default },
   { name: 'Payments', component: require('./components/Payments.vue').default },
   { name: 'LegendStatusPayments', component: require('./components/LegendStatusPayments.vue').default },
   { name: 'DatePikerNot', component: require('./components/DatePikerNot.vue').default },

   // Technical Components
   { name: 'TechnicalNavTop', component: require('./pages/technical/components/TechnicalNavTop.vue').default },

   // Technical Components
   { name: 'TechnicalApp', component: require('./pages/technical/layouts/TechnicalApp.vue').default },
   { name: 'TechnicalFormEntities', component: require('./pages/technical/components/TechnicalFormEntities.vue').default },
   { name: 'TechnicalTitleLinear', component: require('./pages/technical/components/TechnicalTitleLinear.vue').default },


   { name: 'Tester', component: require('./components/Tester.vue').default },

];
