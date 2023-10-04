
const entityTypes = {
   'lead': 'Lead',
   'sage': 'Slave',
}

const entityList = {
   'lead': 'Clientes Potenciales',
   'sage': 'Clientes Existentes',
}

const entityCreate = {
   'lead': 'Clientes Potenciales',
   // 'sage': 'Clientes existentes',
}

const entityListInvoice = {
   'lead': 'Clientes Potenciales',
   'sage': 'Clientes Existentes',
}


const routes = [
   {
      label: 'Clientes', icon: 'icon-users',
      subActive: false,
      routeNames: [
         'customer_list',
         'customer_create',
         'customer_profile_company',
         'customer_profile_contacts',
         'customer_profile_tracing',
         'customer_profile_invoice'
      ],
      sub: [
         { label: 'Nuevo cliente', name: 'customer_create',  params: {entityType: 'lead'} },
         { label: 'Clientes potenciales ', name: 'customer_list', params: {entityType: 'lead'} },
         { label: 'Clientes existentes', name: 'customer_list', params: {entityType: 'sage'} },
      ] 
   },
   {
      label: 'Presupuestos', icon: 'icon-forms',
      subActive: false,
      routeNames: [
         'invoice_list',
         'invoice_create',
         'invoice_create_id',
      ],
      sub: [
         { label: 'Ver Lista', name: 'invoice_list' },
         { label: 'Crear Nuevo', name: 'invoice_create' },
      ] 
   },
   {
      label: 'Seguimiento', icon: 'icon-task',
      subActive: false,
      routeNames: [
         'tracing_list',
         'tracing_create',
         'tracing_create_id',
      ],
      sub: [
         { label: 'Ver Lista', name: 'tracing_list' },
         { label: 'Crear Nuevo', name: 'tracing_create' },
      ] 
   },
   {
      label: 'Almacen', icon: 'icon-cube',
      routeNames: [
         'products_activated',
         'products_all',
      ],
      sub: [
         { label: 'Productos Habilitados', name: 'products_activated' },
         { label: 'Productos Totales', name: 'products_all' },
      ] 
   },
]


export default { routes, entityTypes, entityList, entityCreate, entityListInvoice }