<?php
// Display theme extras
// =============================================================================

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
