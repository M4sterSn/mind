<?php
// C:\xampp\htdocs\labmind\views\login.php

// Asegúrate de que las constantes BASE_URL, CSS_PATH, JS_PATH, IMG_PATH estén definidas.
// Si este archivo se accede directamente y no a través de index.php, necesitamos config y functions.
// ¡NOTA: session_start() ya debería haber sido llamado por index.php!
if (!defined('BASE_URL')) {
    require_once dirname(dirname(__DIR__)) . '/config.php';
}
// Incluir functions.php para display_session_messages()
require_once INCLUDES_PATH . 'functions.php';
?>
<!doctype html>
<html class="no-js" lang="es"> <head>
  <meta charset="utf-8">

  <link rel=dns-prefetch href="//fonts.googleapis.com">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo PROJECT_NAME; ?> - Iniciar Sesión</title>
  <meta name="description" content="Sistema de Gestión de Laboratorio Clínico LabMind">
  <meta name="author" content="LabMind Team">

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>style.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>960.fluid.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>main.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>buttons.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>lists.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>icons.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>notifications.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>typography.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>forms.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>tables.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>charts.css"> <link rel="stylesheet" href="<?php echo CSS_PATH; ?>jquery-ui-1.8.15.custom.css"> <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
  <script src="<?php echo JS_PATH; ?>modernizr-2.0.6.min.js"></script>
</head>

<body class="special-page">

  <div id="container">

    <section id="login-box">

        <div class="block-border">
            <div class="block-header">
                <h1 style="text-align: center; margin-top: 10px;">Acceso al Sistema <?php echo PROJECT_NAME; ?></h1>
            </div>
            <form id="login-form" class="block-content form" action="<?php echo BASE_URL; ?>login" method="post">
                <p class="inline-small-label">
                    <label for="username">Usuario</label>
                    <input type="text" name="identity" value="" class="required" autofocus>
                </p>
                <p class="inline-small-label">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" value="" class="required">
                </p>

                <div class="clear"></div>

                <div class="block-actions">
                    <ul class="actions-left">
                        <li><a class="button red" id="reset-login" href="javascript:void(0);">Cancelar</a></li>
                    </ul>
                    <ul class="actions-right">
                        <li><input type="submit" class="button" value="Login"></li>
                    </ul>
                </div> </form>


        </div>

    </section> </div> <script src="<?php echo JS_PATH; ?>jquery-1.6.2.min.js"></script>

  <script src="<?php echo JS_PATH; ?>plugins.js"></script> <script src="<?php echo JS_PATH; ?>jquery.uniform.min.js"></script> <script src="<?php echo JS_PATH; ?>jquery.validate.js"></script> <script src="<?php echo JS_PATH; ?>jquery.tipsy.js"></script> <script src="<?php echo JS_PATH; ?>common.js"></script> <script src="<?php echo JS_PATH; ?>script.js"></script> <script src="<?php echo JS_PATH; ?>jquery.notifications.js"></script> <script src="<?php echo JS_PATH; ?>login_scripts.js"></script>

  <?php display_session_messages(); ?>

  </body>
</html>