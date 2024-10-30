<?php
/**
 * Adds KartenlegenGPL_Widget widget.
 */
defined( 'ABSPATH' ) || exit;

load_kartenlegengpl_textdomain();
function load_kartenlegengpl_textdomain() {
   if ( function_exists( 'determine_locale' ) ) {
      $locale = determine_locale();
   } else {
      $locale = get_bloginfo("language");
   }
   $locale = apply_filters( 'plugin_locale', $locale, 'kartenlegen-gpl' );
   if ( file_exists( __DIR__ . '/../languages' . '/kartenlegengpl-' . $locale . '.mo' ) ) {
      unload_textdomain( 'kartenlegen-gpl' );
      load_textdomain( 'kartenlegen-gpl', __DIR__ . '/../languages' . '/kartenlegengpl-' . $locale . '.mo' );
      load_plugin_textdomain( 'kartenlegen-gpl', false, __DIR__ . '/../languages' );
   }
}


class KartenlegenGPL extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'kartenlegengpl', // Base ID
            esc_html__( 'Free fortune telling', 'kartenlegen-gpl' ), // Name
            array( 'description' => esc_html__( 'Free card reading', 'kartenlegen-gpl' ), ) // Args
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
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        $kartenlegengplOrakel = new kartenlegengpl_Orakel();
        echo $kartenlegengplOrakel->kartenlegengpl_Show();  // escaped inside
        $kartenlegengplOrakel = null;
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
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = esc_html__( 'Free Cardreading', 'kartenlegen-gpl' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php esc_html__( 'Title:', 'kartenlegen-gpl' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
        $instance['title'] = sanitize_text_field($instance['title']);
        return $instance;
    }
 
} // class KartenlegenGPL_Widget
 
?>