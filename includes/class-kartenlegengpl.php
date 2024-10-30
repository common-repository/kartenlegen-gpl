<?php
defined( 'ABSPATH' ) || exit;
function kartenlegengpl_callback() {
   if ( wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'kartenlegengpl_callback' ) == false) { 
      esc_html_e( "403" );
      wp_die();
   }
   $kartenlegengplOrakel = new kartenlegengpl_Orakel();
   if ( isset( $_POST["cards"] ) and isset($_POST["lang"]) ) { 
      esc_html_e( $kartenlegengplOrakel->kartenlegengpl_GetSpell( sanitize_text_field( $_POST["cards"] ), sanitize_text_field( $_POST["lang"] ) ) ); 
   }
   if ( isset( $_POST["card"]) ) { 
      esc_html_e( $kartenlegengplOrakel->kartenlegengpl_GetCard( sanitize_text_field( $_POST["card"] ) ) ); 
   }
   $kartenlegengplOrakel = null;
   wp_die();
}

class kartenlegengpl_Orakel {
   public function kartenlegengpl_Show() { 
      if ( isset( $_COOKIE["kartenlegengpl"] ) ) {
         $allowed_html = [ 'br'     => [] ];
         return wp_kses( $_COOKIE["kartenlegengpl"], $allowed_html );
      }
      $buffer = '';
      $buffer .= '<div class="kartenlegengpl"><div id="cselector">';
      $cards = array('b0','b1','b2','b3','b7','b8','b9','bx','e0','e1','e2','e3','e7','e8','e9','ex',
                     'g0','g1','g2','g3','g7','g8','g9','gx','h0','h1','h2','h3','h7','h8','h9','hx');                     
      shuffle($cards);
      for ( $i=1; $i<=32 ; $i++ ) { 
         $margin = $i;
         if ( $i < 16 ) { $margin = 16 - $i; } else { $margin = $i -16; }
         $alt = $cards[ $i-1 ]; 
         if ( in_array( $i, array( 32,31,2,1 ) ) )   { $margin = 7; }
         if ( in_array( $i, array( 30,29,4,3 ) ) )   { $margin = 6; }
         if ( in_array( $i, array( 28,27,6,5 ) ) )   { $margin = 5; }
         if ( in_array( $i, array( 26,25,8,7 ) ) )   { $margin = 4; }
         if ( in_array( $i, array( 24,23,10,9 ) ) )  { $margin = 3; }
         if ( in_array( $i, array( 22,21,12,11 ) ) ) { $margin = 2; }
         if ( in_array( $i, array( 20,19,14,13 ) ) ) { $margin = 1; }
         if ( in_array( $i, array( 18,17,16,15 ) ) ) { $margin = 0; }
         $buffer .= '<div class="backimage" id="' . esc_html( $alt ) . '" 
                     onclick="kartenlegengpl_selectCard(\'' . esc_html( $alt ) . '\',\'' . 
                     get_bloginfo("language") . '\');"  style="margin-top:' . esc_html( $margin ) . 'px"></div>'; 
      }
      $buffer .= '<div style="clear:left"></div></div>';
      $buffer .= '<div id="orakelhelper">' . esc_html__( "Think about your question" , "kartenlegen-gpl"  );
      $buffer .= '<br />';
      $buffer .=  esc_html__( "and draw 3 cards", "kartenlegen-gpl" );
      $buffer .= '</div>';
      $buffer .= '<div id="selectedcards"></div>';
      $buffer .= '<div id="orakelwait">' . esc_html__( "The Orakelsee is beeing asked", "kartenlegen-gpl" ) . '</div>';
      $buffer .= '<div id="orakelspruch"></div>';
      $buffer .= '</div>';
      return $buffer;
   }
   public function kartenlegengpl_GetCard($id) { 
      if ( file_exists( __DIR__ . "/../images/" . esc_html( $id ) . ".jpg" ) ) {
         return plugin_dir_url( __FILE__ ) . "../images/" . esc_html( $id ) . ".jpg" ;
      }
   }
   public function kartenlegengpl_GetSpell($cards, $lang) {
      global $wp_version;
      $result = "";
      $cards = sanitize_text_field($cards);
      $lang = sanitize_text_field($lang);
      $args = array( 'timeout'     => 10,
                     'redirection' => 5,
                     'httpversion' => '1.0',
                     'user-agent'  => 'GPLWordPress/' . $wp_version . '|' . home_url(),
                     'blocking'    => true,
                     'headers'     => array(),
                     'cookies'     => array(),
                     'body'        => null,
                     'compress'    => false,
                     'decompress'  => true,
                     'sslverify'   => false,
                     'stream'      => false,
                     'filename'    => null ); 
      $response = wp_remote_get( KARTENLEGENGPL_REST . '?spell=' . esc_html( $cards ) . '&lang= ' . esc_html( $lang ) . '&url=' . home_url(), $args);
      if ( is_array( $response ) ) {
         $result = json_decode( $response['body'] );
      }
      $allowed_html = [ 'br'     => [] ];
      echo wp_kses( $result, $allowed_html );
   }
   public function kartenlegengpl_RegisterSite() {
      global $wp_version;
      $result = "";
      $args = array( 'timeout'     => 10,
                     'redirection' => 5,
                     'httpversion' => '1.0',
                     'user-agent'  => 'GPLWordPress/' . $wp_version . '|' . home_url(),
                     'blocking'    => true,
                     'headers'     => array(),
                     'cookies'     => array(),
                     'body'        => null,
                     'compress'    => false,
                     'decompress'  => true,
                     'sslverify'   => false,
                     'stream'      => false,
                     'filename'    => null ); 
      $response = wp_remote_get( KARTENLEGENGPL_REST . '?reg=' . home_url() . '&wpver= ' . $wp_version, $args);
      if ( is_array( $response ) ) {
         $result = sanitize_text_field( json_decode( $response['body'] ) );
      }
      if ($result == "OK") {
         return true;
      } else {
         return $result;
      }
   }
   public function kartenlegengpl_UnRegisterSite() {
      global $wp_version;
      $result = "";
      $args = array( 'timeout'     => 10,
                     'redirection' => 5,
                     'httpversion' => '1.0',
                     'user-agent'  => 'GPLWordPress/' . $wp_version . '|' . home_url(),
                     'blocking'    => true,
                     'headers'     => array(),
                     'cookies'     => array(),
                     'body'        => null,
                     'compress'    => false,
                     'decompress'  => true,
                     'sslverify'   => false,
                     'stream'      => false,
                     'filename'    => null ); 
      $response = wp_remote_get( KARTENLEGENGPL_REST . '?unreg=' . home_url(), $args);
      if ( is_array( $response ) ) {
         $result = sanitize_text_field( json_decode( $response['body'] ) );
      }
      if ($result == "OK") {
         return true;
      } else {
         return $result;  // doesn't matter
      }
   }
} // end kartenlegengpl_Orakel
?>
