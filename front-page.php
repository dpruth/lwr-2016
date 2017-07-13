<?php
/**
 * The template for displaying the homepage.
 *
 * This is the template that displays the front page.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package lwr
 */

get_header();

?>
<main class="site-main container-fluid" id="main">

			<?php while ( have_posts() ) : the_post(); 

				get_template_part( 'loop-templates/content', 'frontpage' ); 

					endwhile; // end of the loop. ?>

</main><!-- #main -->


<?php

 get_footer(); 
