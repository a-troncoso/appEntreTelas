<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Punto de venta EntreTelas</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
	<!-- Bootstrap Styles-->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <!-- <link href="js/morris/morris-0.4.3.min.css" rel="stylesheet" /> -->
    <!-- Custom Styles-->
    <link href="css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
    @media print {

        #contenidoImprimir{
            font-size: small;
        }
        
    }
    #tablaInfoTicket tr{
        border: hidden;
    }
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="catalogo.php" style="font-size: 1.2em"><?php echo $_SESSION['nombreVendedorLogueado'] ?></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil de usuario</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="catalogo.php"><i class="fa fa-list"></i> Cat&aacutelogo</a>
                    </li>
                    <li>
                        <a class="active-menu"  href="pedido.php"><i class="fa fa-file-text"></i> Pedido</a>
                    </li>
<!--                     <li>
                        <a href="chart.html"><i class="fa fa-bar-chart-o"></i> Etc</a>
                    </li> -->
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper" >
            <div id="page-inner">
    			<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Pedido <small>Entretelas (Ticket <?php echo $_SESSION['numTicket'] ?>)</small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <!-- CUADROS PEDORUCTOS -->
                <div id="contenedorCuadrosProductosPedidos" class="row">

                <!--<div class="col-md-3 col-sm-6 col-xs-6">
                        <a href="#" class="cuadrosProductos" style="text-decoration: none" >
                            <div class="panel panel-primary text-center no-boder bg-color-red">
                                <div class="panel-body">
                                    <img src="img/telasCatalogo/prueba1.jpg" class="img-responsive">
                                    <h3>$ 1.090</h3>
                                </div>
                                <div class="panel-footer back-footer-blue-oil" style="color: white"><strong>Blackout liso blanco</strong></div>
                            </div>
                        </a>
                    </div> -->

                </div>
                <!-- FIN CUADROS PRODUCTOS  -->
                <div id="alertNoHayProductosEnPedido" class="alert alert-info" role="alert">
                    <p><i class="fa fa-info-circle"></i> No hay productos en el pedido.</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <button id="btnImprimirPedido" class="btn btn-success btn-lg btn-block" disabled="disabled" style="display: none;"><i class="fa fa-print "></i> Imprimir</button>
                    </div>
                </div>
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
    </div>
    <!-- style="display: none" -->
    <div id="contenidoImprimir">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h4 style="font-size: small"><strong>EntreTelas</strong></h4>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="tablaInfoTicket" class="table table-condensed" style="margin-bottom: 0px;">
                <tbody id="" class=""  >
                    <tr>
                        <td style="font-size: small"><strong>Ticket</strong></td>
                        <td style="font-size: small"><strong><?php echo $_SESSION['numTicket'] ?></strong></td>
                    </tr>
                     <tr>
                        <td style="font-size: x-small"><strong>Fecha</strong></td>
                        <td id="fechaEmisionTicket" style="font-size: x-small"></td>
                    </tr>
                     <tr>
                        <td style="font-size: x-small"><strong>Hora</strong></td>
                        <td id="horaEmisionTicket" style="font-size: x-small"></td>
                    </tr>
                     <tr>
                        <td style="font-size: x-small"><strong>Vendedor</strong></td>
                        <td style="font-size: x-small"><?php echo $_SESSION['nombreVendedorLogueado'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table id="tablaPedido" class="table table-hover" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th style="font-size: small">Producto</th>
                        <th style="font-size: small">Cant.</th>
                        <th style="font-size: small">Dcto.</th>
                        <th style="font-size: small">Total</th>
                    </tr>
                </thead>
                <tbody id="cuerpoTablaPedido" class="cuerpoTablaPedido"></tbody>
           </table>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <p style="font-size: x-small; padding-top: 0px">Gracias por su compra</p>
            </div>
        </div>
    </div>

    <!-- VENTANA MODAL EDITAR PRODUCTO DEL PEDIDO -->
        <div class="modal fade" id="modalEditarProductoDelPedido" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button typ="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>EDITAR PEDIDO</h4>
                    </div>
                    <div class="modal-body">
                        <div id="alertFaltaRellenar" class="alert alert-danger" role="alert">
                            <p><strong>Error: </strong>Faltan campos por rellenar.</p>
                        </div>
                        <div class="row" >
                            <div id="cuadroProductoEnDialog" class="col-md-6 col-sm-6 col-xs-12">
                                <!-- <div class="panel panel-primary text-center no-boder bg-color-red">
                                    <div class="panel-body">
                                        <img src="img/telasCatalogo/no_photo.jpg" class="img-responsive">
                                        <h3>$ 1.090</h3>
                                    </div>
                                    <div class="panel-footer back-footer-blue-oil" style="color: white"><strong>Blackout liso blanco</strong></div>
                                </div> -->
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <form action="" class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="">Código</label>
                                        </div>
                                        <div class="col-xs-7">
                                            <input id="inpCodProducto" class="form-control" type="number" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="">Cantidad</label>
                                        </div>
                                        <div class="col-xs-7">
                                            <input id="inpCantidad" class="form-control" type="number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="">Descuento (%)</label>
                                        </div>
                                        <div class="col-xs-7">
                                            <input id="inpDescuento" class="form-control" type="number" value="0" min="0" max="100">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="">Total</label>
                                        </div>
                                        <div class="col-xs-7">
                                            <input id="inpTotal" class="form-control" type="number" disabled="disabled">
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnEliminarProductoDelPedido" class="btn btn-danger">Eliminar</button>
                        <button id="btnModificarProductoDelPedido" class="btn btn-warning">Modificar</button>
                        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- FIN VENTANA MODAL -->

    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <script src="jq/jquery.min.js"></script>
    <!-- Bootstrap Js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="js/morris/raphael-2.1.0.min.js"></script>
    <script src="js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="js/custom-scripts.js"></script>
    <!-- DE ALVARO -->
    <script src="js/funcionesPedido.js"></script>
    <!-- PRINT AREA PLUGIN DE JQUERY -->
    <script src="jq/jquery.PrintArea.js"></script>
</body>
</html>
