<?php
/**
 * Single post partial template.
 *
 * @package lwr
 */

?>
<article <?php post_class('col-12 px-0'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header jumbotron">

		<?php the_title( '<h1 class="entry-title display-3">', '</h1>' ); ?>

	</header><!-- .entry-header -->
	
				
	<div class="entry-content container">

		<div class="row">
			<div class="col-sm-4">
				<?php the_post_thumbnail('large'); ?>
			</div>
		
			<div class="col-sm-8">
				<h3><?php echo staff_member_title(); ?></h3>
				
				<?php 
				if ( staff_member_email() != false ) { ?>
					<p><a class="button" href="mailto:<?php echo staff_member_email(); ?>"><i class="fa fa-envelope-o"></i> Email <?php echo get_the_title(); ?></a></p><?php
				}
				if (staff_member_twitter() != false){
					?>
					<p><a class="twitter-follow-button" data-size="large" href="http://twitter.com/<?php echo staff_member_twitter(); ?>" data-show-count="false" >Follow <?php echo staff_member_twitter(); ?> on Twitter</a></p><?php
				} ?>
					
				<?php the_content(); ?>
			</div>
			
			
		<script type="application/ld+json">
			{
				"@context":	"http://schema.org",
				"@type": 	"Person",
				"name": 	"<?php the_title(); ?>",
				"jobTitle":	"<?php echo staff_member_title(); ?>",
				"image":	"<?php 
					$thumb_id = get_post_thumbnail_id();
					$thumb_url = wp_get_attachment_image_src($thumb_id, 'full');
					echo $thumb_url[0]; ?>",
				"worksFor": "Lutheran World Relief",
				"url": 		"<?php the_permalink(); ?>",
				"email": "<?php echo staff_member_email(); ?>"
			}
			</script>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'lwr' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->
		
				<?php lwr_social_media_links(); ?>

	
	<footer class="entry-footer">

		<?php lwr_entry_footer(); ?>

	</footer><!-- .entry-footer -->


</article><!-- #post-## -->

