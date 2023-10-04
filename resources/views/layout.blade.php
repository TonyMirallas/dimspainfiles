<!DOCTYPE html>
<html>
<head>
    <title>Presupuesto</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800;900&display=swap" rel="stylesheet">     -->
    <!-- <link href="{{asset('css/test.css')}}" rel="stylesheet"> -->
   <!--  <link href="{{ public_path('css/invoice.css') }}" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ url('/css/invoice.css') }}" /> -->
</head>
<body>
    
    <style>
        @page {
                * {
                    margin: 0!important;
                    padding: 0!important;
                    font-family:Verdana!important;
                }

                body {
                    margin: 0!important;
                    padding: 0!important;
                    font-family:Verdana!important;
                }
                
                .logo {
                    width: 100%!important;
                }
            table th {
                font-size:12px!important;
                background: #ddd!important;
            }
            }
            * {font-family:Verdana!important;}
            body {margin:0!important; padding:0!important;font-family:Verdana!important;}
            .logo {width: 100%!important;}
            .presupuesto {
                float:right!important;
                position:absolute!important;
                top: 40px!important;
                right: 280px!important;
                color: #1a1a1a!important;
                font-weight: 700!important;
                font-size:11px!important;
                background: #fff!important;
                padding:5px!important;
            }
            .datacliente, .ventainfo, .total, .observaciones {
                padding-left: 40px!important;
                padding-right: 40px!important;
                padding-top:20px!important;
            }
            .datacliente strong {
                font-size:12px!important;
            }
            .infocliente {
                font-size:12px!important;
            }
            table th {
                font-size:12px!important;
            }
            table td {
                font-size:12px!important;
            }
            .textolargo {font-size:8px!important;}
            .centrado {text-align:center!important;font-size:10px!important;font-weight: 700!important;padding-top:20px!important;}
            .textoabajo {padding:25px!important;text-align: justify!important;}
    </style>

    <div class="contenedor">
        <div class="cabeza">
            <img src="https://i.imgur.com/NN7Blty.png" class="logo">
            <div class="presupuesto">
                Dimsport Spain S.L.<br>
                Alt. de Gironella, 11-13, 08017 - Barcelona<br>
                www.dimsport.es - Telf: 932895900<br>
            </div>
        </div>
        <div class="datacliente">
            <table width="100%">
                <tr>
                    <td>
                        <div class="infocliente">
                            <strong>Cliente</strong><br>
                            {{ $customer->name }}<br>
                            {{$customer->address}}<br>
                            {{$contact->phone}} - {{$contact->email}}<br>
                        </div>
                    </td>
                    <td align="right">
                        <div class="fechacliente">
                            <strong>Presupuesto:</strong> {{$invoice->code}}<br>
                            <strong>Fecha:</strong> {{$invoice->created_at}}<br>
                            <strong>Fecha caducidad:</strong>  {{$invoice->finished_at}}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="ventainfo">
            <table class="tablaventa">
                <tr>
                    <th bgcolor="#c1c1c1" align="center">Item</th>
                    <th bgcolor="#c1c1c1" align="center">Cantidad</th>
                    <th bgcolor="#c1c1c1" align="center">Precio Ud.</th>
                    <th bgcolor="#c1c1c1" align="center">Dto (%)</th>
                    <th bgcolor="#c1c1c1" align="center">Subtotal</th>
                    <th bgcolor="#c1c1c1" align="center">Total</th>
                </tr>

                @foreach($products as $product)
                <tr class="proitem">
                    <td><span class="producto">{{ $product->name }}</span></td>
                    <td align="center">{{ $product->pivot->quantity }}</td>
                    <td align="center">{{ $product->pivot->price }}€</td>
                    <td align="center">{{ $product->pivot->discount }}</td>
                    <td align="center">{{ $product->pivot->subtotal }}€</td>
                    <td align="center">{{ number_format($product->pivot->total, 2) }}€</td>
                </tr>
                @endforeach
                
            </table>
        </div>

        <div class="total">
            <table class="tablaventa" width="100%">
                <tr>
                    @if ($invoice->discount > 0)
                        <th bgcolor="#c1c1c1" align="center">Descuento (%)</th>
                    @endif                        
                    <th bgcolor="#c1c1c1" align="center">Base IVA</th>
                    <th bgcolor="#c1c1c1" align="center">%IVA</th>
                    <th bgcolor="#c1c1c1" align="center">Cuota IVA</th>
                    <th bgcolor="#c1c1c1" align="center">Total Presupuesto</th>
                </tr>

                <tr class="proitem">
                    @if ($invoice->discount > 0)
                        <td align="center">{{ $invoice->discount }}</td>
                    @endif
                    <td align="center">{{ $invoice->subtotal }}€</td>
                    <td align="center">{{ $invoice->iva }}</td>
                    <td align="center">{{ number_format($invoice->iva/100 * $invoice->subtotal, 2) }}€</td>
                    <td align="center">{{ $invoice->total }}€</td>                    
                </tr>

            </table>
        </div>

        <div class="observaciones">
            
            <table class="tablaventa">

                <tr class="subitem">
                    <td class="obs">Observaciones: {{ $invoice->observations }}</td>
                </tr>
                <tr class="subitem">
                    <td class="obs">Forma de pago: {{ $invoice->payment_translate }}</td>
                </tr>

            </table>
        </div>

        <div class="textoabajo">
            <div class="centrado">Inscrita en el Registro Mercantil de Barcelona, Tomo 35.593, Folio 182, Hoja B-273424, Inscripción 1ª</div>
            <div class="textolargo">
                Las preparaciones mecánicas, electrónicas u optimizaciones de software han sido realizadas por expreso deseo del cliente y siguiendo sus indicaciones. Los vehículos que hayan recibido una Reforma de Importancia Generalizada deben homologar la misma. Siendo esta responsabilidad del propietario de los mismos. Esta reparación y/o venta queda garantizada según la Ley 23/03 y el Decreto 298/93 de la Generalitat de Catalunya, excepto su material de desgaste, el cual lo está, por su naturaleza según el kilometraje señalado por el fabricante. Las piezas sustituidas deben recogerse por parte del Cliente en el momento de retirar su vehículo, en caso de no hacerlo, no tendrá derecho a la reclamación de las mismas. Todos nuestros esfuerzos están destinados a garantizar la durabilidad de su motor. DIMSPORT obtiene la máxima potencia con un riesgo moderado, sis se cumplen los mantenimientos del motor, pero no se responsabiliza de los daños que pudieran ocurrir en el futuro derivados de los aumentos de potencia. De conformidad con lo establecido en la normativa vigente en Protección de Datos de Carácter Personal, le informamos de que sus datos serán incorporados al sistema de tratamiento titularidad de DIMSPORT SPAIN, SL con CIF B63132823 y domicilio social sitio en C/. ALT DE GIRONELLA, 11-13 BJS. 8017 BARCELONA, con la finalidad de poder remitirle la correspondiente factura. En cmplimiento con la normativa vigente, DIMSPORT SPAIN, SL informa que los datos serán conservados durante el periodo legalmente establecido. Con la presente cláusula queda informado de que sus datos serán comunicados en caso de ser necesario a : administraciones públicas y a todas aquellas entidades con las que sea necesaria la ocmunicación con la finalidad de cumplir con la prestación del servicio anteriormente mencionado.<br>
    El hecho de no facilitar los datos a las entidades mencionadas implica que no se pueda cumplir con la prestación de los servicios. A su vez, le informaos que puede contactar con el Delegado de Protección de Datos de DIMSPORT SPAIN, SL, dirigiéndose por escrito a la dirección de correo dpo.cliente@conversia.es o al teléfono 902877192. DIMSPORT SPAIN, SL informa que procederá a tratar los datos de manera lícita, leal, transparente, adecuada, pertinente, limitada, exacta y actualizada. Es por ello que DIMSPORT SPAIN, SL se compromete a adoptar todas las medidas razonables para que estos se supriman o rectifiquen sin dilación cuando sean inexactos. Podrá ejercer los derechos de acceso, rectificación, limitación de tratamiento supresión, portabilidad y oposición/revocación, en los términos que establece la normativa vigente en materia de protección de datos, dirigiendo su petición a la dirección postal C/. ALT DE GIRONELLA, 11-13 BJS. 08017 BARCELONA o bien a través de correo electrónico maribel@dimsport.es. Podrá dirigirse a la Autoridadd de Control competente para presentar la reclamación que considere oportuna.
            </div>
        </div>
    </div>

</body>
</html>