<?php

function scwp_ajax(){
    
    ##get shabbat times from hebcal.com API
    $time_zone = urlencode ( get_option( 'scwp_time_zone') ? get_option( 'scwp_time_zone') : 'IL-Jerusalem');
    $data = file_get_contents("https://www.hebcal.com/shabbat/?cfg=json&m=50&b=40&city=$time_zone&leyning=off");
  	
  	$times = json_decode($data, true);

    $candles = '';
    $havdalah = '';
    $yomtov = 0;

    $day =  date('Y-m-d');

    foreach ( $times['items'] as $item ) {
        if( $item['category']  == 'candles' && $candles =='' ){ $candles =  $item['date']; }
        if( $item['category']  == 'havdalah' && $havdalah =='' ){ $havdalah =  $item['date']; }
        if( $item['category']  == 'holiday' && $item['subcat']  == 'major' && $item['yomtov']  == true && $item['date']  == $day ){ $yomtov = 1; }
    }

    $shabbat = 0;
  
  	$now = new DateTime();
    $candles = new DateTime( $candles );
    $havdalah = new DateTime( $havdalah );

    if ( $yomtov ==  1 && $now <= $havdalah ){ $shabbat = 1; }
    if ( $candles <= $now && $now <= $havdalah ) { $shabbat = 1; }

    update_option( 'scwp_shabbat' , $shabbat );

    $is_shabat_state = get_option('scwp_is_shabbat');
    if( $is_shabat_state ){ $shabbat = 1; }

    $elementor_is_poup_active = get_option('scwp_elementor_is_poup_active');
    $elementor_pop_id = get_option('scwp_elementor_pop_id');

    $is_alert_active = get_option('scwp_is_alert_active');
    $alert_text = get_option('scwp_alert_msg_active');

    $scwp_shabbat_data = array(
        "is_shabbat" => $shabbat,
        "is_alert_active" =>  $is_alert_active,
        "alert_text" =>  $alert_text,
        "yomtov" =>  $yomtov,
      	"candles" => $candles,
        "havdalah" =>  $havdalah
    );
  
  	if ( in_array( 'elementor-pro/elementor-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $scwp_shabbat_data["elementor_is_poup_active"] =  $elementor_is_poup_active;
        $scwp_shabbat_data["elementor_pop_id"] =  $elementor_pop_id;
    }

    $result = json_encode( $scwp_shabbat_data );
    echo $result;

    wp_die();
}
    
add_action( 'wp_ajax_scwp_ajax', 'scwp_ajax');
add_action( 'wp_ajax_nopriv_scwp_ajax', 'scwp_ajax' );