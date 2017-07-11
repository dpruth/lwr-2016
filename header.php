<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package lwr
 */

$container = get_theme_mod( 'lwr_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="icon" href="<?php echo esc_url( home_url() . '/wp-content/uploads/FAVICON.ico'); ?>" />


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
			<div id="fb-root"></div>
			<script>
          window.fbAsyncInit = function() {
						FB.init({
							appId      : '163989920344226',
							xfbml      : true,
							version    : 'v2.6'
						});
					};
					(function(d, s, id){
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) {return;}
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_US/sdk.js";
						fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
			</script>

<div class="hfeed site" id="page">

	<header id="masthead" class="container-fluid">

		<div id="top-colors" class="row">
			<div id="top-colors-green" class="col-md-3"></div>
			<div id="top-colors-teal" class="col-md-3"></div>
			<div id="top-colors-blue" class="col-md-3"></div>
			<div id="top-colors-kelly" class="col-md-3"></div>
		</div>
	
	<div class="row">
		<div class="site-branding col-sm-5 offset-sm-1">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="logo" rel="home"><span class="text-hide"><?php echo get_bloginfo('name') . ' | ' . get_bloginfo('description'); ?></span></a></h1>
		</div><!-- .site-branding -->
		<section class="masthead-right col-sm-6">
		<div class="row">
		<div id="donate-button" class="col-sm-8 col-md-3 btn">
			<div>
				<a href="/donate/where-needed-most" class="orange">Donate Now</a>
				<form method="get">
					<input type="text" name="nyp" data-cip-id="nyp" /><br />
					Enter Amount
					<input type="hidden" name="add-to-cart" value="138" /><br />
					<button type="submit" class="btn btn-outline-secondary">Donate Now!</button>
				</form>
			</div>
		</div>
		<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-navigation', 'menu_class' => 'nav', 'container' => 'nav', 'container_class' => 'secondary-navigation col-md-9' ) ); ?>
		</div>
		<div class="row">
		<div class="site-search col-sm-8 col-md-6">
			<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
		</div>
		
		<div id="social-media" class="col-md-6">
			<a href="http://www.facebook.com/LuthWorldRelief" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span><span class="sr-only">Follow us on Facebook</span></a>
			<a href="http://www.twitter.com/LuthWorldRelief" target="_blank" ><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span><span class="sr-only">Follow us on Twitter</span></a>
			<a href="//www.youtube.com/user/LutheranWorldRelief" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-youtube fa-stack-1x fa-inverse"></i></span><span class="sr-only">Watch our YouTube Videos</span></a>
		</div>
		</div>
		</section>
	</div>
	</header>
	<!-- ******************* The Navbar Area ******************* -->
	<div class="wrapper-fluid wrapper-navbar" id="wrapper-navbar">


		<a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content',
		'lwr' ); ?></a>

		<nav id="main-nav" class="navbar navbar-toggleable-md  navbar-inverse bg-inverse">

		 <?php if ( 'container' == $container ) : ?>
		<!--	<div class="container"> -->
		<?php endif; ?>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- The WordPress Menu goes here -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'collapse navbar-collapse justify-content-center',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'walker'          => new WP_Bootstrap_Navwalker(),
					)
				); ?>
			<?php if ( 'container' == $container ) : ?>
			<!-- </div> --> <!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- .wrapper-navbar end -->
			<?php do_action('lwr_emergency_banner');
