<?php 
/**
 * The template for displaying the Resilience Wheel
 *
 * @package storefront
 */
		wp_enqueue_style('wheel', get_stylesheet_directory_uri() . '/inc/WHEELSTYLE.CSS' );
		// wp_enqueue_script('wheel', get_stylesheet_directory_uri() . '/js/WHEELSCRIPT.JS', array('jquery') );

 
 get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php

			do_action( 'storefront_single_post_before' ); 
			
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">

			<?php
				/**
				* @hooked storefront_post_header - 10
				* @hooked storefront_post_meta - 20
				* @hooked storefront_post_content - 30
				*/

				remove_action( 'storefront_single_post', 'storefront_post_header', 10 );
				remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
				remove_action( 'storefront_single_post', 'storefront_post_content', 30 );

				add_action( 'storefront_single_post', 'lwr_add_breadcrumb', 3 );
				add_action( 'storefront_single_post', 'lwr_add_page_header_image', 15 );
				add_action( 'storefront_single_post', 'storefront_page_content', 28 );
				
				do_action( 'storefront_single_post' );
			?>


		<div id="wheel">
			<div id="screen">
				<div>
					<h2><div class="left-outer">SHO</div><div class="left-inner">CKS </div>& STR<div class="right-inner">ESS</div><div class="right-outer">ORS</div></h2>
				</div>
			</div>

			<div id="grey">
				<div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div>
				<div id="quality"><div class="left-outer">QUA</div><div class="left-inner">LIT</div><div>Y O</div><div class="right-inner">F L</div><div class="right-outer">IFE</div></div>
				<div id="wellbeing"><div class="left">WEL</div><div>L-BE</div><div class="right">ING</div></div>
				<div id="livelihoods"><div class="left-inner">SUST</div><div>AINA</div><div class="right-inner">BLE</div><br /><div class="left-inner">LIVE</div><div>LIH</div><div class="right-inner">OODS</div></div>
				<div id="growth"><div class="left-outer">INCL</div><div class="left-inner">USI</div><div>VE G</div><div class="right-inner">RO</div><div class="right-outer">WTH</div></div>
				<div id="foodsecurity"><div class="left-outer">FO</div><div class="left-inner">OD</div><div> SEC</div><div class="right-inner">URI</div><div class="right-outer">TY</div></div>
			</div>

			<div id="green">
				<div class="line"></div><div class="line"></div><div class="line"></div>
				<div id="absorptive"><div class="left-inner">ABS</div><div>ORP</div><div class="right-inner">TIVE</div><br /><div class="left-inner">CAP</div><div>AC</div><div class="right-inner">ITY</div></div>
				<div id="adaptive"><div class="left-inner">ADA</div><div>PTI</div><div class="right-inner">VE</div><br /><div class="left-inner">CAP</div><div>AC</div><div class="right-inner">ITY</div></div>
				<div id="transformative"><div class="left-inner">TRAN</div><div>SFORM</div><div class="right-inner">ATIVE</div><br />CAPACITY</div>
			</div>

			<div id="blue">
				<div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div>
				<div id="selforganization">SELF-<br />ORGANIZATION</div>
				<div id="learning">LEARNING</div>
				<div id="redundancy">REDUNDANCY</div>
				<div id="rapidity">RAPIDITY</div>
				<div id="scale">SCALE</div>
				<div id="flexibility">FLEXIBILITY &<br />DIVERSITY</div>
				<div id="equality">EQUALITY</div>
				<div id="robustness">ROBUSTNESS</div>
			</div>

			<div id="orange">
				<div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div><div class="line"></div>
				<div id="physical">PHYSICAL<br />CAPITAL</div>
				<div id="natural">NATURAL<br />CAPITAL</div>
				<div id="economic">ECONOMIC<br />CAPITAL</div>
				<div id="social">SOCIAL<br />CAPITAL</div>
				<div id="human">HUMAN<br />CAPITAL</div>
			</div>

			<div id="inner">
				<div id="household"><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_HOME.PNG';?>" alt="Household" /></div>
				<div id="society"><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_GROUP.PNG'; ?>" alt="Society" /></div>
				<div id="infrastructure"><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_BUILDING.PNG'; ?>" alt="Infrastructure" /></div>
				<div id="levels"><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_LEVELS.PNG'; ?>" alt="Levels of Analysis" /></div>
				<div id="individual"><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_PERSON.PNG'; ?>" alt="Individual" /></div>
			</div>

			<div id="screen-side-left"></div>
			<div id="screen-side-right"></div>

			<div class="stressor" id="market"><div>&#9668;</div><span>MARKET DOWNTURN</span></div>
			<div class="stressor" id="climate"><div>&#9668;</div><span>CLIMATE CHANGE</span></div>
			<div class="stressor" id="insecurity"><div>&#9668;</div><span>FOOD INSECURITY</span></div>
			<div class="stressor" id="disasters"><div>&#9668;</div><span>NATURAL DISASTERS</span></div>
			<div class="stressor" id="conflict"><div>&#9668;</div><span>CONFLICT</span></div>

			<div id="resilience-circle">
				<span class="rc-r">R</span><span class="rc-e1">E</span><span class="rc-s">S</span><span class="rc-i1">I</span><span class="rc-l">L</span><span class="rc-i2">I</span><span class="rc-e2">E</span><span class="rc-n">N</span><span class="rc-c">C</span><span class="rc-e3">E</span><div></div>
			</div>
		</div>

		<div id="message">
			You must have Javascript installed to use the wheel!
		</div>

		<div id="info">
			<div id="legend">
				<h2>DYNAMIC RESILIENCE LAYERS</h2>
				<div><div class="system"></div>System of Focus</div>
				<div><div class="capitals"></div>Livelihood Capitals</div>
				<div><div class="attributes"></div>Resilience Attributes</div>
				<div><div class="capacities"></div>Resilience Capacities</div>
				<div><div class="outcomes"></div>Development Outcomes</div>
			</div>

			<div id="systems">
				<p><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_PERSON_ICON.PNG'; ?>" alt="" />Individual</p>
				<p><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_HOME_ICON.PNG'; ?>" alt="" />Household</p>
				<p><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_GROUP_ICON.PNG'; ?>" alt="" />Community</p>
				<p><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_BUILDING_ICON.PNG'; ?>" alt="" />Institution</p>
				<p><img src="<?php echo get_stylesheet_directory_uri() . '/img/WHEEL_LEVELS_ICON.PNG'; ?>" alt="" />Level of Analysis</p>
			</div>

			<div>
				<div id="cc">
					<a rel="license" href="//creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="//i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br />The contents of this wheel is licensed under a <a rel="license" href="//creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.
				</div>
			</div>
		</div>

</article><!-- #post-## -->
		<?php 
			/**
			 * @hooked storefront_post_nav - 10
			 */
			do_action( 'storefront_single_post_after' );
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>