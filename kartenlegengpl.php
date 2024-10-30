<?php
/**
 * Plugin Name:       Kartenlegen-GPL
 * Plugin URI:        https://orakelsee.com/wp/
 * Description:       Free Cardreading for every wordpress site
 * Version:           2.0.5
 * Requires at least: 5.2
 * Requires PHP:      5.8
 * Tested up to:      5.8
 * Author:            Orakelsee
 * Author URI:        https://orakelsee.com/
 * Text Domain:       kartenlegen-gpl
 * Domain Path:       /languages/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * Kartenlegen GPL is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version. 
 * 
 * Kartenlegen GPL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Kartenlegen GPL. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

define ( "KARTENLEGENGPL_VERSION", "2.0.5" );
define ( "KARTENLEGENGPL_REST", "https://orakelsee.com/wp/wp-json/kartenlegen/v2/card/" );

// load requirements
require ( __DIR__ . '/includes/kartenlegengpl_widget.php' );
require ( __DIR__ . '/includes/class-kartenlegengpl.php' );

function kartenlegengpl_style_script() {
   wp_enqueue_style ( 'kartenlegengpl',  plugin_dir_url( __FILE__ ). 'css/kartenlegengpl.css', false, KARTENLEGENGPL_VERSION, 'all');
   wp_enqueue_script( 'kartenlegengpl',  plugin_dir_url( __FILE__ ). 'js/kartenlegengpl.js',  false, KARTENLEGENGPL_VERSION, 'all');
   // AJAX Scripts ------------------------------------------------------------------------------------------------------------
   wp_register_script( 'kartenlegengpl_jquery', plugin_dir_url( __FILE__ ). 'js/kartenlegengpl_jquery.js' , array( 'jquery' ), KARTENLEGENGPL_VERSION, true );
   wp_enqueue_script ( 'kartenlegengpl_jquery' );
   wp_localize_script( 'kartenlegengpl_jquery', 'kartenlegengplAjax', 
                        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) , 
                               'security' => wp_create_nonce('kartenlegengpl_callback') ) );
   // End AJAX Scripts -------------------------------------------------------------------------------------------------------
}
add_action( 'wp_enqueue_scripts', 'kartenlegengpl_style_script' );

// translations      ------------------------------------------------
function kartenlegengpl_load_plugin_textdomain() {
   load_plugin_textdomain( 'kartenlegen-gpl', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'kartenlegengpl_load_plugin_textdomain' );

// Register AJAX Callback -------------------------------------------------
add_action( 'wp_ajax_kartenlegengpl_handler',        'kartenlegengpl_callback' );
add_action( 'wp_ajax_nopriv_kartenlegengpl_handler', 'kartenlegengpl_callback' );
// End Register AJAX Callback ---------------------------------------------

// register widget 
add_action( 'widgets_init', 'kartenlegengpl_register_widget' );
function kartenlegengpl_register_widget() {
    register_widget( 'KartenlegenGPL' );
}
// plugin activation --------------------------------------------------
function kartenlegengpl_activation() {
   // verify site the receive answers
   $kartenlegengplOrakel = new kartenlegengpl_Orakel();
   $result = $kartenlegengplOrakel->kartenlegengpl_RegisterSite();
   $kartenlegengplOrakel = null;
   if ( $result !== true ) {
      wp_die( sprintf('<p><strong>' . $result . esc_html__( 'Kartenlegen GPL Plugin', 'kartenlegen-gpl'  ) .
                      '</strong><br />' . 
                      esc_html__( 'Error connecting the orakel.', 'kartenlegen-gpl'  ) .
                      '<br />' . 
                      esc_html__( 'Please try again in a few minutes.', 'kartenlegen-gpl' ) .
                      '</p>'));
   }
}
register_activation_hook( __FILE__, 'kartenlegengpl_activation' );
// plugin deactivation ------------------------------------------------
function kartenlegengpl_deactivation() {
    // unverify site
    $kartenlegengplOrakel = new kartenlegengpl_Orakel();
    $kartenlegengplOrakel->kartenlegengpl_UnRegisterSite();
    $kartenlegengplOrakel = null;
}
register_deactivation_hook( __FILE__, 'kartenlegengpl_deactivation' );
// plugin uninstall ----------------------------------------------------
function kartenlegengpl_uninstall() {
    $kartenlegengplOrakel = new kartenlegengpl_Orakel();
    $kartenlegengplOrakel->kartenlegengpl_UnRegisterSite();
    $kartenlegengplOrakel = null;
}
register_uninstall_hook(__FILE__, 'kartenlegengpl_uninstall');
?>