
 <!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- DNS prefetch -->
  <link rel=dns-prefetch href="//fonts.googleapis.com">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>LabMind - LCS</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="robots" content="noindex,nofollow" />

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <base href="BASE_URL" />

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>style.css"> <!-- Generic style (Boilerplate) -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>960.fluid.css"> <!-- 960.gs Grid System -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>main.css"> <!-- Complete Layout and main styles -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>buttons.css"> <!-- Buttons, optional -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>lists.css"> <!-- Lists, optional -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>icons.css"> <!-- Icons, optional -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>notifications.css"> <!-- Notifications, optional -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>typography.css"> <!-- Typography -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>forms.css"> <!--Forms, optional THIS NEEDS TO BE REMOVED IN ORDER TO MULTISELECT TO WORK -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>tables.css"> <!-- Tables, optional -->
   <!-- Charts, optional -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>jquery-ui-1.8.15.custom.css"> <!-- jQuery UI, optional -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>application_custom.css"> <!-- Application Specific -->
  <link rel="stylesheet" href="<?php echo CSS_PATH; ?>font-awesome.min.css"> <!-- font-awesome, optional -->

  <!-- end CSS-->
  <!-- Custom CSS, Javascripts and other head code-->
    <!-- Fonts -->
  <link href="//fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" type="text/css">
  <!-- end Fonts-->
<style type="text/css">
  @media print {
    .hidden-print {
      display: none !important;
    }
    a[href]:after { content: ""; }
    #container > #main {
		margin-left: 0px;
	}
  }


</style>
  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="<?php echo JS_PATH; ?>modernizr-2.0.6.min.js"></script>

  <!-- Top Javascripts-->
  <style>
.no-close .ui-dialog-titlebar-close {
  display: none;
}
</style>

</head>

<body id="top">
<div id="loading" style="text-align:center;display:none;"><img src="<?php echo IMG_PATH; ?>30.gif"></div>
<div id="badgetalert" style="text-align:center;display:none;">Nueva Orden Externa</div>
  <!-- Begin of #container -->
  <div id="container">
  	<!-- Begin of #header -->
    <div id="header-surround" class="hidden-print"><header id="header">

    	<!-- Lugar donde se inserta la imagen con el nombre del sistema -->
		<img src="<?php echo IMG_PATH; ?>labmin_texto.png" alt="Grape" class="logo">

		<!-- Divider between info-button and the toolbar-icons -->
		<div class="divider-header divider-vertical"></div>

		<!-- Info-Button -->
		<a href="javascript:void(0);" onclick="$('#info-dialog').dialog({ modal: true });"><span class="btn-info"></span></a>

			<!-- Modal Box Content -->
			<div id="info-dialog" title="Acerca De" style="display: none;">
				<p style="text-align: center;">LabMind V1.0</p>
				<p style="text-align: center;">LabMind Ver Date 2025-07-22</p>
				<p style="text-align: center;">LabMind V1.0</p>
			</div> <!--! end of #info-dialog -->



		<!-- Begin from Toolbox -->
		<ul class="toolbox-header">
			<!-- First entry -->
			<li>
				<a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Activar Navegación" style="position: absolute; padding: 8px; color: white; text-decoration: none;">
					<i class="icon-2x icon-reorder"></i>
				</a>
			</li> <!--! end of third entry -->
		</ul>

		<!-- Begin from Toolbox -->
		<ul class="toolbox-header" style="display: none;">
			<!-- First entry -->
			<li>
				<a rel="tooltip" title="Create a User" class="toolbox-action" href="javascript:void(0);"><span class="i-24-user-business"></span></a>
				<div class="toolbox-content">

					<!-- Box -->
					<div class="block-border">
						<div class="block-header small">
							<h1>Create a User</h1>
						</div>
						<form id="create-user-form" class="block-content form" action="" method="post">
							<div class="_100">
								<p><label for="username">Username</label><input id="username" name="username" class="required" type="text" value="" /></p>
							</div>
							<div class="_50">
								<p class="no-top-margin"><label for="firstname">Firstname</label><input id="firstname" name="firstname" class="required" type="text" value="" /></p>
							</div>
							<div class="_50">
								<p class="no-top-margin"><label for="lastname">Lastname</label><input id="lastname" name="lastname" class="required" type="text" value="" /></p>
							</div>
							<div class="clear"></div>

							<!-- Buttons with actionbar  -->
							<div class="block-actions">
								<ul class="actions-left">
									<li><a class="close-toolbox button red" id="reset" href="javascript:void(0);">Cancel</a></li>
								</ul>
								<ul class="actions-right">
									<li><input type="submit" class="button" value="Create the User"></li>
								</ul>
							</div> <!--! end of #block-actions -->
						</form>
					</div> <!--! end of box -->

				</div>
			</li> <!--! end of first entry -->

			<!-- Second entry -->
			<li>
				<a rel="tooltip" title="Write a Message" class="toolbox-action" href="javascript:void(0);"><span class="i-24-inbox-document"></span></a>
				<div class="toolbox-content">

					<!-- Box -->
					<div class="block-border">
						<div class="block-header small">
							<h1>Write a Message</h1>
						</div>
						<form id="write-message-form" class="block-content form" action="" method="post">
							<p class="inline-mini-label">
								<label for="recipient">Recipient</label>
								<input type="text" name="recipient" class="required">
							</p>
							<p class="inline-mini-label">
								<label for="subject">Subject</label>
								<input type="text" name="subject">
							</p>
							<div class="_100">
								<p class="no-top-margin"><label for="message">Message</label><textarea id="message" name="message" class="required" rows="5" cols="40"></textarea></p>
							</div>

							<div class="clear"></div>

							<!-- Buttons with actionbar  -->
							<div class="block-actions">
								<ul class="actions-left">
									<li><a class="close-toolbox button red" id="reset2" href="javascript:void(0);">Cancel</a></li>
								</ul>
								<ul class="actions-right">
									<li><input type="submit" class="button" value="Send Message"></li>
								</ul>
							</div> <!--! end of #block-actions -->
						</form>
					</div> <!--! end of box -->

				</div>
			</li> <!--! end of second entry -->

			<!-- Third entry -->
			<li>
				<a rel="tooltip" title="Create a Folder" class="toolbox-action" href="javascript:void(0);"><span class="i-24-folder-horizontal-open"></span></a>
				<div class="toolbox-content">

					<!-- Box -->
					<div class="block-border">
						<div class="block-header small">
							<h1>Create a Folder</h1>
						</div>
						<form id="create-folder-form" class="block-content form" action="" method="post">
							<p class="inline-mini-label">
								<label for="folder-name">Name</label>
								<input type="text" name="folder-name" class="required">
							</p>

							<!-- Buttons with actionbar  -->
							<div class="block-actions">
								<ul class="actions-left">
									<li><a class="close-toolbox button red" id="reset3" href="javascript:void(0);">Cancel</a></li>
								</ul>
								<ul class="actions-right">
									<li><input type="submit" class="button" value="Create Folder"></li>
								</ul>
							</div> <!--! end of #block-actions -->
						</form>
					</div> <!--! end of box -->

				</div>
			</li> <!--! end of third entry -->
		</ul>

		<!-- Begin of #user-info -->
		<div id="user-info">
			<p>
				<span class="messages">Hola <a href="javascript:void(0);">Usuario Administrador</a> de Matriz <span style="display: none"> ( <a href="javascript:void(0);"><img src="<?php echo IMG_PATH; ?>mail.png" alt="Messages"> 3 nuevos mensajes</a> ) </span></span>
				<span style="display: none"> <a href="javascript:void(0)" class="toolbox-action button">Ajustes</a></span> <a href="auth/logout" class="button red">Salir</a>
			</p>
		</div> <!--! end of #user-info -->

    </header></div> <!--! end of #header -->

    <div class="fix-shadow-bottom-height"></div>

	<!-- Begin of Sidebar -->
    <aside id="sidebar" class="hidden-print" style="overflow: hidden;">

    	<!-- Search -->
    	<div id="search-bar">
			<form id="search-form" name="search-form" action="search.php" method="post">
				<input style="display: none" type="text" id="query" name="query" value="" autocomplete="off" placeholder="Búsqueda">
			</form>
		</div> <!--! end of #search-bar -->

		<!-- Begin of #login-details -- aqui se pone el logo del sistema -->
		<section id="login-details">
    		<img class="img-left framed" src="<?php echo IMG_PATH; ?>logo_labmind.png" alt="LabMind">
    		<h3>Usuario Registrado:</h3>
    		<h2><a class="user-button" href="javascript:void(0);">admin&nbsp;<span class="arrow-link-down"></span></a></h2>
    		<ul class="dropdown-username-menu">
    			<li><a href="auth/logout">Salir</a></li>
    		</ul>

    		<div class="clearfix"></div>
  		</section> <!--! end of #login-details -->
      
		<!-- Begin of Navigation -->
		<nav id="nav">
			<ul class="menu collapsible shadow-bottom">
				
			<li class="expand">
			   <a href="javascript:void(0);" class="current"><img src="<?php echo IMG_PATH; ?>sofa.png">Recepción<span class="badge red"></span></a>
				<ul class="sub">

						<li><a href="<?php echo BASE_URL; ?>reception/work_order/insert"  >Orden de Trabajo</a></li>
						<li><a href="<?php echo BASE_URL; ?>reception/work_order/listing"  >Listado de Ordenes</a></li>
						<li><a href="<?php echo BASE_URL; ?>reception/estimate/listing" >Listado de Cotizaciones</a></li>
						<li><a href="<?php echo BASE_URL; ?>reception/cash_fund/listing">Salidas de Caja</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>lab-16.png">Laboratorio<span class="badge red"></span></a>
				<ul class="sub">

						<li><a href="<?php echo BASE_URL; ?>lab/work_order_listing"  >Ordenes de Laboratorio</a></li>
						<li><a href="<?php echo BASE_URL; ?>lab/process_areas"  >Procesos por Área</a></li>
						<li><a href="<?php echo BASE_URL; ?>lab/work_sheet"  >Hojas de Trabajo</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>steto-16.png">Médicos</a>
				<ul class="sub">

                            <li><a href="<?php echo BASE_URL; ?>medical/insert">Nuevo Médico</a></li>
                            <li><a href="<?php echo BASE_URL; ?>medical/listing">Listado de Médicos</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>user.png">Registro de Pacientes</a>
				<ul class="sub">

						<li><a href="<?php echo BASE_URL; ?>emr/listing">Listado de Pacientes</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>company-16.png">Empresas y Clientes</a>
				<ul class="sub">

                            <li><a href="<?php echo BASE_URL; ?>company/insert">Nueva Empresa o Cliente</a></li>

                            <li><a href="<?php echo BASE_URL; ?>company/listing">Listado de Empresas</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>suppliers-icon-16.png">Compras a Proveedores</a>
				<ul class="sub">

                            <li><a href="<?php echo BASE_URL; ?>suppliers/insert">Nuevo Proveedor</a></li>

                            <li><a href="<?php echo BASE_URL; ?>suppliers/listing">Listado de Proveedores</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>box-16.png">Conceptos</a>
				<ul class="sub">

                            <li><a href="<?php echo BASE_URL; ?>products/insert">Nuevo Concepto</a></li>

                            <li><a href="<?php echo BASE_URL; ?>products/listing">Listado de Conceptos</a></li>

                            <li><a href="<?php echo BASE_URL; ?>stock/insert">Nuevo Insumo</a></li>

                            <li><a href="<?php echo BASE_URL; ?>stock/listing">Listado de Insumos</a></li>

                            <li><a href="<?php echo BASE_URL; ?>products/price_list">Listado de Tarifarios</a></li>

                            <li><a href="<?php echo BASE_URL; ?>products/price_changes">Cambios de Precios</a></li>

                            <li><a href="<?php echo BASE_URL; ?>products/barcode_groups">Grupos de Etiquetas</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>application-task.png">Administración</a>
				<ul class="sub">

                            <li><a href="<?php echo BASE_URL; ?>users/admin/listing">Usuarios</a></li>

				</ul>

			</li>
			
			<li >
			   <a href="javascript:void(0);" ><img src="<?php echo IMG_PATH; ?>table.png">Reportes</a>
				<ul class="sub">

                            <li><a href="<?php echo BASE_URL; ?>reports/work_orders">Reportes de Órdenes</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/products">Reportes de Conceptos</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/company">Pacientes por Empresa</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/stock">Consumo de Insumos</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/stock_levels">Movimientos de Insumos</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/doctors">Pacientes por Doctor</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/sales">Reportes de Ventas y Cierres</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/cash_fund_out">Reportes de Salidas de Caja</a></li>

                            <li><a href="<?php echo BASE_URL; ?>reports/estimate">Reportes de Cotizaciones</a></li>

				</ul>

			</li>
			
			</ul>
		</nav>
		<!--! end of #nav -->		
		      <br/>
          	<img src="<?php echo IMG_PATH; ?>logo_lcs.png">

    </aside> <!--! end of #sidebar -->

    <!-- Begin of #main -->
    <div id="main" role="main">

    	<!-- Begin of titlebar/breadcrumbs -->
		<div id="title-bar" class="hidden-print">

							<div class="_100" id="turn-alerts" style="margin-bottom:-5px;margin-top:10px;"></div>
						<ul id="breadcrumbs" style="display: none">
				<li><a href="dashboard.html" title="Home"><span id="bc-home"></span></a></li>
				<li><a href="#" title="menu item">menu item</a></li>
				<li><a href="#" title="menu item">menu item</a></li>
				<li class="no-hover">menu item</li>
			</ul>
		</div> 
		<!--! end of #title-bar -->
		
				<div class="shadow-bottom shadow-titlebar"></div>

		<!-- Begin of #main-content -->
		<div id="main-content">
			<div class="container_12">

			<!-- Put your content here! -->
                        <!-- General Title -->
                        
			<div class="grid_12">
				<h1>Orden de Trabajo</h1>
				<p>Registro de órdenes de trabajo</p>
			</div>
			
                        <!-- Shortcuts -->
                        
    	<!-- Begin of Shortcuts -->
			
			<div class="grid_12 hidden-print">
				<div class="block-border">
					<div class="block-content">
						<ul class="shortcut-list">
							
					<li>

						<a href="reception/work_order/insert">
							 <img src="<?php echo IMG_PATH; ?>workorder-48.png">
							 Orden de Trabajo
						</a>
					</li>

					<li>

						<a href="reception/work_order/listing">
							 <img src="<?php echo IMG_PATH; ?>work_order_listing-48.png">
							 Listado de Órdenes
						</a>
					</li>

					<li>

						<a href="reception/estimate/listing">
							 <img src="<?php echo IMG_PATH; ?>cotizacion-48.png">
							 Listado de Cotizaciones
						</a>
					</li>

					<li>

						<a href="reception/cash_fund/listing">
							 <img src="<?php echo IMG_PATH; ?>cash_fund-48.png">
							 Salidas de Caja
						</a>
					</li>

					<li>

						<a href="reception/cash_fund/items">
							 <img src="<?php echo IMG_PATH; ?>cash_fund_concepts-48.png">
							 Conceptos de Salidas
						</a>
					</li>

					<li>

						<a href="reception/cash_fund/resp">
							 <img src="<?php echo IMG_PATH; ?>cash_fund_resp-48.png">
							 Responsables de Salidas
						</a>
					</li>

					<li>

						<a href="reception/cash_fund/base">
							 <img src="<?php echo IMG_PATH; ?>base_cash-48.png">
							 Caja Base
						</a>
					</li>

						</ul>
						<div class="clear"></div>
					</div>
				</div>

			</div>
			
	<!--! end of Shortcuts -->		
		                        <br><br>
                        <!-- General Screen Alert Msg -->
							<div id="alert_messages" class="grid_12">
															</div>
                        <!-- General Content display-->
                        <div class='grid_12'></div>    
  	<script defer src="<?php echo JS_PATH; ?>query.dataTables-1.9.4.min.js"></script> <!-- Tables -->
  	<script defer src="<?php echo JS_PATH; ?>dataTables.SetFilteringDelay.min.js"></script> <!-- Delay -->
    <script defer src="<?php echo JS_PATH; ?>query.simplemodal.1.4.2.js"></script>
    <div id="dialog" title="Confirmación" style="text-align:center;display:none;"><br>Seguro que desea borrar la Orden de Trabajo</div> 
    <div id="container-internal-folio"></div> 
    <div id="container-work-order-log"></div>
    <div id="container-qr-signature"></div>
        <div class="grid_12">
                <div class="block-border">
                        <div class="block-header">
                                <h1>Listado de Ordenes de Trabajo</h1> 
                                <span></span>
                                                        </div>

                        <div class="block-content">

                                <table id="table-list" class="table">
                                <thead>
                                    <tr>
                                        <th>Folio </th> <!-- folio -->

                                                                                                                                                                                                        <th>Fecha Orden de Trabajo</th> <!-- date_work_order -->
                                                                                
                                        
                                        <th>Paciente</th>
                                                                                <th>Doctor</th>
                                        <th>Estatus</th>
                                                                                <th>Acción</th>
                                        <th>Id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10">Cargando información</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
        </div>

                        <!-- General Bottom Screen Alert Msg -->
                        
                        




			<div class="clear height-fix"></div>

		</div>
		</div> <!--! end of #main-content -->
  </div> <!--! end of #main -->


    <footer id="footer">
        <div class="container_12">
		<div class="grid_12">
    		<div class="footer-icon align-center"><a class="top" scrollit="1" href="#top"></a></div>
		</div>
    </div></footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
  <script>window.jQuery || document.write('<script src="<?php echo JS_PATH; ?>jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo JS_PATH; ?>plugins.js"></script> <!-- lightweight wrapper for consolelog, optional -->
  <script defer src="<?php echo JS_PATH; ?>query-ui-1.8.15.custom.min.js"></script> <!-- jQuery UI -->
  <script defer src="<?php echo JS_PATH; ?>query.notifications.js"></script> <!-- Notifications  -->
  <!--<script defer src="<?php echo JS_PATH; ?>mylibs/jquery.uniform.min.js"></script> Uniform (Look & Feel from forms) removed for cart-->
  <script defer src="<?php echo JS_PATH; ?>jquery.validate.js"></script> <!-- Validation from forms -->
  <script defer src="<?php echo JS_PATH; ?>query.tipsy.js"></script> <!-- Tooltips -->
  <script defer src="<?php echo JS_PATH; ?>excanvas.js"></script> <!-- Charts -->
  <script defer src="<?php echo JS_PATH; ?>query.visualize.js"></script> <!-- Charts -->
  <script defer src="<?php echo JS_PATH; ?>query.slidernav.min.js"></script> <!-- Contact List -->
  <script defer src="<?php echo JS_PATH; ?>common.js"></script> <!-- Generic functions -->
  <script defer src="<?php echo JS_PATH; ?>script.js"></script> <!-- Generic scripts -->
  	<script type="text/javascript" src="<?php echo JS_PATH; ?>breakpoints.js"></script>
	<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.slimscroll.js"></script>
	<script type="text/javascript" src="<?php echo JS_PATH; ?>app.js"></script>

  <!-- Bottom Javascripts-->
  
	<script type="text/javascript">
		/*
		 * Confirmation Dialog
		 */

		$("body").delegate(".deleteClick","click",function(e) {
		    e.preventDefault();
		    var targetUrl = $(this).attr("href");

		    $("#dialog").dialog({
		      buttons : {
			"Confirmar" : function() {

			  $("#dialog").dialog("close");
			  

    $.ajax({
        type: 'POST',
        url: targetUrl,
        data: {  },
        beforeSend:function(){
          // this is where we activate a loading image
          $('#cargador').css('visibility','visible');
        },
        success:function(data){
          // successful request; do something with the data
            $('#cargador').css('visibility','hidden');

            $.jGrowl(data.result_msg, { theme: data.status });

            if( data.status == 'success') {

                $(e.target).closest('tr').children('td').css('background-color','#C34627').delay(500).fadeOut(500);
    
            }

        },
        error:function(){}
      });




			  //$(e.target).closest("tr").children("td").css("background-color","#C34627").delay(500).fadeOut(500);

			  //console.log($(e.target).closest("tr"));
			},
			"Cancelar" : function() {
			  $(this).dialog("close");
			}
		      }
		    });

		    $("#dialog").dialog("open");
		});
	</script>

    

		<script type="text/javascript">
                    /*
                     * Edit modal script to load form for editing
		     *
                     * Delegate the modal of the update form and shows it as a modal
                     */
                    $("body").delegate(".internal_folio","click",function(e) {
                        e.preventDefault();
                        var targetUrl = $(this).attr("href");
                            $("#container-internal-folio").load(targetUrl);
                            $("#container-internal-folio").modal({
                                opacity:50,
                                position: ["30%","30%"],
                                overlayCss: {backgroundColor:"#666666"}
                                
                            });
                            //$("#bank-account-form :input[type='text']:first").focus();
                            //$("#account_number").focus();
                            //$("#account_number").focus($.fn.setFocus);
                    });

                    $("body").delegate("#bank_acc_submit","click",function(e) {
                       //$("#bank-account-form").validate();

                         /*
                          * Ajax form post
                          */

                         var bankInsertForm = $("#bank-account-form").validate({

                             submitHandler: function(form) {
                                // some other code
                                // maybe disabling submit button
                                // then:
				

                                 $.ajax({
                                   type: 'POST',
                                   url: $(form).attr('action'),
                                   data: $(form).serialize(),
                                   beforeSend:function(){
                                     // this is where we append a loading image
                                     $('#ajax-panel').html('<div class="loading"><img src="<?php echo IMG_PATH; ?>circle.gif" alt="Cargando..." /></div>');
                                   },
                                   success:function(data){
                                     // successful request; do something with the data

                                     $(data).find('item').each(function(i){
                                       $('#ajax-panel').append('<h4>' + $(this).find('title').text() + '</h4><p>' + $(this).find('link').text() + '</p>');
                                     });
                                     if(typeof $.fn.dataTableExt.oApi.fnReloadAjax == 'function') {
		                                 window.dBankAccounts.fnReloadAjax();
		                             }
                                     //alert("Response:");
									 
                                   },
                                   error:function(){
                                     // failed request; give feedback to user

                                     $('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                                     return false;

                                     return false;
                                   }
                                 });
                                 //Close the modal window
                                 //Refresh the corresponding data table
                                 //dBankAccounts.fnClearTable(0);
                                 //dBankAccounts.fnDraw();
                                 $.jGrowl("Registro Agregado", { theme: 'success' });
                                 parent.$.modal.close();
                                 //return false;
                             }
                         });
                         $("#bank_acc_reset").click(function() { bankInsertForm.resetForm(); parent.$.modal.close(); $.jGrowl("No se agregaron datos", { theme: 'error' }); });

                        //dBankAccounts.fnClearTable(0);
                        //dBankAccounts.fnDraw();

                    });

                    $("body").delegate("#bank_acc_reset","click",function(e) {
                        $("#load_bank_acc_form").resetForm(); parent.$.modal.close(); $.jGrowl("No se modificaron datos", { theme: 'error' });
                    });

		</script>


		<script type="text/javascript">
                    /*
                     * Edit modal script to load form for editing
		     *
                     * Delegate the modal of the update form and shows it as a modal
                     */
                    $("body").delegate(".signature_qr","click",function(e) {
                        e.preventDefault();
                        var targetUrl = $(this).attr("href");
                            $("#container-qr-signature").load(targetUrl);
                            $("#container-qr-signature").modal({
                                opacity:50,
                                position: ["30%","30%"],
                                overlayCss: {backgroundColor:"#666666"}
                                
                            });
                            //$("#bank-account-form :input[type='text']:first").focus();
                            //$("#account_number").focus();
                            //$("#account_number").focus($.fn.setFocus);
                    });

                    $("body").delegate("#bank_acc_submit","click",function(e) {
                       //$("#bank-account-form").validate();

                         /*
                          * Ajax form post
                          */

                         var bankInsertForm = $("#bank-account-form").validate({

                             submitHandler: function(form) {
                                // some other code
                                // maybe disabling submit button
                                // then:
				

                                 $.ajax({
                                   type: 'POST',
                                   url: $(form).attr('action'),
                                   data: $(form).serialize(),
                                   beforeSend:function(){
                                     // this is where we append a loading image
                                     $('#ajax-panel').html('<div class="loading"><img src="<?php echo IMG_PATH; ?>circle.gif" alt="Cargando..." /></div>');
                                   },
                                   success:function(data){
                                     // successful request; do something with the data

                                     $(data).find('item').each(function(i){
                                       $('#ajax-panel').append('<h4>' + $(this).find('title').text() + '</h4><p>' + $(this).find('link').text() + '</p>');
                                     });
                                     if(typeof $.fn.dataTableExt.oApi.fnReloadAjax == 'function') {
		                                 window.dBankAccounts.fnReloadAjax();
		                             }
                                     //alert("Response:");
									 
                                   },
                                   error:function(){
                                     // failed request; give feedback to user

                                     $('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                                     return false;

                                     return false;
                                   }
                                 });
                                 //Close the modal window
                                 //Refresh the corresponding data table
                                 //dBankAccounts.fnClearTable(0);
                                 //dBankAccounts.fnDraw();
                                 $.jGrowl("Registro Agregado", { theme: 'success' });
                                 parent.$.modal.close();
                                 //return false;
                             }
                         });
                         $("#bank_acc_reset").click(function() { bankInsertForm.resetForm(); parent.$.modal.close(); $.jGrowl("No se agregaron datos", { theme: 'error' }); });

                        //dBankAccounts.fnClearTable(0);
                        //dBankAccounts.fnDraw();

                    });

                    $("body").delegate("#bank_acc_reset","click",function(e) {
                        $("#load_bank_acc_form").resetForm(); parent.$.modal.close(); $.jGrowl("No se modificaron datos", { theme: 'error' });
                    });

		</script>


<script type="text/javascript" charset="utf-8">
	$("#submit_btn, #btn_submit").click(function(e){
	// $("#submit_btn, #btn_submit").closest("form").submit(function(e){
		$("#loading").css("display","");
		$("#loading").dialog("open");
		e.preventDefault();
		button = $(this);
		button.attr("disabled", "disabled");
		button.closest("form").submit();
		setTimeout(function(){
			button.removeAttr("disabled");
			$("#loading").dialog("close");
		},6000);
	});

	$(document).delegate(":input:not(textarea):not([type=submit])","keypress",function(e) {
		return e.keyCode != 13;
	});
</script>

<script type="text/javascript" charset="utf-8"> 
    $(document).ready(function(){
        $("#boton_dbug").click(function(){
            $.post("reception/work_order/listing", {dbug: "True"})
            window.location.replace("auth/login");
	});
	
	$("#loading").dialog({
		resizable: false,
		draggable: true,
		autoOpen: false,
		modal: true,
		height: 60,
		maxWidth: 180,
		closeOnEscape: true,
		title: "Procesando...",
		closeText: "hide",
		dialogClass: "no-close"
	  });

});


</script>

  <script type="text/javascript">
	$().ready(function() {
		"use strict";

		App.init();
        
		var v = $("#create-user-form").validate();
		jQuery("#reset").click(function() { v.resetForm(); $.jGrowl("User was not created!", { theme: 'error' }); });

		var v2 = $("#write-message-form").validate();
		jQuery("#reset2").click(function() { v2.resetForm(); $.jGrowl("Message was not sent.", { theme: 'error' }); });

		var v3 = $("#create-folder-form").validate();
		jQuery("#reset3").click(function() { v3.resetForm(); $.jGrowl("Folder was not created!", { theme: 'error' }); });

		var v4 = $("#create-title-form").validate();


		$("#modal").click(function(e) {
                  $("#"+$(e.target).attr("modal")).modal({
                    opacity:50,
                    overlayCss: {backgroundColor:"#666666"}
                    });
                });


		/*
		 * Charts
		 */
		$('#graph-data').visualize({type: 'line', height: 250}).appendTo('#tab-line').trigger('visualizeRefresh');
		$('#graph-data').visualize({type: 'area', height: 250}).appendTo('#tab-area').trigger('visualizeRefresh');
		$('#graph-data').visualize({type: 'pie', height: 250}).appendTo('#tab-pie').trigger('visualizeRefresh');
		$('#graph-data').visualize({type: 'bar', height: 250}).appendTo('#tab-bar').trigger('visualizeRefresh');

		/*
		 * Tabs
		 */
		$("#specify-a-unique-tab-name").createTabs();
		$("#tab-graph").createTabs();

		/*
		 * Contact List
		 */
		$('#slider').sliderNav();


                //## js_docready functions
                
				$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
				{
					// DataTables 1.10 compatibility - if 1.10 then versionCheck exists.
					// 1.10s API has ajax reloading built in, so we use those abilities
					// directly.
					if ( $.fn.dataTable.versionCheck ) {
						var api = new $.fn.dataTable.Api( oSettings );
				 
						if ( sNewSource ) {
							api.ajax.url( sNewSource ).load( fnCallback, !bStandingRedraw );
						}
						else {
							api.ajax.reload( fnCallback, !bStandingRedraw );
						}
						return;
					}
				 
					if ( sNewSource !== undefined && sNewSource !== null ) {
						oSettings.sAjaxSource = sNewSource;
					}
				 
					// Server-side processing should just call fnDraw
					if ( oSettings.oFeatures.bServerSide ) {
						this.fnDraw();
						return;
					}
				 
					this.oApi._fnProcessingDisplay( oSettings, true );
					var that = this;
					var iStart = oSettings._iDisplayStart;
					var aData = [];
				 
					this.oApi._fnServerParams( oSettings, aData );
				 
					oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
						/* Clear the old information from the table */
						that.oApi._fnClearTable( oSettings );
				 
						/* Got the data - add it to the table */
						var aData =  (oSettings.sAjaxDataProp !== '') ?
							that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
				 
						for ( var i=0 ; i<aData.length ; i++ )
						{
							that.oApi._fnAddData( oSettings, aData[i] );
						}
						 
						oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
				 
						that.fnDraw();
				 
						if ( bStandingRedraw === true )
						{
							oSettings._iDisplayStart = iStart;
							that.oApi._fnCalculateEnd( oSettings );
							that.fnDraw( false );
						}
				 
						that.oApi._fnProcessingDisplay( oSettings, false );
				 
						/* Callback user function - for event handlers etc */
						if ( typeof fnCallback == 'function' && fnCallback !== null )
						{
							fnCallback( oSettings );
						}
					}, oSettings );
				};
		
		/*
		 * DataTables
		 */
		//$('#table-accounts').dataTable();


		window.dTables = $('#table-list').dataTable({
		    "bProcessing": true,
		    "bServerSide": true,
		    "sAjaxSource": "reception/work_order/ajx_work_orders_list",
		    "sServerMethod": "POST",
		    "sPaginationType": "full_numbers",
		    "bJQueryUI": false,
		    "sDom": '<"top"lf<"clear">>rt<"block-actions"ip>',
		    "aaSorting": [[6,"desc"]],// Columna 4 con sort DESC
			"bAutoWidth": false,
		    "oLanguage": {
			"sProcessing":   "Procesando...",
			//"sLengthMenu":   "Mostrar _MENU_ registros",
			"sLengthMenu": 'Display <select class="data_table_list">'+
			             '<option value="10">10</option>'+
			             '<option value="20">20</option>'+
			             '<option value="30">30</option>'+
			             '<option value="40">40</option>'+
			             '<option value="50">50</option>'+
			             '<option value="-1">All</option>'+
			             '</select> records',
			"sZeroRecords":  "No se encontraron resultados",
			"sInfo":         " _START_ hasta _END_ de _TOTAL_ registros",
			"sInfoEmpty":    "0 hasta 0 de 0 registros",
			"sInfoFiltered": "(_MAX_ registros en total)",
			"sInfoPostFix":  "",
			"sSearch":       "Buscar:",
			"sUrl":          "",
			"oPaginate": {
			    "sFirst":    "Primero",
			    "sPrevious": "Anterior",
			    "sNext":     "Siguiente",
			    "sLast":     "Último"
			}
		    },
		    "aoColumns": [
			{ "sClass": "row_table_center"},{ "sClass": "row_table_center"},{ "sClass": "row_table_center"},{ "sClass": "row_table_center"},{ "sClass": "row_table_center"},{ "sClass": "row_table_center", "bSearchable": false, "bSortable": false },{ "bVisible": false, "bSearchable": false }
			],
			
		}).fnSetFilteringDelay(2000);

		/*
		 * Confirmation Dialog
		 */
		$("#dialog").dialog({
		  autoOpen: false,
		  modal: true
		});
		
	});
  </script>
  <!-- end scripts-->

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>
