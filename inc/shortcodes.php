<?php
/**
 * @package lwr
 */

	/*****************************************************
			Full Width Shortcode
 	 *****************************************************/

	/* Open Div */
	add_shortcode('full-width', 'be_div_shortcode');
	function be_div_shortcode($atts, $content = null ) {
		$return = '</div></div><div class="container-fluid">' . $content . '</div><div class="container"><div class="entry-content">';
		return $return;
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
				<div class="input-group">
				<span class="input-group-addon">$</span>
				<input type="text" name="nyp" value data-cip-id="nyp" class="input-text amount nyp-input text" placeholder="Amount" />
				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $a['id']); ?>" />
				<button type="submit" class="single_add_to_cart_button button" >Donate Now</button>
				</div>
			</form>
			<small><a href="<?php the_permalink( $a['id']); ?>" >Learn more&hellip;</a></small>
		</aside>
		<?php
			wp_reset_postdata(); 
		
			return ob_get_clean();
		}
	}
	add_shortcode('donate', 'add_donate_shortcode' );
	
	/*****************************************
		Resilience Wheel Shortcode
	******************************************/
	function add_resilience_wheel() {
			// Enqueue the Wheelstyle CSS
			wp_enqueue_style('wheel', get_stylesheet_directory_uri() . '/css/wheelstyle.css' );

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
		<?php			
	}
	add_shortcode('resilience-wheel', 'add_resilience_wheel' );

?>