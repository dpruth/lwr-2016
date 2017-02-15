<?php 
	$args = array(
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'post_type' => 'page',
		'post__in' => array( 55, 386, 388 ) 
	);
	$query = new WP_Query($args);
	
	if ($query->have_posts() ) :
		?>
		<div class="horizontal-list three-item-list" id="what-we-do-section">
			<h2>OUR PROGRAM PRIORITIES</h2>
		<?php
		while ($query->have_posts() ) :
			$query->the_post(); ?>
			<a href="<?php the_permalink(); ?>">
				<div class="img-limit"><?php the_post_thumbnail('medium'); ?></div>
				<h3><?php the_title(); ?></h3>
				<?php the_excerpt(); ?>
				<div class="orange-button">Read More</div>
			</a><?php
		endwhile;
		
		wp_reset_postdata(); ?>
		</div>
	<?php

	endif;
?>