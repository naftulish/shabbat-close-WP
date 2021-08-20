jQuery(document).ready( function() {
    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : scwp.ajaxurl,
        data : {action: "scwp_ajax"},
        success: function(response) {
            scwp.data = response;
          	if( response.is_shabbat ){

                //alert
                if( response.is_alert_active ){
                    alert( response.alert_text );
                }
              
                //elmentor popup
                if( response.elementor_is_poup_active && elementorProFrontend ){
                    elementorProFrontend.modules.popup.showPopup( { id: response.elementor_pop_id } );
                }
            }
        }
    })
});