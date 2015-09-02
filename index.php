<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/estilosIndex.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<script src="jq/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/funcionesIndex.js"></script>
	<script>
        $(document).ready(insertarLocal);
        $(document).ready(blanquearMensajesErroryOK);
	</script>
	<title>Login</title>
</head>
<body  style="background-color: #F1F5F9">
<style>
    .panel-heading{
        background-color: #219A96 !important;
        color: white !important;
    }
    .cajaInterfaces{
        border: 1px solid #BCBCBC;
        border-radius: 3px;
        height: 100px;
        margin-left: 40px;
        padding-top: 15px;
    }
</style>
<div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">       
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title"><strong>Sistema de control de ventas </strong><small>EntreTelas</small></div>
                    <!-- <div style="float:right; font-size: 82%; position: relative; top:-10px"><a href="#" style="color: white;">¿Olvidaste tu contraseña?</a></div> -->
                </div>

                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="loginform" class="form-horizontal" role="form" action='php/verificarLogin.php' method="post">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="correoLocal" type="text" class="form-control" name="correoLocal" value="" placeholder="local@ejemplo.com">
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="passLocal" type="password" class="form-control" name="passLocal" placeholder="password">
                        </div>

                        <div style="margin-bottom: 15px" class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input id="checkMostrarPass" type="checkbox" name="checkMostrarPass" value="1" onclick="showPassword()"> Mostrar contraseña
                                </label>
                            </div>
                        </div>

                        <div style="margin-bottom: 10px" class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input id="login-remember" type="checkbox" name="remember" value="1" > Recordarme
                                </label>
                            </div>
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls">
                                <input  id="btn-login" type="submit" class="btn btn-custom btn-lg btn-block" value="Ingresar">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    ¿No tienes cuenta?
                                <a href="#" id="btnRegistrateAqui" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                    Registrate aqui!
                                </a>
                                </div>
                            </div>
                        </div> -->
                    </form>
                </div>
            </div>  
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title"><strong>Registro</strong></div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()" style="color: white;">Ingresar</a></div>
                </div>  
                <div class="panel-body" >
                    <form id="signupform" class="form-horizontal" method="post" role="form">
                        <div id="signupalert" style="display:none" class="alert alert-danger">
                            <p>Error:</p>
                            <span id="msgError"></span>
                        </div>
                        <div id="signupsuccess" style="display:none" class="alert alert-success">
                            <span id="msgSuccess"></span>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>
                            <div class="col-md-7">
                                <input type="text" id="inpEmailLocal" class="form-control" name="email" placeholder="local@ejemplo.com" required>
                            </div>
                        </div>
 
                        <div class="form-group">
                            <label for="firstname" class="col-md-4 control-label">Nombre local</label>
                            <div class="col-md-7">
                                <input type="text" id="inpNombreLocal" class="form-control" name="firstname" placeholder="Local" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lastname" class="col-md-4 control-label">Dirección local</label>
                            <div class="col-md-7">
                                <input type="text" id="inpDireLocal" class="form-control" name="lastname" placeholder="Avenida Picarte #111" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-7">
                                <input type="password" id="inpPassLocal" class="form-control" name="passwd" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Repite Password</label>
                            <div class="col-md-7">
                                <input type="password" id="inpRePassLocal" class="form-control" name="passwd" placeholder="Password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="icode" class="col-md-4 control-label">Teléfono contacto</label>
                            <div class="col-md-7">
                                <input type="number" id="inpFonoLocal" class="form-control" name="icode" placeholder="982431509" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-md-offset-4 col-md-7">
                                <button id="btn-signup" type="button" class="btn btn-custom btn-lg btn-block"><i class="icon-hand-right"></i> &nbsp Registrar</button>
                            </div>
                        </div>
                    </form>
                 </div>
            </div>
         </div> 
    </div>
</body>
</html>