<?php
/******************************
 * Use translation
 ******************************/
function justpink_theme_setup(){
    load_theme_textdomain('justpink', get_stylesheet_directory().'/languages');
}
add_action('after_setup_theme', 'justpink_theme_setup');

/******************************
 * Enqueue styles to add font
 ******************************/
function justpink_fonts() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_register_style('tpsjustpink-fonts', $protocol.'://fonts.googleapis.com/css?family=Indie+Flower');
	wp_enqueue_style( 'tpsjustpink-fonts');
}
add_action('wp_enqueue_scripts', 'justpink_fonts');

/******************************
 * Add submenu for theme options
 ******************************/
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

/******************************
 * Function to display theme extras
 ******************************/
function justpink_theme_extras() {
	$justpink_extras = 'justpink-extras';
	
	$justpink_options = get_option('justpink-options');
	
	if(is_array($justpink_options)) :
		if(isset($justpink_options[$justpink_extras]) && $justpink_options[$justpink_extras] == 1) : ?>
			
			<div id="just-pink-extras" class="clearfix">
				<?php
				// Last five posts
				global $post;
				$args = array(
						'numberposts' => 5,
						'post_status' => 'publish'
						);
				$recent_posts = get_posts($args);
				echo '<div class="latest-posts">';
				echo '<strong class="latest-posts-title">'.__('Latest posts', 'justpink').'</strong>';
				echo '<ul>';
				foreach($recent_posts as $post) : setup_postdata($post); ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php
				endforeach;
				echo '</ul>';
				echo '</div> <!-- .latest-posts -->';
				
				
				// Top five tags
				$args = array(
						'orderby' => 'count',
						'order' => 'DESC',
						'number' => 5
						);
				$tags = get_tags($args);
				echo '<div class="top-tags">';
				echo '<strong class="top-tags-title">'.__('Top tags', 'justpink').'</strong>';
				echo '<ul>';
				foreach($tags as $tag) : ?>
					<li><a href="<?php get_tag_link($tag->term_id); ?>"><?php echo $tag->name.' ('.$tag->count.')'; ?></a></li>
				<?php
				endforeach;
				echo '</ul>';
				echo '</div> <!-- .top-tags -->';
				
				
				// Top five categories
				$args = array(
						'orderby' => 'count',
						'order' => 'DESC',
						'hierarchical' => false,
						'number' => 5
						);
				$categories = get_categories($args);
				echo '<div class="top-categories">';
				echo '<strong class="top-categories-title">'.__('Top categories', 'justpink').'</strong>';
				echo '<ul>';
				foreach($categories as $cat) : ?>
					<li><a href="<?php get_category_link($cat->cat_ID); ?>"><?php echo $cat->name.' ('.$cat->count.')'; ?></a></li>
				<?php
				endforeach;
				echo '</ul>';
				echo '</div> <!-- .top-categories -->';
				?>
			</div> <!-- #just-pink-extras -->
		<?php
		endif;
	endif;
	?>
	
<?php
}
?>