<?php
/**
 * @package storefront
 */

		$post_object = get_field('contact_person');
		
		if( $post_object ) :
		
			$post = $post_object;
			setup_postdata( $post );
			
			$custom = get_post_custom($post->ID);
			$_staff_member_title = $custom["_staff_member_title"][0];
			$_staff_member_email = $custom["_staff_member_email"][0];
			$_staff_member_phone = $custom["_staff_member_phone"][0];
			$_offices = wp_get_object_terms( $post->ID, 'offices' );
			foreach( $_offices as $_office) {
			$_office_id = $_office->term_id;
			}
 ?>

		<div id="country-contact-info">
			<div>
				<strong>For more information, please contact:</strong>
				<div>
					<strong><?php the_title(); ?></strong><br />
					<?php echo esc_html( $_staff_member_title ); ?><br />
					Email: <a href="mailto:<?php echo antispambot($_staff_member_email,1); ?>"><?php echo antispambot($_staff_member_email); ?></a><?php
						if ( $_staff_member_phone != null ) {
							echo '<br />';
							echo 'Phone: <a href="tel:' . $_staff_member_phone . '">';
							echo esc_html($_staff_member_phone) . '</a>';
						} ?>
				</div>
				<div>
					<?php echo term_description( $_office_id, 'offices' ); ?>
				</div>
			</div>
		</div>
<?php endif; ?>