

const form = [
   {
      label: 'Contacto',
      key: 'contact',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
   },{
      label: 'Cargo',
      key: 'position',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },{
      label: 'Email',
      key: 'email',
      type: 'input',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
   },{
      label: 'Teléfono',
      key: 'phone',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
   },{
      type: 'line',
   },{
      label: 'CIF',
      key: 'cif',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
   },{
      label: 'Empresa',
      key: 'company',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },{
      label: 'Datos Fiscales',
      key: 'tax_company',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:250px;',
   },{
      label: 'Nombre',
      key: 'name',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },{
      type: 'line',
   },{
      label: 'País',
      key: 'country',
      type: 'select',
      value: 28,
      required: false,
      size: 'flex-basis:130px;',
   },{
      label: 'Provincia',
      key: 'province',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:120px;',
   },{
      label: 'Ciudad',
      key: 'town',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:120px;',
   },{
      label: 'Dirección',
      key: 'address',
      type: 'input',
      value: '',
      required: false,
      size: 'flex:auto;',
   },{
      type: 'line',
   },{
      label: 'Nº de Factura',
      key: 'initial_invoice',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:120px;',
   },{
      label: 'Codigo',
      key: 'user',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:120px;',
   },{
      label: 'Créditos iniciales',
      key: 'credits',
      type: 'input',
      value: 0,
      required: false,
      size: 'flex-basis:120px;',
   },{
      label: 'Distribuidor',
      key: 'distributor_id',
      type: 'select',
      value: -1,
      required: false,
      size: '',
      options: []
   },{
      label: 'Activación',
      key: 'state',
      type: 'checkbox',
      value: 0,
      required: false,
      size: 'flex-basis:140px;',
   },{
      type: 'line',
   },{
      label: 'Tecnología Files',
      key: 'type',
      type: 'select',
      value: 'Standard',
      required: false,
      size: '',
      options: [
         { label: 'Standard', key: 'Standard' },
         {label: 'Open2', key: 'Open2' },
      ]
   },{
      label: 'Vehiculos',
      key: 'selection',
      type: 'select-multiple',
      value: [],
      required: false,
      size: 'flex:auto;',
      options: [
         { label: 'CAR', key: 'CAR' },
         { label: 'LCV', key: 'LCV' },
         { label: 'BIKE', key: 'BIKE' },
         { label: 'TRUCK', key: 'TRUCK' },
         { label: 'TRACTOR', key: 'TRACTOR' },
         { label: 'MARINE', key: 'MARINE' },
      ]
   },{
      label: 'Notas',
      key: 'description',
      type: 'textarea',
      value: '',
      required: false,
      size: 'flex-basis:100%;',
   },{
      type: 'line',
   },{
      label: 'Crear',
      key: 'submit',
      type: 'submit',
   }
];


export default { form }