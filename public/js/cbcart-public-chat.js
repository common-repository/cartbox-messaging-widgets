(function( $ ) {
    'use strict';
    jQuery(document).on("ready",function($) {
    var cbcart_chat_setting = {
        cbcart_chat_account1_enable:cbcart_chat_object.cbcart_is_ac_1,
        cbcart_chat_account1_name: cbcart_chat_object.cbcart_chat_account1_name,
        cbcart_chat_account1_namber: cbcart_chat_object.cbcart_chat_account1_number,
        cbcart_chat_account1_role: cbcart_chat_object.cbcart_chat_account1_role,
        cbcart_chat_account1_avtar: cbcart_chat_object.cbcart_chat_account1_avtar_url,
        cbcart_chat_account2_enable:cbcart_chat_object.cbcart_is_ac_2,
        cbcart_chat_account2_name: cbcart_chat_object.cbcart_chat_account2_name,
        cbcart_chat_account2_namber:cbcart_chat_object.cbcart_chat_account2_number,
        cbcart_chat_account2_role: cbcart_chat_object.cbcart_chat_account2_role,
        cbcart_chat_account2_avtar: cbcart_chat_object.cbcart_chat_account2_avtar_url,
        cbcart_chat_account3_enable:cbcart_chat_object.cbcart_is_ac_3,
        cbcart_chat_account3_name: cbcart_chat_object.cbcart_chat_account3_name,
        cbcart_chat_account3_namber: cbcart_chat_object.cbcart_chat_account3_number,
        cbcart_chat_account3_role: cbcart_chat_object.cbcart_chat_account3_role,
        cbcart_chat_account3_avtar: cbcart_chat_object.cbcart_chat_account3_avtar_url,
        cbcart_predefine_text: cbcart_chat_object.cbcart_predefine_text,
    }

    let myElm = document.createElement("div");	// Create a new element
    myElm.innerHTML = `<div class="cbcart-icon-box cbcart-hide">
    <a class="cbcart-icon-url" href="#" target="_blank">
    <div id="cbcart-icon" class="cbcart-icon" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Send direct whatsapp message">
    <img class="cbcart-icon-img" src="#" >
    <span class="cbcart-chat-text">Chat With Us</span>
    <span class="cbcart-tooltip-text"></span>
    </div>
    </a>
    <div class="cbcart-widget-popup cbcart-hide">
        <div class="cbcart-popup-box">
            <div class="cbcart-widget-popup-header">
                <div class="cbcart-widget-close">x</div>
                <div>Need Help? Chat with us</div>
                <div><small>Click one of our representative below</small></div>
            </div>
            <div class="container-fluid cbcart-widget-popup-body">
                
            </div>
        </div>
        </div>
    </div>`;
    document.body.appendChild(myElm);
    if(cbcart_chat_object.cbcart_ispublish == 1){
        jQuery(".cbcart-icon-box").removeClass("cbcart-hide");
    }else{
        jQuery(".cbcart-icon-box").addClass("cbcart-hide");
    }
    if(cbcart_chat_object.cbcart_widget_position == 'left'){
        jQuery(".cbcart-icon-box").addClass("cbcart-left");
        jQuery(".cbcart-icon-box").removeClass("cbcart-right");
    }else if(cbcart_chat_object.cbcart_widget_position == 'right'){
        jQuery(".cbcart-icon-box").addClass("cbcart-right");
        jQuery(".cbcart-icon-box").removeClass("cbcart-left");
    }else{
        jQuery(".cbcart-icon-box").addClass("cbcart-left");
        jQuery(".cbcart-icon-box").removeClass("cbcart-right");
    }
    if(cbcart_chat_object.cbcart_widget_type == 'onlyicon'){
        jQuery(".cbcart-chat-text").addClass("cbcart-hide");
        jQuery(".cbcart-icon-box").addClass("cbcart-onlyicon");
        jQuery(".cbcart-icon").removeClass("cbcart-icon-with-text");
    }else{
        jQuery(".cbcart-chat-text").removeClass("cbcart-hide");
        jQuery(".cbcart-icon-box").removeClass("cbcart-onlyicon");
        jQuery(".cbcart-icon").addClass("cbcart-icon-with-text");
    }
    jQuery(".cbcart-chat-text").text(cbcart_chat_object.cbcart_widget_text);

    jQuery(".cbcart-tooltip-text").text(cbcart_chat_object.cbcart_tooltiptext);
    if(cbcart_chat_object.cbcart_icon_type == "cbcart_default"){
        jQuery(".cbcart-icon-img").attr('src', cbcart_chat_object.cbcart_icon + ".png");
    }else{
        jQuery(".cbcart-icon-img").attr('src',"" + cbcart_chat_object.cbcart_icon_url);
    }
    var activeAccount = 0;
    var oneLink;
    if(cbcart_chat_setting.cbcart_chat_account1_enable == "1"){
        jQuery(".cbcart-widget-popup-body").append(`
            <a href="#" target="_blank" class="cbcart-profile-widget account-1">
                <div><img src="#"></div>
                <div>
                    <div class="cbcart-profile-title">`+ cbcart_chat_setting.cbcart_chat_account1_name + `</div>
                    <div class="cbcart-profile-position">`+ cbcart_chat_setting.cbcart_chat_account1_role + `</div>
                </div>
            </a>
`       );
        jQuery(".account-1").attr("href","https://wa.me/"+ cbcart_chat_setting.cbcart_chat_account1_namber + "?text=" + cbcart_chat_setting.cbcart_predefine_text);
        if(cbcart_chat_setting.cbcart_chat_account1_avtar == null ||cbcart_chat_setting.cbcart_chat_account1_avtar == ""){
            jQuery(".account-1 img").attr("src",cbcart_chat_object.cbcart_profile_img_url);
        }else{
            jQuery(".account-1 img").attr("src",cbcart_chat_setting.cbcart_chat_account1_avtar);
        }
        activeAccount++;
        oneLink = "https://wa.me/"+ cbcart_chat_setting.cbcart_chat_account1_namber + "?text=" + cbcart_chat_setting.cbcart_predefine_text;
    }
    if(cbcart_chat_setting.cbcart_chat_account2_enable == "1"){
        jQuery(".cbcart-widget-popup-body").append(`
            <a href="#" target="_blank" class="cbcart-profile-widget account-2">
                <div><img src="#"></div>
                <div>
                    <div class="cbcart-profile-title">`+ cbcart_chat_setting.cbcart_chat_account2_name + `</div>
                    <div class="cbcart-profile-position">`+ cbcart_chat_setting.cbcart_chat_account2_role + `</div>
                </div>
            </a>
`       );
        jQuery(".account-2").attr("href","https://wa.me/"+ cbcart_chat_setting.cbcart_chat_account2_namber + "?text=" + cbcart_chat_setting.cbcart_predefine_text);
        if(cbcart_chat_setting.cbcart_chat_account2_avtar == null ||cbcart_chat_setting.cbcart_chat_account2_avtar == ""){
            jQuery(".account-2 img").attr("src",cbcart_chat_object.cbcart_profile_img_url);
        }else{
            jQuery(".account-2 img").attr("src",cbcart_chat_setting.cbcart_chat_account2_avtar);
        }
        activeAccount++;
        oneLink = "https://wa.me/"+ cbcart_chat_setting.cbcart_chat_account1_namber + "?text=" + cbcart_chat_setting.cbcart_predefine_text;
    }
    if(cbcart_chat_setting.cbcart_chat_account3_enable == "1"){
        jQuery(".cbcart-widget-popup-body").append(`
            <a href="#" target="_blank" class="cbcart-profile-widget account-3">
                <div><img src="#"></div>
                <div>
                    <div class="cbcart-profile-title">`+ cbcart_chat_setting.cbcart_chat_account3_name + `</div>
                    <div class="cbcart-profile-position">`+ cbcart_chat_setting.cbcart_chat_account3_role + `</div>
                </div>
            </a>
`       );
        jQuery(".account-3").attr("href","https://wa.me/"+ cbcart_chat_setting.cbcart_chat_account3_namber + "?text=" + cbcart_chat_setting.cbcart_predefine_text);
        if(cbcart_chat_setting.cbcart_chat_account3_avtar == null ||cbcart_chat_setting.cbcart_chat_account3_avtar == ""){
            jQuery(".account-3 img").attr("src",cbcart_chat_object.cbcart_profile_img_url);
        }else{
            jQuery(".account-3 img").attr("src",cbcart_chat_setting.cbcart_chat_account3_avtar);
        }
        activeAccount++;
        oneLink = "https://wa.me/"+ cbcart_chat_setting.cbcart_chat_account1_namber + "?text=" + cbcart_chat_setting.cbcart_predefine_text;
    }
    if(activeAccount == "1"){
        jQuery(".cbcart-icon-url").attr("href",oneLink);
        jQuery(".cbcart-widget-popup").remove();
    }
    if(activeAccount > 1){
        jQuery(".cbcart-icon-url").removeAttr("target");
    }
    setTimeout(function(){
        jQuery(".cbcart-widget-popup").removeClass("cbcart-hide");
        jQuery(".cbcart-popup-box").css("height","100px");
        jQuery(".cbcart-popup-box").animate({height: "305px",opacity: "1"},500);
    },2000);
    jQuery(".cbcart-icon-box").on('click',function(){
        jQuery(".cbcart-widget-popup").show();
        jQuery(".cbcart-widget-popup").toggleClass("cbcart-hide");
        jQuery(".cbcart-popup-box").css("height","100px");
        jQuery(".cbcart-popup-box").animate({height: "305px",opacity: "1"},500);
    });
    jQuery(".cbcart-widget-close").on('click',function(){
        jQuery(".cbcart-widget-popup").addClass("cbcart-hide");
        jQuery(".cbcart-popup-box").css("height","100px");
        jQuery(".cbcart-popup-box").animate({height: "0",opacity: "0"},500);
        return false;
    })
});

})( jQuery );