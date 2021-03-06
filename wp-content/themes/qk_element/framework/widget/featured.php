<?php
global  $textdomain;
// Creating the widget 
class featured_post_widget extends WP_Widget {

function __construct() {
	global $textdomain;
parent::__construct(
// Base ID of your widget
'featured_post_widget', 

// Widget name will appear in UI
__('NK Featured Posts', $textdomain), 

// Widget description
array( 'description' => __( 'Listing Featured Posts', $textdomain ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
?>

<!-- POPULAR POSTS WIDGET -->
<div class="featured-posts">
<ul class="popular-list">
	<?php 
		//echo $instance['count'].'asd';
		$arr = array('post_type' => 'post', 'posts_per_page' => $instance['count'], 'orderby' => 'comment_count');
		$query = new WP_Query($arr);
		while($query->have_posts()) : $query->the_post();
	?>
	<li>
		<?php
			if(has_post_thumbnail()){
			// Get the URL of our processed image
			$image = bfi_thumb( music_hub_thumbnail_url(''), array( 'width' => 50, 'height' => 50 ) );
		?>
		
		<img alt="<?php the_title(); ?>" src="<?php echo esc_attr($image); ?>" />
		<?php
			}else{
		?>
		<img alt="<?php the_title(); ?>" src="http://placehold.it/50x50" />
		<?php } ?>
		<span class="title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></span>
		<span class="date"><?php the_time('F d, Y'); ?></span>
	</li>
	
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
</ul>
</div><!-- //POPULAR POSTS WIDGET -->

<?php

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
global $textdomain;
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'FEATURED POSTS', 'white' );
//$count = 4;
}
if ( isset( $instance[ 'count' ] ) ) {
$count = $instance[ 'count' ];
}
else {
$count = 5;
//$count = 4;
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $textdomain); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts:', $textdomain); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget2() {
	register_widget( 'featured_post_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget2' );
?>