<?php

//enqueue scripts for front
function scwp_enqueue_scripts() {
    wp_enqueue_script('main-js', plugins_url().'/shabbat-close-wp/assets/js/main.js', [], '1.0.0', true);
    wp_localize_script('main-js', 'scwp', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'scwp_enqueue_scripts' );


//enqueue scripts for admin panel
function admin_scwp_enqueue_scripts() {

    wp_enqueue_script('admin-js', plugins_url().'/shabbat-close-wp/assets/js/admin.js', [], '1.0.0', true);
    wp_enqueue_style('scwp-admin-css',plugins_url().'/shabbat-close-wp/assets/css/style.css');
    
    if (is_admin ()){ wp_enqueue_media ();}
}
add_action( 'admin_enqueue_scripts', 'admin_scwp_enqueue_scripts' );
