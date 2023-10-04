<style>

   tit { font-size: 19px; color: #0099ff; display: block;}

</style>

# Documentación de la API de facturas 


<tit>Obtener todas las facturas</tit>

Devuelve todas las facturas sin importar el estado o de quien sea.

#### Edpoint

```
GET /api/v1/get-invoices
```

#### Petición

```
{}
```

<tit>Obtener facturas por cliente</tit>

Devuelve todas las facturas de un cliente.

#### Edpoint

```
GET /api/v1/get-invoice
```

#### Petición

```
{}
```

<tit>Crear una factura</tit>

Crea una factura para un cliente.

#### Edpoint

```
POST /api/v1/post-invoice
```

#### Requisitos del controlador

```
'customer_id' => 'unique:customer,id,'.$request->customer_id,            
'lead_id' => 'unique:lead,id,'.$request->lead_id,            
'contact_id' => 'required|unique:contact,id,'.$request->contact_id,            
'state' => 'required|in:'.implode(',', $states),
'discount' => 'required|integer|between:0,100',
'payment' => 'required|in:'.implode(',', $payments),
'subtotal' => 'required|numeric|min:0',
'total' => 'required|numeric|min:0',     
'product_id' => 'required|array',   
'product_id.*' => 'required|exists:product,id',   
'product_quantity' => 'required|array',   
'product_quantity.*' => 'required|integer|min:1',               
'product_discount' => 'required|array',               
'product_discount.*' => 'required|integer|between:0,100',  
```

#### Petición Javascript

```
{
    "customer_id": "1",
    "lead_id": "1",
    "contact_id": "1",
    "state": "1",
    "discount": "1",
    "payment": "1",
    "subtotal": "1",
    "total": "1",
    "product_id": [
        "1",
        "2"
    ],
    "product_quantity": [
        "1",
        "2"
    ],
    "product_discount": [
        "1",
        "2"
    ]
}
```
