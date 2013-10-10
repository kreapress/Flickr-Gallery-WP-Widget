<?php 
/**
 * Plugin Name: Flickr Gallery Widget
 * Plugin URI: https://github.com/primozcigler/Flickr-Gallery-WP-Widget
 * Description: Displays a simple gallery from Flickr
 * Version: 1.0.0
 * Author: Primož Cigler, @primozcigler
 * Author URI: http://twitter.com/primozcigler
 * License: GPL2
 * @todo add the URL above
 */

/**************************************
 * Flickr gallery
 * -----------------------------------
 * Last images from the flickr account 
 **************************************/

class ProteusThemes_Flickr_Gallery_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		false, // ID, auto generate when false
			__( "ProteusThemes Flickr Gallery" ), // Name
			array(
				'description' => __( 'Gallery of the latest 9 images from any Flickr account' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		?>
		
            <?php echo $args['before_title'] . $instance['title'] . $args['after_title']; ?>

            <div class="sidebar-post sidebar-gallery">
                <div class="js-jflickrfeed-fetch flickr" data-userid="<?php echo $instance['user_id']; ?>" data-number="<?php echo $instance['number']; ?>">
                    <!-- gallery loaded via JavaScript goes here -->
                </div>
            </div>	
		
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user_id'] = strip_tags( $new_instance['user_id'] );
		$instance['number'] = min( (int) $new_instance['number'], 10 );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
            
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'Flickr Gallery' );
        $user_id = isset( $instance['user_id'] ) ? $instance['user_id'] : '52617155@N08';
        $number = isset( $instance['number'] ) ? $instance['number'] : 9;
        
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php _e( 'User ID:' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'user_id' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" type="text" value="<?php echo esc_attr( $user_id ); ?>" />
			<br />
			<small><a href="https://www.diigo.com/item/image/3rli1/h0a2?size=o" target="_blank">Where do you get this User ID?</a></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of images (limited to 10):' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo (int) $number; ?>" />
		</p>
		
		<?php 
	}

} // class Home_Testimonials
add_action( 'widgets_init', create_function( '', 'register_widget( "ProteusThemes_Flickr_Gallery_Widget" );' ) );



if ( ! function_exists( "enqueue_flickr_gallery_deps" ) ) {
	/**
	 * Adds the jQuery plugin and the basic CSS
	 * @return void
	 */
	function enqueue_flickr_gallery_deps() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'flickr-js', plugin_dir_url( __FILE__ ) . "js/jflickrfeed/jflickrfeed.min.js", array( 'jquery' ), FALSE, TRUE );
		wp_enqueue_script( 'flickr-js-custom', plugin_dir_url( __FILE__ ) . "js/custom.js", array( 'flickr-js' ), FALSE, TRUE );
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_flickr_gallery_deps' );
}
