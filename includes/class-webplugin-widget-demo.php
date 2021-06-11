<?php
/**
 * Widget API: webplugin_widget_demo class
 *
 * @package Webplugin
 * @subpackage WebPlugin/includes
 * @since 1.0.0
 */

/**
 * Core class used to implement a Demo widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */

class webplugin_widget_demo extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
    	$widget_ops = array(
			'classname' 					=> 'widget_demo_field',
			'description' 					=> __( 'Webplugin Demo Widget.' ),
			'customize_selective_refresh' 	=> true,
		);
    	parent::__construct( 'web_demo', _x( 'Demo Widget', 'Webplugin Demo Widget' ), $widget_ops );
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
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
 		$gsgen = $instance['gshow'];
        echo $before_widget;

        // Widget title 
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }

        // Widge Information
        echo '<div class="textwidget">';
	        echo '<p class="demo_iper">';
	        echo esc_html__('Hello, My name is '. $instance['fname'].' '.$instance['lname'], 'webplugin' );
	        echo '</p>';
	   		// Check sex display publicly or not and display Sex value
	        if( ! empty($gsgen) )
	        {
	        	echo '<p class="demo_igen">';
	        		echo esc_html__('Sex: '. $instance['gender'], 'webplugin' );
	        	echo '</p>';
	        }
        echo '</div>';
        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        
        // Retrive Widget Field value to show in Field area

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'webplugin' );
        $fname = ! empty( $instance['fname'] ) ? $instance['fname'] : esc_html__( '', 'webplugin' );
        $lname = ! empty( $instance['lname'] ) ? $instance['lname'] : esc_html__( '', 'webplugin' );
        $gender = ! empty( $instance['gender'] ) ? $instance['gender'] : esc_html__( '', 'webplugin' );
        $gshow = ! empty( $instance['gshow'] ) ? $instance['gshow'] : esc_html__( '', 'webplugin' );
        ?>
        
        <!--  Widget HTML Design Strucutred.-->

        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_name( 'fname' ); ?>"><?php _e( 'First Name:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'fname' ); ?>" name="<?php echo $this->get_field_name( 'fname' ); ?>" type="text" value="<?php echo esc_attr( $fname ); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_name( 'lname' ); ?>"><?php _e( 'Last Name:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'lname' ); ?>" name="<?php echo $this->get_field_name( 'lname' ); ?>" type="text" value="<?php echo esc_attr( $lname ); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_name( 'gender' ); ?>"><?php _e( 'Sex:' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'gender' ); ?>" id="<?php echo $this->get_field_id( 'gender' ); ?>" style="width: 100%;">
			  <option value="male" <?php echo esc_attr( $gender )=='male' ? 'selected' : '';?> >Male</option>
			  <option value="female" <?php echo esc_attr( $gender )=='female' ? 'selected' : '';?> >Female</option>
			</select>
         </p>
          <p>
          		<input type="checkbox" id="<?php echo $this->get_field_name( 'gshow' ); ?>" name="<?php echo $this->get_field_name( 'gshow' ); ?>" value="yes" <?php echo esc_attr( $gshow )=='yes' ? 'checked' : '';?> ><label for="vehicle1"> Display Sex Publicly?</label>
          </p>
    <?php
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
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['fname'] = ( !empty( $new_instance['fname'] ) ) ? strip_tags( $new_instance['fname'] ) : '';
        $instance['lname'] = ( !empty( $new_instance['lname'] ) ) ? strip_tags( $new_instance['lname'] ) : '';
        $instance['gender'] = ( !empty( $new_instance['gender'] ) ) ? strip_tags( $new_instance['gender'] ) : '';
        $instance['gshow'] = ( !empty( $new_instance['gshow'] ) ) ? strip_tags( $new_instance['gshow'] ) : '';
 
        return $instance;
    }

}