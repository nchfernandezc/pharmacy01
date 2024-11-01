<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden</title>
</head>

<body>
    <!--HEADER-->
    <table class="div-1Header">
        <tr>
            <td class="logotd">
                <img src="{{ public_path('storage/' . $farmacia->imagen) }}" alt="logo" class="logoImg">
            </td>
            <td class="datos-grales-td">
                <table class="table_h_factura">
                    <tr>
                        <td class="titulos">
                            <p class="titulos"><strong>{{ $farmacia->nombre_razon_social }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>RIF: <span>J-{{ $farmacia->rif }}</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>DIRECCIÓN: <span>{{ $farmacia->descripcion }}</span></p>
                        </td>
                    </tr>
                    <!--
            <tr>
                <td>
                    <p>TELEFONO: <span>{{ $farmacia->telefono }}</span></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>E-MAIL: <span>{{ $farmacia->email }}</span></p>
                </td>
            </tr>
            -->
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <!--TITULO-->
    <h1 style="text-align: center; margin-top: 20px;">Detalles de Apartados</h1>
    <!--DATOS-->
    <table class="div-1Datos">
        <tr>
            <td class="receptor">
                <table class="table_receptor">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Farmacia</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Monto total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartados as $apartado)
                            <hr>
                            <tr>
                                <td style="text-align: center;">{{ $apartado->id }}</td>
                                <td style="text-align: center;">{{ $apartado->farmacia->nombre_razon_social }}</td>
                                <td style="text-align: center;">{{ $apartado->fecha }}</td>
                                <td style="text-align: center;">{{ $apartado->estado }}</td>
                                <td style="text-align: center;">{{ $apartado->detalles->sum('precio') }}</td>
                            </tr>
                        @endforeach
                    </tbody> <!-- Cierre del tbody -->
                </table> <!-- Cierre del table -->
            </td>
        </tr>
    </table>


    <!--FOOTER-->
    <footer style="text-align: center; margin-top: 20px;">
        <p>Derechos reservados &copy; {{ date('Y') }}</p>
    </footer>

</body>

</html>

<style>
    /*ESTILOS GRALES*/
    * {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    .titulos {
        font-size: 15px;
        text-transform: uppercase;
    }

    /*HEADER*/
    .div-1Header,
    .div-1Datos {
        width: 100%;
    }


    .logotd {
        width: 50%;
        height: auto;
    }

    .datos-grales-td,
    .receptor {
        width: 50%;
    }

    .logoImg {
        width: 150px;
        border-radius: 100px;
    }

    .table_h_factura {
        width: 100%;
        height: auto;
        background-color: #FFF;
        margin: 0px;
        padding: 0px;
    }

    .headerDatosh {
        text-align: right;
        color: #FFF;
        padding: 5px;
        background-color: rgb(24, 140, 207);
    }

    .table_h_factura tr td p {
        margin: 0px;
        padding: 2px;
        text-align: right;
        padding-right: 5px;
    }

    /*DATOS*/
    .table_receptor {
        width: 100%;
        background-color: rgba(243, 243, 243, 0.521);
        margin: 0px;
        padding: 10px;
        border-radius: 5px;
    }

    .table_receptor tr td p {
        margin: 0px;
        padding: 2px;
    }

    .tituloRec {
        color: rgb(24, 140, 207);
    }

    /*FIRMA*/
    .firma {
        border-top: 1px solid rgba(20, 20, 20, 0.5);
        text-align: center;
        width: 30%;
        margin-left: auto;
        /* Cambiado para centrar */
        margin-right: auto;
        /* Cambiado para centrar */
        margin-top: 80px;
        padding-top: 5px;
    }

    /*FOOTER*/
    footer {
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 0px;
    }
</style>
