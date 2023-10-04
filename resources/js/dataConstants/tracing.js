

const formCreate = {
   title0: {
      type: 'title',
      label: 'Fechas',
      size: 'padding-top: 0px;',
   },
   date_created: {
      label: 'Creación',
      key: 'date_created',
      type: 'datepickertime',
      value: null,
      required: false,
      size: 'flex-basis:130px;',
   },
   finished_at: {
      label: 'Seguimiento',
      key: 'finished_at',
      type: 'datepickertime',
      value: null,
      required: false,
      size: 'flex-basis:130px;',
   },
   title1: {
      type: 'title',
      label: 'Empresa y Contacto',
      // size: 'padding-top: 0px;',
   },
   company_search: {
      label: 'Buscador General',
      key: 'company_search',
      type: 'slot',
      value: '',
      required: false,
      disabled: false,
      size: 'flex:2;',
   },
   from_contact_id: {
      label: 'Contacto Acción',
      key: 'from_contact_id',
      type: 'input',
      type: 'select',
      value: '',
      required: true,
      size: 'flex:1;',
      options: []
   },
   title3: {
      type: 'title',
      label: 'Datos de la Acción',
   },
   channel: {
      label: 'Canal de Contacto',
      key: 'channel',
      type: 'input',
      type: 'select',
      value: '',
      required: true,
      size: 'flex:1;',
      options: [
         { label: 'Telefono', key: 'phone' },
         { label: 'Correo', key: 'email' },
         { label: 'Presencial', key: 'face-to-face' },
      ]
   },
   contact_id: {
      label: 'Contactar con',
      key: 'contact_id',
      type: 'input',
      type: 'select',
      value: '',
      required: true,
      size: 'flex:1;',
      options: []
   },
   objetive: {
      label: 'Objetivo de la Acción',
      key: 'objetive',
      type: 'input',
      value: '',
      required: true,
      size: 'flex:auto;',
   },
   result: {
      label: 'Resultado',
      key: 'result',
      type: 'textarea',
      value: '',
      required: false,
      disabled: true,
      size: 'flex:100%;',
   },
   description: {
      label: 'Nota',
      key: 'description',
      type: 'textarea',
      value: '',
      required: false,
      disabled: false,
      size: 'flex:100%;',
   },
   technical_id: {
      label: 'Asignar Acción',
      key: 'technical_id',
      type: 'input',
      type: 'select',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: []
   },
   line7: {
      type: 'line-hard',
   },
   submit_form_crete: {
      label: 'Crear Seguimiento',
      key: 'submit_form_crete',
      type: 'submit',
   },
   submit_form_create_redirect: {
      label: 'Crear y Ver Seguimiento',
      key: 'submit_form_create_redirect',
      type: 'submit',
   }
}

const formTaskList = {
   title1: {
      type: 'title',
      label: 'Fechas',
      // size: 'padding-top: 0px;',
   },
   slot1: {
      type: 'slot',
      key: 'slot1',
      size: 'flex:100%;',
   },
   from_contact_id: {
      label: 'Contacto Acción',
      key: 'from_contact_id',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },
   contact_id: {
      label: 'Contactar con',
      key: 'contact_id',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },
   channel: {
      label: 'Canal de Contacto',
      key: 'channel',
      type: 'input',
      type: 'select',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
      options: [
         { label: 'Telefono', key: 'phone' },
         { label: 'Correo', key: 'email' },
         { label: 'Presencial', key: 'face-to-face' },
      ]
   },
   from_user_id: {
      label: 'Realizada por',
      key: 'from_user_id',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
   },
   objetive: {
      label: 'Objetivo de la Acción',
      key: 'objetive',
      type: 'input',
      value: '',
      required: false,
      disabled: false,
      size: 'flex-basis:80%;',
   },
   state: {
      label: 'Estado',
      key: 'state',
      type: 'slot',
      value: '',
      required: false,
      disabled: false,
      size: 'flex:1;',
      options: [
         { label: 'Abierto', key: 'open' },
         { label: 'Cerrado', key: 'closed' },
      ]
   },
   result: {
      label: 'Resultado',
      key: 'result',
      type: 'textarea',
      value: '',
      required: false,
      size: 'flex-basis:100%;',
   },
   description: {
      label: 'Nota',
      key: 'description',
      type: 'textarea',
      value: '',
      required: false,
      size: 'flex-basis:100%;',
   },
}


const tableTracing = [
   { label: 'Empresa', type:"slot", slot: 'company_name' },
   { label: 'Contacto', type:"slot", slot: 'company_contact' },
   { label: 'Objetivo', type:"text", field: 'objetive' },
   { label: 'Telefono', type:"slot", slot: 'company_phone' },
   { label: 'Estado', type:"slot", slot: 'state' },
   { label: '', type:"slot", slot: 'open' },
]

export default { formCreate, formTaskList, tableTracing }

