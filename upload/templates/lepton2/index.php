<?php

/**
 *	@template       Lepton-Start
 *	@version        see info.php of this template
 *	@author         cms-lab
 *	@copyright		2010-2017 CMS-LAB
 *	@license        http://creativecommons.org/licenses/by/3.0/
 *	@license terms  see info.php of this template
 *	@platform       see info.php of this template
 */

// simple exit as it doesn't make sense to go on
if ( !defined( 'LEPTON_PATH' ) ) exit;


// TEMPLATE CODE STARTS BELOW
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo DEFAULT_CHARSET; ?>" />
	<title><?php page_title(); ?></title>  
	<meta name="description" content="<?php page_description(); ?>" />
	<meta name="keywords" content="<?php page_keywords(); ?>" />
	<?php get_page_headers();	?>  
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_DIR; ?>/css/template.css" media="screen,projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_DIR; ?>/css/print.css" media="print" />
</head>
<body>
<div id="site">
	<div id="head">
	<a href="<?php echo LEPTON_URL;?>/"><img class="head_img" src="<?php echo TEMPLATE_DIR;?>/img/1.jpg" width="900" height="180" alt="Head" /></a>
	</div>
	<div id="headtitle"><?php page_header(); ?></div>

	<!-- Left Column -->
	<div id="side">	
		<div id="navi1">
		<!-- Navigation linke Seite (Hauptnavigation) -->
    <?php
		show_menu2(1, SM2_ROOT, SM2_ROOT+2, SM2_TRIM|SM2_PRETTY|SM2_XHTML_STRICT); 
    ?>
		</div>
		
<!-- OPTIONAL: display frontend search -->
[[LEPTON_SearchBox]]
<!-- END frontend search -->

<!-- OPTIONAL: display frontend login -->
<div id="login">
<?php
if (FRONTEND_LOGIN == 'enabled' && VISIBILITY != 'private' 
	&& $wb->get_session('USER_ID') == '') { ?>
	<!-- login form -->
	<form name="login" id="login1" action="<?php 
		echo LOGIN_URL; ?>" method="post">
		<fieldset>
			<legend><?php echo $TEXT['LOGIN']; ?>:</legend>
			<label for="username" accesskey="1">
			<?php echo $TEXT['USERNAME']; ?>:</label>
			<input type="text" name="username" id="username" 
				style="text-transform: lowercase;" /><br />
			<label for="password" accesskey="2"><?php echo $TEXT['PASSWORD']; ?>:</label>
			<input type="password" name="password" id="password" /><br />
			<input type="submit" name="lep_login" id="lep_login" value="<?php 
			echo $MENU['LOGIN']; ?>"/><br />
	
			<!-- forgotten details link -->
			<a href="<?php echo FORGOT_URL; ?>"><?php echo $TEXT['FORGOT_DETAILS']; ?></a>

			<!-- frontend signup -->
			<?php
if (is_numeric(FRONTEND_SIGNUP) && (FRONTEND_SIGNUP != 0 )) { ?>
			<a href="<?php echo SIGNUP_URL; ?>"><?php echo $TEXT['SIGNUP']; ?></a>
			<?php } ?>
		</fieldset>
	</form>
<?php 
} elseif (FRONTEND_LOGIN == 'enabled' && is_numeric($wb->get_session('USER_ID'))) { ?>
	<!-- logout form -->
	<form name="logout" id="logout1" action="<?php echo LOGOUT_URL; ?>" method="post">
		<fieldset>
			<legend><?php echo $TEXT['LOGGED_IN']; ?>:</legend>
			<p><?php echo $TEXT['WELCOME_BACK']; ?>, <?php echo $wb->get_display_name(); ?></p>
			<input type="submit" name="lep_login" id="lep_login" value="<?php 
			echo $MENU['LOGOUT']; ?>" />
			<!-- edit user preferences -->
			<p><a href="<?php echo PREFERENCES_URL; ?>"><?php echo $MENU['PREFERENCES']; ?></a></p>
		</fieldset>
	</form>
<?php 
} ?>
</div>
<!-- END frontend login -->
	<div id="frontedit">[[editthispage]]</div>
</div>    <!-- END left column -->   

	<!-- Content -->
	
	<div id="cont">
	<?php page_content(1); ?>	
	</div>
	<br style="clear: both;" />
	<div id="foot">
	<?php 
    show_menu2(2, SM2_ROOT, SM2_ALL, SM2_TRIM|SM2_PRETTY|SM2_XHTML_STRICT);
  ?>
	</div>

<!-- Block Bottom -->
	<div id="basic">
	<div id="links"><?php page_footer(); ?></div>
	<div id="design"><a href='http://cms-lab.com'>Design by CMS-LAB</a></div>
	</div>
</div>
<?php get_page_footers(); ?>
</body>
</html>