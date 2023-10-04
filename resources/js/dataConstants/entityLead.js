import * as formDefualt from '../helpers/formDefualt';

const form = {
   title1: {
      type: 'title',
      label: 'Empresa',
      size: 'padding-top: 0px;',
   },
   company_name: {
      label: 'Nombre Comercial',
      key: 'company_name',
      type: 'input',
      value: '',
      required: true,
      disabled: false,
      size: 'flex-basis:250px;',
   },
   company_legal_representative_name: {
      label: 'Nombre Fiscal',
      key: 'company_legal_representative_name',
      type: 'input',
      value: '',
      required: false,
      disabled: false,
      size: 'flex-basis:250px;',
   },
   company_tax_number: {
      label: 'DNI / CIF',
      key: 'company_tax_number',
      type: 'input',
      value: '',
      required: false,
      // len: 9,
      size: 'flex-basis:180px;',
   },
   line1: { type: 'line' },
   company_email: {
      label: 'Email',
      key: 'company_email',
      type: 'input',
      value: '',
      required: false,
      typeRule: 'email',
      size: 'flex:auto; max-width:300px;',
   },
   company_phone: {
      label: 'Telefono',
      key: 'company_phone',
      type: 'input',
      value: '',
      required: false,
      len: 9,
      size: 'flex-basis:200px;',
   },
   line2: { type: 'line' },
   company_country: {
      label: 'País',
      key: 'company_country',
      type: 'select',
      value: 'España',
      required: false,
      size: 'flex-basis:130px;',
   },
   company_province: {
      label: 'Provincia',
      key: 'company_province',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },
   company_city: {
      label: 'Ciudad',
      key: 'company_city',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:200px;',
   },
   line3: { type: 'line' },
   company_pc: {
      label: 'Codigo Postal',
      key: 'company_pc',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:120px;',
   },
   company_address: {
      label: 'Dirección',
      key: 'company_address',
      type: 'input',
      value: '',
      required: false,
      size: 'flex:auto;',
   },
   line4: { type: 'line' },
   company_acquisition: {
      label: 'Como nos conocen',
      key: 'company_acquisition',
      type: 'input',
      type: 'select',
      value: '',
      required: true,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'Google', key: 'google' },
         { label: 'Redes Sociales', key: 'rss' },
         { label: 'Youtube', key: 'youtube' },
         { label: 'Referido', key: 'referer' },
         { label: 'Feria', key: 'fair' },
         { label: 'Correo Info', key: 'email' },
      ]
   },
   company_interests: {
      label: 'Intereses',
      key: 'company_interests',
      type: 'input',
      type: 'select-multiple',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'New Genius', key: 'New Genius' },
         { label: 'New Genius Flash Point', key: 'New Genius Flash Point' },
         { label: 'Bancos de Potencia', key: 'Bancos de Potencia' },
         { label: 'Formación Race', key: 'Formación Race' },
         { label: 'Race EVO', key: 'Race EVO' },
         { label: 'New Trasdata', key: 'New Trasdata' },
         { label: 'New Trasdata Flash Point', key: 'New Trasdata Flash Point' },
         { label: 'Centralitas adicionales RAPID', key: 'Centralitas adicionales RAPID' },
         { label: 'Gas GNC', key: 'Gas GNC' },
         { label: 'Gas GLP', key: 'Gas GLP' },
         { label: 'Otros', key: 'Otros' },
      ]
   },
   company_competitors: {
      label: 'Competencia',
      key: 'company_competitors',
      type: 'input',
      type: 'select-multiple',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'Alientech', key: 'alientech' },
         { label: 'Magicmotor', key: 'magicmotor' },
         { label: 'Autotuner', key: 'Autotuner' },
         { label: 'BFlash', key: 'bFlash' },
         { label: 'CMD', key: 'CMD' },
         { label: 'Otros', key: 'Otros' },
      ]
   },
   line59: { type: 'line' },
   company_notes: {
      label: 'Observaciones',
      key: 'company_notes',
      type: 'textarea',
      value: '',
      required: false,
      size: 'flex-basis:100%;',
   },
   title_contact: {
      type: 'title',
      label: 'Persona de Contacto',
   },
   contact_name: {
      label: 'Nombre',
      key: 'contact_name',
      type: 'input',
      value: '',
      required: true,
      disabled: false,
      size: 'flex-basis:250px;',
   },
   contact_email: {
      label: 'Email',
      key: 'contact_email',
      type: 'input',
      value: '',
      required: true,
      typeRule: 'email',
      distinct: [
         {key: 'company_email', message: 'No puedes repetir el email de la empresa'},
      ],
      size: 'flex:auto; max-width:300px;',
   },
   contact_phone: {
      label: 'Teléfono',
      key: 'contact_phone',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
   },
   // line5: { type: 'line' },
   contact_position: {
      label: 'Cargo',
      key: 'contact_position',
      type: 'input',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'Comercial', key: 'Comercial' },
         { label: 'Soporte', key: 'support' },
      ]
   },
   contact_channel: {
      label: 'Canal de Contacto', // Como nos contacta || Primera contacto
      key: 'contact_channel',
      type: 'select',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'Telefono', key: 'phone' },
         { label: 'Correo', key: 'email' },
         { label: 'Presencial', key: 'face-to-face' },
      ]
   },
   contact_observations: {
      label: 'Observaciones',
      key: 'contact_observations',
      type: 'textarea',
      value: '',
      required: false,
      size: 'flex-basis:100%;',
   },
   line7: {
      type: 'line-hard',
   },
   submit_create: {
      label: 'Crear y Guardar',
      key: 'submit_create',
      type: 'submit',
   },
   submit_create_budget: {
      label: 'Crear y Presupuestar',
      key: 'submit_create_budget',
      type: 'submit',
   },
   submit_create_tracing: {
      label: 'Crear y Añadir Seguimiento',
      key: 'submit_create_tracing',
      type: 'submit',
   },
   submit_update: {
      label: 'Actualizar',
      key: 'submit-update',
      type: 'submit',
   }
}

const formContact = {
   title_contact: {
      type: 'title',
      label: 'Añadir Nuevo Contacto',
   },
   contact_name: {
      label: 'Nombre',
      key: 'contact_name',
      type: 'input',
      value: '',
      required: true,
      disabled: false,
      size: 'flex-basis:250px;',
   },
   contact_email: {
      label: 'Email',
      key: 'contact_email',
      type: 'input',
      value: '',
      required: true,
      typeRule: 'email',
      size: 'flex:auto; max-width:300px;',
   },
   contact_phone: {
      label: 'Teléfono',
      key: 'contact_phone',
      type: 'input',
      value: '',
      required: false,
      size: 'flex-basis:150px;',
   },
   contact_position: {
      label: 'Cargo',
      key: 'contact_position',
      type: 'input',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'Comercial', key: 'Comercial' },
         { label: 'Soporte', key: 'support' },
      ]
   },
   contact_channel: {
      label: 'Canal de Contacto', // Como nos contacta || Primera contacto
      key: 'contact_channel',
      type: 'select',
      value: '',
      required: false,
      size: 'flex:auto; max-width:300px;',
      options: [
         { label: 'Telefono', key: 'phone' },
         { label: 'Correo', key: 'email' },
         { label: 'Presencial', key: 'face-to-face' },
      ]
   },
   contact_observations: {
      label: 'Observaciones',
      key: 'contact_observations',
      type: 'textarea',
      value: '',
      required: false,
      size: 'flex-basis:100%;',
   },
   line7: {
      type: 'line-hard',
   },
   submit_update: {
      label: 'Crear',
      key: 'submit-update',
      type: 'submit',
   }
}

const table = [
   {label: 'Nombre', type: 'slot', slot: 'contact-company'},
   {label: 'Ciudad', field: 'city', type: 'text'},
   {label: 'Telefono', type: 'slot', slot: 'company-phone'},
   // {label: 'Pendientes', field: '', type: 'text', filter: false},
   {label: 'Creación', field: 'created_at', type: 'slot', slot: 'date-format'},
]

const tableContacts = [
   {label: 'Nombre', field: 'name', type: 'text', filter: false},
   {label: 'Email', field: 'email', type: 'text', filter: false},
   {label: 'Telefono', field: 'phone', type: 'text', filter: false},
   {label: 'Cargo', field: 'position', type: 'text', filter: false},
   {label: 'Creación', field: 'created_at', type: 'slot', slot: 'date-format', filter: false},
]

// Auto rellenar campos para desarrollo
// formDefualt.entityLeadCreateForm(form)

export default { form, formContact, table, tableContacts }




