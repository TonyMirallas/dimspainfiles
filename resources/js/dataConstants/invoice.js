

const formCreate = {
   title0: { type: 'title', label: 'Configuración', size: 'padding-top: 0px;' },
   company_search: { 
      key: 'company_search', label: 'Empresa', type: 'slot', 
      value: '', size: 'flex:2;', required: true,
   },
   contact_id: {
      key: 'contact_id', label: 'Contactos', type: 'select',
      value: '', size: 'flex:1;', options: [], required: true,
   },
   line1: { type: 'line' }, 
   payment_method: {
      key: 'payment_method', label: 'Forma de pago', type: 'select', required: true,
      value: '', size: 'flex-basis:230px;',
      options: [
         { key: 'credit_card', label: 'Tarjeta' },
         { key: 'transfer', label: 'Transferencia' },
         { key: 'paypal', label: 'Paypal' },
         { key: 'bank_draft', label: 'Giro Bancario' },
      ]
   },
   code: {
      key: 'code', label: 'Nº Presupuesto', type: 'input',
      value: '', size: 'flex-basis:230px;', disabled: true,
   },
   line2: { type: 'line' },
   date_start: {
      key: 'date_start', label: 'Fecha', type: 'datepickertime',
      value: null, size: 'flex-basis:230px;',
   },
   date_end: {
      key: 'date_end', label: 'Valido hasta', type: 'datepickertime',
      value: null, size: 'flex-basis:230px;',
   },
   title1: { type: 'title', label: 'Añadir Articulos' },
   products_search: { 
      key: 'products_search', label: 'Buscar Articulo', type: 'slot', 
      size: 'flex:1;'
   },
   products_search_add: {
      key: 'products_search_add', label: 'Añadir', type: 'submit',
      typeStyle: 'default'
   },
   products_table: { 
      key: 'products_table', label: 'Articulos añadidos', type: 'slot', 
      size: 'flex-basis:100%;'
   },
   title3: { type: 'title', label: 'Cálculo' },
   iva: {
      key: 'iva', label: '% Iva', type: 'number',
      value: 21, size: 'flex-basis:80px;', controlsPosition: 'right',
   },
   discount: {
      key: 'discount', label: 'Dto.', type: 'number',
      value: 0, size: 'flex-basis:80px;', controlsPosition: 'right',
   },
   calc_subtotal: {
      key: 'calc_subtotal', label: 'Base Imponible', type: 'number',
      value: 0, size: 'flex-basis:80px;', controls: false, disabled: true,
   },
   calc_iva: {
      key: 'calc_iva', label: 'Iva', type: 'number',
      value: 0, size: 'flex-basis:80px;', controls: false, disabled: true,
   },
   calc_total: {
      key: 'calc_total', label: 'Total', type: 'number',
      value: 0, size: 'flex-basis:80px;', controls: false, disabled: true,
   },
   observations: { 
      key: 'observations', label: 'Observaciones', type: 'textarea',
      value: '', size: 'flex-basis:100%;',
   },
   line3: { type: 'line-hard' },
   create_invoice: {
      key: 'create_invoice', label: 'Crear', labelDisabled: true, type: 'submit',
   }
}


const tableInvoiceProducts = [
   {label: 'Codigo', field: 'code',  type: 'slot', slot: 'input-code', size: "min-content"},
   {label: 'Nombre', field: 'value', type: 'slot', slot: 'input-name', size: "1fr"},
   {label: 'Precio', field: 'price', type: 'slot', slot: 'input-price', size: "min-content"},
   {label: 'Unidades', field: 'units', type: 'slot', slot: 'input-units', size: "min-content"},
   {label: 'Descuento', field: 'discount', type: 'slot', slot: 'input-discount', size: "min-content"},
   {label: 'Stock', field: 'stock', type: 'text', size: "min-content"},
   {label: 'Total', field: 'total', type: 'text', size: "min-content"},
   {type: 'slot', slot: 'btn-remove', size: "min-content"},
]

const tableList = [
   // {label: 'ID', field: 'id', type: 'text' },
   {label: 'Empresa', field: 'a', type: 'slot', slot: 'entity' },
   // {label: 'Contacto', field: 'b', type: 'slot', slot: 'contact'},
   {label: 'Fecha Creación', type: 'slot', slot: 'created_at'},
   {label: 'Válido Hasta', type: 'slot', slot: 'finished_at' },
   {label: 'Importe', field: 'total', type: 'text' },
   {label: 'Estado', field: 'state', type: 'slot', slot: 'state' },
   {label: 'PDF', type: 'slot', slot: 'pdf' },
]


export default { formCreate, tableList, tableInvoiceProducts }