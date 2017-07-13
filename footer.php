<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package lwr
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'lwr_container_type' );
?>

<?php get_sidebar( 'footerfull' ); ?>

		<footer class="site-footer container-fluid" id="colophon">
		<hr />

		<section class="row justify-content-center blue text-center">
			<div class="col-12 col-md-3 col-lg-3">
				<h3 class="text-center">Give Where Needed Most</h3>
				<small><a href="/donate/where-needed-most">Learn more&hellip;</a></small>
			</div>

			<div class="col-4 col-md-3 col-lg-1">
					<form method="get" class="form">
						<input type="hidden" name="add-to-cart" value="138" />
						<input type="hidden" name="nyp" value="100" />
						<button class="btn btn-outline-secondary btn-lg" type="submit">$100</button>
					</form>
			</div>
			<div class="col-4 col-md-3 col-lg-1">
					<form method="get" class="form">
						<input type="hidden" name="add-to-cart" value="138" />
						<input type="hidden" name="nyp" value="500" />
						<button class="btn btn-outline-secondary btn-lg" type="submit">$500</button>
					</form>				
			</div>
			<div class="col-4 col-md-3 col-lg-1">
					<form method="get" class="form">
						<input type="hidden" name="add-to-cart" value="138" />
						<input type="hidden" name="nyp" value="1000" />
						<button class="btn btn-outline-secondary btn-lg" type="submit">$1,000</button>
					</form>
			</div>
			<div class="col-12 col-md-9 col-lg-6">
					<form method="get" class="form-inline">
					<div class="input-group col-8">
						<div class="input-group-addon">$</div>
						<input type="text" name="nyp" data-cip-id="nyp" class="form-control" placeholder="Other Amount">
					</div>
					<input type="hidden" name="add-to-cart" value="138">
					<button type="submit" class="col-4 btn btn-outline-secondary btn-lg">Donate Now</button>
					</form>
			</div>
			
		</section>
		<div class="row">
				<?php lwr_charity_badges(); ?>
		</div>
		
		<hr />
		
				<?php 
					$menu_args = array (
						'menu' => 'Footer Menu',
						'container' => 'nav',
						'container_class' => 'menu-footer-menu-container row justify-content-center',
					);
				wp_nav_menu( $menu_args ); ?>
		
		<hr />

				<div id="contact-signoff" class="row">
					<div class="col-md-6 align-self-center">
						<img src="<?php echo get_stylesheet_directory_uri() . '/img/lwr_logo.jpg'; ?>" alt="Lutheran World Relief" />
					</div>
					<div class="col-md-6 align-self-center">
						700 Light Street <span>|</span> Baltimore, Maryland 21230 USA<br />
						<a href="tel:18005975972">800.597.5972</a> <span>|</span> <a href="mailto:lwr@lwr.org">lwr@lwr.org</a>
					</div>
				</div>

		</section>
		
		</footer><!-- #colophon -->


</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

