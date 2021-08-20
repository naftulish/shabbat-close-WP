<?php



function scwp_is_shabbat() {

    $shabbat = get_option( 'scwp_shabbat' );

    $is_shabat_state = get_option('scwp_is_shabbat');
    $scwp_is_woocommerce = get_option('scwp_is_woocommerce');

    if( $is_shabat_state ){ $shabbat = true; }

    if ( $shabbat ){
      
      	if( get_option( 'scwp_is_complete_close' ) && !is_admin()){
        	scwp_send_headers();
        }
      
        //if is woocommerce plugin active    
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

            if( $scwp_is_woocommerce ){
                add_filter( 'woocommerce_is_purchasable','__return_false',10,2);
                remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
            }
        }
    }
	
}
  
add_action( 'init', 'scwp_is_shabbat' );

function scwp_send_headers(){
//scwp_exclude_pages_ids
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $page_id = url_to_postid( $actual_link );
  $arr = explode(",", get_option( 'scwp_exclude_pages_ids' ));
  
  if ( !in_array( $page_id , $arr) || !$page_id ){
    header($_SERVER["SERVER_PROTOCOL"]." 503 Service Temporarily Unavailable", true, 503);
    $retryAfterSeconds = 86400;
    header('Retry-After: ' . $retryAfterSeconds);
    $img_url = get_option( 'scwp_complete_close_img' );
    echo '<style>body {margin: 0;}</style>';
    echo "<img src='$img_url' style='width: 100vw;height: 100vh;object-fit:cover;'/>";
    exit;
  }
}