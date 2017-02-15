<?php
/**
 * @package lwr
 */

	/*****************************************************
			Full Width Shortcode
 	 *****************************************************/

	/* Open Div */
	add_shortcode('start-full-width', 'be_div_shortcode');
	function be_div_shortcode() {
		$return = '</div><div class="full-width">';
		return $return;
	}

	/* Close Div */
	add_shortcode('end-full-width', 'be_end_div_shortcode');
	function be_end_div_shortcode() {
		return '</div><div class="entry-content">';
	}


	/*********************************************
		PROJECT MAP SHORTCODE
	**********************************************/
	
	function add_project_map_to_page() {
				ob_start();
				get_template_part( 'inc/custom', 'project-locations' );
				$ret = ob_get_contents();
				ob_end_clean();
				return $ret;
	}
	add_shortcode('project-map', 'add_project_map_to_page' );



	/********************************************
		Efficiency Ratio Shortcode
	*********************************************/
	function add_efficiency_ratio( $atts ) {
			$a = shortcode_atts( array(
				'program' => 85,
				'fundraising' => 8,
				'm-g' => 7,
			), $atts );
			
			ob_start();
			?>
			<h2>LWR&rsquo;s Efficiency: <?php echo $a['program']; ?>%*</h2>
			<small>*Program Efficiency Ratio = (Total Program Expenses) / (Total Expenses)</small>
			<figure id="efficiency">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="chart" viewBox="0 0 100 30" preserveAspectRatio="none" >	
						<rect width="<?php echo $a['program']; ?>" height="30" class="program" ></rect>
						<rect width="<?php echo $a['fundraising']; ?>" height="30" x="<?php echo $a['program'] ?>" class="fundraising" ></rect>
						<rect width="<?php echo $a['m-g']; ?>" height="30" x="<?php 
							$x_width = $a['program'] + $a['fundraising'];
							echo $x_width; ?>" class="m-g" ></rect>
					</svg>
					<dl>
						<dt>Program Work - <span class="program"><?php echo $a['program']; ?>%</span></dt>
						<dt>Fundraising -  <span class="fundraising"><?php echo $a['fundraising']; ?>%</span></dt>
						<dt>General/Admin - <span class="m-g"><?php echo $a['m-g']; ?>%</span></dt>
					</dl>
			</figure>
		<?php 
			return ob_get_clean();
	}
	add_shortcode('efficiency-ratio', 'add_efficiency_ratio' );
	
	/**************************************
		Donate Now Shortcode
	**************************************/
	function add_donate_shortcode( $atts ) {
		$a = shortcode_atts( array( 
			'id' => 138,
			'call-to-action' => 'Donate Now'
			), $atts );
		
		if ( !is_feed() ) {
			ob_start();
		?>
		<aside class="donate-box">
			<h3><?php echo esc_attr( $a['call-to-action'] ); ?></h3>
			<form method="get">
				<input type="text" name="nyp" value data-cip-id="nyp" class="input-text amount nyp-input text" placeholder="Amount ($)" />
				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $a['id']); ?>" />
				<button type="submit" class="single_add_to_cart_button button alt" >Donate Now</button>
			</form>
			<small><a href="<?php the_permalink( $a['id']); ?>" >Learn more&hellip;</a></small>
		</aside>
		<?php
			wp_reset_postdata(); 
		
			return ob_get_clean();
		}
	}
	add_shortcode('donate', 'add_donate_shortcode' );
	
?>