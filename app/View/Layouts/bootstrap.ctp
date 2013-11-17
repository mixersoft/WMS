<!DOCTYPE html>
<!-- see: paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]>      <html class="no-js ie6 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie7 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie8 lt-ie9"> <![endif]-->
<!--[if IE 9]>     	   <html class="ie ie9 lte9"> <![endif]-->
<!--[if gt IE 9]><!--> 
<html class="no-js <?php if (!empty($isAndroid)) echo 'android'; ?>"> 
<!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title_for_layout; ?></title>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	    <!--[if lt IE 9]>
	      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
		<?php // for DocumentRoot !== webroot
			$this->Html->css('bootstrap-combined.no-icons.min', array('inline'=>false));
			//  $this->Html->css('bootstrap-responsive.min', array('inline'=>false));
			$this->Html->css('fonts/font-awesome-4.0.0/css/font-awesome.min.css', array('inline'=>false));
			$this->Html->css(array('fonts', 'beachfront-2', 'beachfront-less', 'wms'), array('inline'=>false));
		?>
		<!-- <link href="css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
		<link href="css/fonts/font-awesome-4.0.0/css/font-awesome.min.css" rel="stylesheet"> -->
		<!-- <link rel="stylesheet" href="css/bootstrap-responsive.min.css"> -->
		<!--  NOTE: append &123 to minify request string for 1 year max-age  --> 
		<!-- <link type="text/css" rel="stylesheet" href="http://snappi.snaphappi.com/min/b=static/css/bootstrap&amp;f=bootstrap.min.css,bootstrap-responsive.css&123" /> 
		-->
		<style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <?php
        	$this->Html->meta('favicon.ico', '/img/beachfront/bp.ico', array('type' => 'icon', 'inline' => false));
        	echo $this->fetch('meta'); 
			echo $this->fetch('script'); 

        	// compile less files as necessary, 
        	// TODO: not working for cakephp-2.4.2
   			// $this->Less->css('variables', array('no_output'=>false));		
			// $this->Less->css('mixins', array('no_output'=>false));
			// for php minify
			// $min = "/min/b=css&f=bootstrap.css,responsive.css,fonts.css,beachfront-2.css,beachfront.css,responsive-tablet.css,responsive-mobile.css,beachfront-less.css,font-awesome.css";
			// $this->Html->css($min, null, array('inline' => false));
        	echo $this->fetch('css'); 


        	echo $this->fetch('HEAD_bottom'); 
        ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

		<!--  This code taken from Cakephp layouts/default.ctp  -->
		<div id="fb-root"></div>
		<div id="container" >
			<div id="header"> 
				<!-- NAVBAR -->
				<?php $this->startIfEmpty('body_header'); 
						echo $this->element('navbar');
					    // echo $this->element('notify');
				 	$this->end(); 
				?> 
				<?php echo $this->fetch('body_header');?>
			</div>
			<div id="content">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
			<div id="footer" class='alpha black a70 ' >
				<div class="container">
					<?php echo $this->fetch('body_footer');?>
					<p>&copy; 2013 Snaphappi Inc.
						<a class="cakephp" target="_blank" href="http://www.cakephp.org/">
						</a>
					</p>
				</div>
			</div>
		</div> <!-- /container -->
		<!-- // jquery with fallback -->		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="http://snappi.snaphappi.com/static/js/bootstrap/jquery-1.10.1.min.js"><\/script>')</script>
		<!-- // twitter bootstrap -->
<!-- 		<script type="text/javascript" src="http://snappi.snaphappi.com/min/b=static/js/bootstrap&amp;f=modernizr-2.6.2-respond-1.1.0.min.js,bootstrap.min.js,font-checker.js,jquery.scrollTo-1.4.3.1-min.js"></script> -->
		<?php
			$js_bottom[] = '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js';
			$js_bottom[] = '/js/vendor/bootstrap.min.js'; 
			// $js_bottom[] = '/js/vendor/underscore.js'; 
			// $js_bottom[] = '/js/vendor/jquery.cookie.js';
			$js_bottom[] = '/js/wms.js';
			$this->prepend('javascript_Bottom', $this->Html->script($js_bottom));
			$this->start('javascript_Bottom');
				$this->Html->script('vendor/underscore.js');
				// echo $this->element('analytics/gaq');  // google analytics
			$this->end();	 

			echo $this->element('sql_dump'); 
			echo $this->fetch('javascript_Bottom');
		?>
    </body>
</html>
	