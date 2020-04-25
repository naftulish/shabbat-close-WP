<?php

function scwp_is_shabbat() {

    $shabbat = get_option( 'scwp_shabbat' );

    $is_shabat_state = get_option('scwp_is_shabbat');
    $scwp_is_woocommerce = get_option('scwp_is_woocommerce');

    if( $is_shabat_state ){ $shabbat = true; }

    if ( $shabbat ){

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
