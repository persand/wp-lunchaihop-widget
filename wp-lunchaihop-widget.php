<?php
/*
Plugin Name: Lunchaihop Widget
Plugin URI: http://www.lunchaihop.se/widget
Description: Widget for www.lunchaihop.se.
Version: 1.0
Author: Per Sandström
Author URI: http://www.helloper.com
*/
class LunchaihopWidget extends WP_Widget {
  function LunchaihopWidget() {
    $widget_ops = array( 'classname' => 'lunchaihop-widget', 'description' => __( 'Widget for www.lunchaihop.se.', 'LunchaihopWidget' ) );

    $this->WP_Widget( 'LunchaihopWidget', 'Lunchaihop', $widget_ops );

    wp_register_style( 'lunchaihop-widget', plugins_url( 'css/lunchaihop.css' , __FILE__ ) );
    wp_enqueue_style( 'lunchaihop-widget' );
  }
 
  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

    $lunch_dates = ( empty( $instance['lunch_dates'] ) ) ? '' : esc_attr( $instance['lunch_dates'] );
    $your_name = ( empty( $instance['your_name'] ) ) ? '' : esc_attr( $instance['your_name'] );
    $linkedin_url = ( empty( $instance['linkedin_url'] ) ) ? '' : esc_attr( $instance['linkedin_url'] );
    $disable_background_color = ( empty( $instance['disable_background_color'] ) ) ? '' : esc_attr( $instance['disable_background_color'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'lunch_dates' ); ?>">
        <?php _e( 'People on my wishlist:', 'LunchaihopWidget' ); ?>
        <input class="widefat" id="<?php echo $this->get_field_id( 'lunch_dates' ); ?>" name="<?php echo $this->get_field_name( 'lunch_dates' ); ?>" type="text" value="<?php echo $lunch_dates; ?>" />
      </label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'your_name' ); ?>">
        <?php _e( 'My name:', 'LunchaihopWidget' ); ?>
        <input class="widefat" id="<?php echo $this->get_field_id( 'your_name' ); ?>" name="<?php echo $this->get_field_name( 'your_name' ); ?>" type="text" value="<?php echo $your_name; ?>" />
      </label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>">
        <?php _e( 'LinkedIn URL:', 'LunchaihopWidget' ); ?>
        <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text" value="<?php echo $linkedin_url; ?>" />
      </label>
      <?php _e( 'E.g. <em>http://www.linkedin.com/in/jonaslarsson</em>.', 'LunchaihopWidget' ); ?>
    </p>

    <?php $checked = empty( $disable_background_color ) ? '' : ' checked="checked"' ; ?> 
    <p>
      <input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'disable_background_color' ); ?>" name="<?php echo $this->get_field_name( 'disable_background_color' ); ?>"<?php echo $checked; ?> />
      <label for="<?php echo $this->get_field_id( 'disable_background_color' ); ?>"><?php _e( 'Disable background color', 'LunchaihopWidget' ); ?></label>
    </p>
    <?php
  }
 
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['lunch_dates'] = $new_instance['lunch_dates'];
    $instance['your_name'] = $new_instance['your_name'];
    $instance['linkedin_url'] = $new_instance['linkedin_url'];
    $instance['disable_background_color'] = $new_instance['disable_background_color'];
    return $instance;
  }
 
  function widget( $args, $instance ) {
    extract( $args, EXTR_SKIP );

    $lunch_dates = empty( $instance['lunch_dates'] ) ? '' : esc_attr( $instance['lunch_dates'] );
    $your_name = empty( $instance['your_name'] ) ? '' : esc_attr( $instance['your_name'] );
    $linkedin_url = empty( $instance['linkedin_url'] ) ? '' : esc_attr( $instance['linkedin_url'] );
    $disable_background_color = empty ( $instance['disable_background_color'] ) ? 'false' : $instance['disable_background_color'];

    echo $before_widget;

    if ( $disable_background_color == 'false' ) {
      $widget_classes = 'widget-lunchaihop-background widget-lunchaihop-clearfix';
    } else {
      $widget_classes = 'widget-lunchaihop-clearfix';
    }

    echo sprintf( '<div class="%s">', $widget_classes );

    echo $before_title;
    echo 'Lunchaihop';
    echo $after_title;

    echo sprintf ( '<a href="http://www.lunchaihop.se"><img class="widget-lunchaihop-logo" src="%s" alt="Lunchaihop"></a>', plugins_url( 'img/lunchaihop-logo.png' , __FILE__ ) );

    if ( !empty( $lunch_dates ) ) {
      echo '<p class="widget-lunchaihop-wishlist">'.__( 'My lunch wishlist:', 'LunchaihopWidget' ).'<br>'.$lunch_dates.'</p>';
    }

    echo __( 'Who should I <a href="http://www.lunchaihop.se">lunch with</a>?', 'LunchaihopWidget' );

    if ( !empty( $linkedin_url ) ) {
      if ( !empty( $your_name ) ) {
        $your_name = ' data-text="'.$your_name.'" ';
      } else {
        $your_name = '';
      }

      echo sprintf( '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/MemberProfile" data-id="%s" data-format="click"%sdata-related="false"></script>', $linkedin_url, $your_name );
    }
    
    echo sprintf( '</div><!-- / %s -->', $widget_classes );
    
    echo $after_widget;
  }
}

add_action( 'widgets_init', create_function('', 'return register_widget("LunchaihopWidget");') );

$plugin_dir = basename( dirname( __FILE__ ) ) . '/lang/';
load_plugin_textdomain( 'LunchaihopWidget', null, $plugin_dir );
?>