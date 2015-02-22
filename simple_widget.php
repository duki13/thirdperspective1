<?php
/*
Plugin Name: Simple (yet complex) Naming Widget
Description: Inputs age, first name and last name
Author: Dusan Miletic
Influential web developer: Josh Leuze
*/
/*
Here I am naming classes in order to not overlap with functions and other future variables. I am choosing
to name the following widget as Simple_Widget. This will be a subset of the WP_Widget
*/
class Simple_Widget extends WP_Widget {
 
   /* This code will register the Widget through wordpress and create the widgets name through the parent. 
   the widget becomes diffined within the array.  this is so people interested in using it will understand its function. 
   */
    function __construct() {
        parent::__construct(
            'name', // Base ID
            __('Name Widget', 'simple_widget'), // Name
            array( 'description' => __( 'A widget for adding your first name, last name and age.', 'simple_widget' ), ) // Args
        );
    }
    /*
    Front end of the widget, this code is visible and displays the users input of their name, last name, and age if the
    user does not input anything within the textboxes, the fields will return blank, instead of displaying an error message. 
    This is visible on the homepage of the url and will either display the users information, or show blank spaces. 
    
    */
    
    public function widget( $args, $instance ) {
        $first_name = apply_filters( 'widget_title', $instance['first_name'] );
        $last_name = apply_filters( 'widget_title', $instance['last_name'] );
        $age = apply_filters( 'widget_title', $instance['age'] );
	
        echo $args['before_widget'];
            echo $args['before_title'] . 'First Name' . $args['after_title'];
            if ( ! empty( $first_name ) ) {
                echo '<p>' . $first_name . '</p>';
            }
            echo $args['before_title'] . 'Last Name' . $args['after_title'];
            if ( ! empty( $last_name ) ) {
                echo '<p>' . $last_name . '</p>';
            }
            echo $args['before_title'] . 'Age' . $args['after_title'];
            if ( ! empty( $age ) ) {
                echo '<p>' . $age . '</p>';
            }
        echo $args['after_widget'];
    }
 /*
 Similarly to the previous code, this content is visible, however this is where the user inputs their 
 information within the widget. This code states that what ever values the user inputs under each field, display it 
 under its corresponding textbox. There is also a statement that ensures an error will not occur if a feild is left blank
 . it will simply return a blank space.
 */
    
    public function form( $instance ) {
        if ( isset( $instance[ 'first_name' ] ) ) {
            $first_name = $instance[ 'first_name' ];
        }
        else {
            $first_name = __( 'Input First Name', 'simple_widget' );
        }
        if ( isset( $instance[ 'last_name' ] ) ) {
            $last_name = $instance[ 'last_name' ];
        }
        else {
            $last_name = __( 'Input Last Name', 'simple_widget' );
        }
        if ( isset( $instance[ 'age' ] ) ) {
            $age = $instance[ 'age' ];
        }
        else {
            $age = __( 'Input Age', 'simple_widget' );
        }
	/* Backend of widget. This is where the user input content will be loaded, in the case that a user inputs any information
	alternativley, a blank field will appear if there is no data to echo
	*/	
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'first_name' ); ?>"><?php _e( 'First Name:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'first_name' ); ?>" name="<?php echo $this->get_field_name( 'first_name' ); ?>" type="text" value="<?php echo esc_attr( $first_name ); ?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'last_name' ); ?>"><?php _e( 'Last Name:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'last_name' ); ?>" name="<?php echo $this->get_field_name( 'last_name' ); ?>" type="text" value="<?php echo esc_attr( $last_name ); ?>">
        </p>
        <p>
        <label for="<?php echo $this->get_field_id( 'age' ); ?>"><?php _e( 'Age:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'age' ); ?>" name="<?php echo $this->get_field_name( 'age' ); ?>" type="text" value="<?php echo esc_attr( $age ); ?>">
        </p>
        <?php
    }
 /* Sanitization of code is used here as a preventitive tactic. this helps protet the code from being tampered with by only saving desired data. 
 tags are striped in order to keep only what is desired. 
 */
   
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['first_name'] = ( ! empty( $new_instance['first_name'] ) ) ? strip_tags( $new_instance['first_name'] ) : '';
        $instance['last_name'] = ( ! empty( $new_instance['last_name'] ) ) ? strip_tags( $new_instance['last_name'] ) : '';
        $instance['age'] = ( ! empty( $new_instance['age'] ) ) ? strip_tags( $new_instance['age'] ) : '';
        
        return $instance;
    }
 
}

/*
Here we register the widget function within a regular function we created. This is followed by an action that loads 
the Simple naming widget that has been created. Furthermore, we call upon the .css stylesheet within Cpanel by using the wp_enqueue call. 
This .css file is then loaded when it is put in place with the add action. This part took quite a bit of time, it is easier to call the .css 
within the html using "<link> ref however, it is not good practice, especially when multiple stylesheets are in use. This way, the styling only applies
the the widget it is intended to affect. 
*/

function register_simple_widget() {
    register_widget( 'Simple_Widget' );
    
}   

function themeslug_enqueue_style() {
    wp_enqueue_style( 'core', 'https://phoenix.sheridanc.on.ca/~ccit2649/wp-content/plugins/DukiWidget/style.css', false ); 
}
  



add_action( 'widgets_init', 'register_simple_widget' );
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );
/*
sources including Image used, http://cdsi.ca/wp-content/uploads/2014/08/Man-pointing1.png
*/
?>