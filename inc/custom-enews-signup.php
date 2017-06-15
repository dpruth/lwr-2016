<?php
/**
 * @package storefront
 */
 
 if ( is_front_page() ) { 
					$source = 'homepage';
					$value = '1';
					$group = 'group[5197][1]';
					$name = 'eNews (every other Friday)';
					$mce_group = 'mce-group[5197]-5197-0';
			} elseif ( is_singular() && in_category('blog') ) {
					$source = 'blog-post';
					$value = '4';
					$group = 'group[5197][4]';
					$name = 'LWR&rsquo;s Blog';
					$mce_group = 'mce-group[5197]-5197-1';
			} elseif ( is_singular() && in_category('faith-in-action') ) {
					$source = 'faith-in-action';
					$value = '8192';
					$group = 'group[5197][8192]';
					$name = 'Faith in Action';
					$mce_group = 'mce-group[5197]-5197-2';				
			} else {
					$source = 'blog';
					$value = '1';
					$group = 'group[5197][1]';
					$name = 'eNews (every other Friday)';
					$mce_group = 'mce-group[5197]-5197-0';
			}
?>

<!-- Begin MailChimp Signup Form -->
<form action="//lwr.us11.list-manage.com/subscribe/post?u=9ede5b497f32f90e55971b4c3&amp;id=a7efd06af7&SIGNUP=<?php echo esc_attr( $source );	?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <input type="email" placeholder="Enter your email address&hellip;" value="" name="EMAIL" class="required email" id="mce-EMAIL">
    <div class="mc-field-group input-group" style="display:none">
        <ul><li><input type="checkbox" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $group ); ?>" id="<?php echo esc_attr( $mce_group ); ?>" checked><label for="<?php echo esc_attr( $group ); ?>">Subscribe to <?php echo esc_attr( $name ); ?></label></li></ul>
    </div>

    <div id="mce-responses">
        <div class="response" id="mce-error-response" style="display:none"></div>
        <div class="response" id="mce-success-response" style="display:none"></div>
    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

    <div style="position: absolute; left: -5000px;" aria-hidden="true">
        <input type="text" name="b_9ede5b497f32f90e55971b4c3_a7efd06af7" tabindex="-1" value="">
    </div>
    <input type="submit" value="SIGN UP" name="subscribe" id="mc-embedded-subscribe" class="button" onClick="ga('send', 'event', 'MailChimp', 'Sign-Up', '<?php echo esc_attr( $name); ?>' );" >
</form>

<?php wp_enqueue_script('MC Validation', '//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'); ?>
<script type='text/javascript'>
    window.setTimeout(function () {
        window.fnames = new Array(); window.ftypes = new Array();
        fnames[1] = 'FNAME';ftypes[1] = 'text';fnames[2] = 'LNAME';ftypes[2] = 'text';fnames[0] = 'EMAIL';ftypes[0] = 'email';fnames[3] = 'ADDRESS';ftypes[3] = 'address';fnames[4] = 'MMERGE4';ftypes[4] = 'text';
        var $mcj = jQuery.noConflict(true);}, 500);
</script>
<!--End mc_embed_signup-->
