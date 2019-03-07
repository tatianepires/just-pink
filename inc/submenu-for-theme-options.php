<?php
// Add submenu for theme options
// =============================================================================

function justpink_wp_submenu() {
	$page_title = __('Just Pink Settings', 'justpink');
    $menu_title = 'Just Pink';
    $capability = 'manage_options';
    $menu_slug = 'just-pink-settings';
    $function = 'just_pink_settings';
	add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function);
}
add_action('admin_menu', 'justpink_wp_submenu');

function just_pink_settings() {
	
	if (!current_user_can('manage_options'))
		wp_die(__('You do not have sufficient permissions to access this page.', 'justpink'));

	// Variables for the field and option names
	$justpink_extras = 'justpink-extras';
	
	// Verify if the form was submitted
	$hidden_field = 'justpink-hidden';
	
	// Nonces
	$nonce_action = 'update-justpink-options';
	$nonce_name = 'update_justpink_options_nonce';
	
	$justpink_options = array();
	$justpink_options = get_option('justpink-options');
	
	// See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[$hidden_field]) && $_POST[$hidden_field] == 'Y' ) {
		
		if (isset($_POST[$nonce_name]) && wp_verify_nonce($_POST[$nonce_name], plugin_basename(__FILE__))) {
		
			// Read posted values
			if(isset($_POST[$justpink_extras]) && strlen($_POST[$justpink_extras]) > 0) $justpink_options[$justpink_extras] = intval($_POST[$justpink_extras]);
			
			// Save the posted value in the database
			update_option('justpink-options', $justpink_options);
			
			// Put an settings updated message on the screen ?>
			<div class="updated"><p><strong><?php _e('Just Pink settings updated.', 'justpink'); ?></strong></p></div>
			<?php
		}
		else { ?>
			<div class="updated"><p><strong><?php _e('Invalid nonce.', 'justpink'); ?></strong></p></div>
		<?php
		}
	}
	?>
	
	<div id="just-pink-settings" class="wrap">
		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e('Just Pink Settings', 'justpink'); ?></h2>
		
		<div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder columns-2">
				
                <div class="postbox-container contact">
                    <div class="meta-box-sortables">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e('Display theme extras', 'justpink'); ?></span></h3>
                            <div class="inside">
                                <form method="post" action="">
                                    <input type="hidden" name="<?php echo $hidden_field; ?>" value="Y">
									<input type="hidden" name="<?php echo $nonce_name; ?>" id="<?php echo $nonce_name; ?>" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)) ?>" />
									
									<p>
										<?php _e('Last posts, top five tags and categories are extra lists that can be displayed below the header navigation menu. ', 'justpink'); ?>
									</p>
									
									<p>
										<input type="radio" name="<?php echo $justpink_extras; ?>" id="justpink-theme-extras-1" value="1" <?php if(isset($justpink_options[$justpink_extras]) && $justpink_options[$justpink_extras] == 1) { echo 'checked="true" '; } ?>/>
										<label for="justpink-theme-extras-1"><?php _e('Display extras and navigation menu on header.', 'justpink'); ?></label>
									</p>
									
									<p>
										<input type="radio" name="<?php echo $justpink_extras; ?>" id="justpink-theme-extras-2" value="2" <?php if(isset($justpink_options[$justpink_extras]) && $justpink_options[$justpink_extras] == 2) { echo 'checked="true" '; } ?>/>
										<label for="justpink-theme-extras-2"><?php _e('Display only navigation menu on header.', 'justpink'); ?></label>
									</p>
									
									<p class="submit">
                                        <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save theme changes', 'justpink'); ?>" />
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- .postbox-container -->
			</div> <!-- #dashboard-widgets -->
        </div> <!-- #dashboard-widgets-wrap -->
	</div>	
	
<?php	
}
