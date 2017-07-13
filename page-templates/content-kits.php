<?php
/**
 * Template Name: Full Width Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package lwr
 */

?>
<header class="entry-header col-12 jumbotron">
	<?php the_title('<h1 class="entry-title display-3">', '</h1>'); ?>
</header>
<div class="col-md-1"></div>
<div class="col-md-3 mb-5"><!-- Left column -->
		<?php the_post_thumbnail('small'); ?>
		<?php the_content(); ?>
		
		<h4>Share Your Good Work!</h4>
		<p>Be sure to upload a picture of your kits to Facebook or Twitter</p>
		<p class="text-center"><a href="https://www.facebook.com/buildkitsofcare" target="_blank">
				<span class="fa-stack fa-lg">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
				</span>
					<span class="sr-only">Facebook</span></a>
			<a href="https://www.twitter.com/buildkitsofcare" target="_blank">
				<span class="fa-stack fa-lg">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
				</span>
				<span class="sr-only">Twitter</span></a>
		</p>
		<img class="alignnone size-medium wp-image-448" src="https://lwr.org/wp-content/uploads/pp_personal_kit-300x201.jpg" alt="" width="300" height="201" />
</div>

<div class="col-md-7"><!-- Right column -->
		<h3><?php the_field('kit-item-instructions'); ?></h3>
					
<?php // check if the repeater field has rows of data
	if( have_rows('kit-items') ):
			echo '<div class="row justify-content-center">';

 	// loop through the rows of data
    while ( have_rows('kit-items') ) : the_row();

        // display a sub field value
        $image = get_sub_field('kit_item_image');
				?>
					<div class="col-sm">
						<h4><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo $image['alt']; ?>" />
						<span class="badge badge-pill badge-primary">x<?php	the_sub_field('kit_item_quantity'); ?></span></h4>
					</div>
				<?php

    endwhile;
			echo '</div>';
	
	endif;

	/*
	 * Display Downloadable Instructions Sheet
	 */
	
	$file = get_field('instructions_sheet');
		if ( $file ) : ?>
		<p class="text-center mt-5"><a href="<?php echo esc_url($file['url']); ?>" class="button">Download Instructions <i class="fa fa-file-pdf-o"></i></a></p>
	
	<?php endif; 
	
	
	/*
	 * Display Guidelines Tabs
	 */ 
	 ?>
	
	
	<ul class="nav nav-tabs kits" role="tablist">
		<li class="nav-item h5">
			<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab"><?php the_field('kit-tab-1'); ?></a>
		</li>
		<li class="nav-item h5">
			<a class="nav-link" data-toggle="tab" href="#tab-2" role="tab"><?php the_field('kit-tab-2'); ?></a>
		</li>
		<li class="nav-item h5">
			<a class="nav-link" data-toggle="tab" href="#tab-3" role="tab"><?php the_field('kit-tab-3'); ?></a>
		</li>
		<li class="nav-item h5">
			<a class="nav-link" data-toggle="tab" href="#tab-4" role="tab"><?php the_field('kit-tab-4'); ?></a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade active show" id="tab-1" role="tabpanel">
			<?php the_field('kit-text-1'); ?>
		</div>
		<div class="tab-pane fade" id="tab-2" role="tabpanel">
			<?php the_field('kit-text-2'); ?>
		</div>
		<div class="tab-pane fade" id="tab-3" role="tabpanel">
			<?php the_field('kit-text-3'); ?>
		</div>
		<div class="tab-pane fade" id="tab-4" role="tabpanel">
			<?php the_field('kit-text-4'); ?>
		</div>
	</div>
	
	

	</div> <!-- .col-md-7 -->
	<div class="col-md-1"></div>

</div>