(function ($) {
    "use strict";


    jQuery(document).on("ready",function ($) {
        jQuery( "#cbcart_collapse" ).on('click',function() {
            jQuery("#whaso_expand").toggleClass("d-none");
            if(jQuery("#whaso_expand").hasClass("d-none")){
                jQuery( "#cbcart_collapse" ).closest(".cbcart_account_status")
                    .find("i")
                    .removeClass("fa-angle-up")
                    .addClass("fa-angle-down ");
            }else {
                jQuery( "#cbcart_collapse" ).closest(".cbcart_account_status")
                    .find("i")
                    .removeClass("fa-angle-down")
                    .addClass("fa-angle-up ");
            }
        });
        //eary capture code
        if (jQuery('#cbcart_capture_modalheading').length) {
            jQuery('#cbcart_capture_modalheading').keyup(function() {
                var cbcart_selectedtext = jQuery(this).val();
                document.getElementById('cbcart_modal_heading').innerHTML=cbcart_selectedtext;
            });

        }
        if (jQuery('#cbcart_modal_headingcolor').length) {
            var cbcart_selectedColor = jQuery('#cbcart_modal_headingcolor').val();
            document.getElementById('cbcart_modal_heading').style.color=cbcart_selectedColor;
            jQuery('#cbcart_modal_headingcolor').on('change', function(){
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_heading').style.color=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_capture_modal_text').length) {
            jQuery('#cbcart_capture_modal_text').keyup(function() {
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_text').innerHTML=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_modal_modal_text_color').length) {
            var cbcart_selectedColor = jQuery('#cbcart_modal_modal_text_color').val();
            document.getElementById('cbcart_modal_text').style.color=cbcart_selectedColor;
            jQuery('#cbcart_modal_modal_text_color').on('change', function(){
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_text').style.color=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_capture_placeholder').length) {
            jQuery('#cbcart_capture_placeholder').keyup(function() {
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_mobileno').placeholder=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_capture_addtocart_text').length) {
            jQuery('#cbcart_capture_addtocart_text').keyup(function() {
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_button').innerHTML=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_buttontext_color').length) {
            var cbcart_selectedColor = jQuery('#cbcart_buttontext_color').val();
            document.getElementById('cbcart_modal_button').style.color=cbcart_selectedColor;
            jQuery('#cbcart_buttontext_color').on('change', function(){
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_button').style.color=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_button_color').length) {
            var cbcart_selectedColor = jQuery('#cbcart_button_color').val();
            document.getElementById('cbcart_modal_button').style.backgroundColor=cbcart_selectedColor;
            jQuery('#cbcart_button_color').on('change', function(){
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_button').style.backgroundColor=cbcart_selectedColor;
            });
        }
        if (jQuery('#cbcart_consent_text').length) {
            jQuery('#cbcart_consent_text').keyup(function() {
                var cbcart_selectedColor = jQuery(this).val();
                document.getElementById('cbcart_modal_checkbox_text').innerHTML=cbcart_selectedColor;
            });
        }
        //eary capture end
        jQuery("#cbcart_status1").addClass("d-none");
        jQuery("#cbcart_status2").addClass("d-none");
        jQuery("#cbcart_status3").addClass("d-none");
        jQuery("#cbcart_status4").addClass("d-none");
        jQuery("#cbcart_status5").addClass("d-none");
        jQuery("#cbcart_status1_cf7_1").addClass("d-none");
        jQuery("#cbcart_status1_cf7_2").addClass("d-none");
        jQuery("#cbcart_status1_order_admin").addClass("d-none");
        jQuery("#cbcart_status1_order_customer").addClass("d-none");
        var element = document.getElementById("cbcart_resend_btn");
        if (typeof (element) != 'undefined' && element != null) {
            countdown('clock', 0, 9);

        } else {
        }
        jQuery("#cbcart_email").keyup(function () {
            var cbcart_email = jQuery("#cbcart_email").val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(cbcart_email)) {
                var cbcart_ele = document.getElementById("cbcart_error_email");
                if (cbcart_ele) {
                    document.getElementById("cbcart_error_email").style.display = "block";
                }
                jQuery("#cbcart_getbutton").addClass("cbcart_btn-theme_border");
                jQuery("#cbcart_getbutton").removeClass("cbcart_btn-theme");
            } else {
                var cbcart_ele = document.getElementById("cbcart_error_email");
                if (cbcart_ele) {
                    document.getElementById("cbcart_error_email").style.display = "none";
                }
                jQuery("#cbcart_getbutton").removeClass("cbcart_btn-theme_border");
                jQuery("#cbcart_getbutton").addClass("cbcart_btn-theme");
            }
        });
        jQuery("#cbcart_otp1").keyup(function () {
            var cbcart_otp1 = jQuery("#cbcart_otp1").val();
            if (cbcart_otp1 != "") {
                jQuery("#cbcart_otp2").focus();
            }
        });
        jQuery("#cbcart_otp2").keyup(function () {
            var cbcart_otp2 = jQuery("#cbcart_otp2").val();
            if (cbcart_otp2 != "") {
                jQuery("#cbcart_otp3").focus();
            }
        });
        jQuery("#cbcart_otp3").keyup(function () {
            var cbcart_otp3 = jQuery("#cbcart_otp3").val();
            if (cbcart_otp3 != "") {
                jQuery("#cbcart_otp4").focus();
            }
        });
        checkdnd();
        checkac();

        // function to check mobile number length must be less than 12
        jQuery("#cbcart_mobileno").keyup(function () {
            var cbcart_mobileno = jQuery("#cbcart_mobileno").val();
            cbcart_mobileno = cbcart_mobileno.length;
            if (cbcart_mobileno < 12 || cbcart_mobileno > 159) {
                jQuery("#cbcart_mobile_error").removeClass("d-none");
                var cbcart_ele = document.getElementById("cbcart_mobile_error");
                if (cbcart_ele) {
                    document.getElementById("cbcart_mobile_error").style.display = "block";
                }
                return false;
            } else {
                jQuery("#cbcart_mobile_error").addClass("d-none");
                var cbcart_ele = document.getElementById("cbcart_mobile_error");
                if (cbcart_ele) {
                    document.getElementById("cbcart_mobile_error").style.display = "none";
                }
                return true;
            }
        });

        jQuery("#cbcart_wabaid").keyup(function () {
            var cbcart_wabaid = jQuery("#cbcart_wabaid").val();
            cbcart_wabaid = cbcart_wabaid.length;
            if (cbcart_wabaid < 15 || cbcart_wabaid > 15) {
                jQuery("#cbcart_wabaid_error").removeClass("d-none");
                var cbcart_ele = document.getElementById("cbcart_wabaid_error");
                if (cbcart_ele) {
                    document.getElementById("cbcart_wabaid_error").style.display = "block";
                }
                return false;
            } else {
                jQuery("#cbcart_wabaid_error").addClass("d-none");
                var cbcart_ele = document.getElementById("cbcart_wabaid_error");
                if (cbcart_ele) {
                    document.getElementById("cbcart_wabaid_error").style.display = "none";
                }
                return true;
            }
        });
        jQuery("#cbcart_phoneid").keyup(function () {
            var cbcart_phoneid = jQuery("#cbcart_phoneid").val();
            cbcart_phoneid = cbcart_phoneid.length;
            if (cbcart_phoneid < 15 || cbcart_phoneid > 15) {
                jQuery("#cbcart_phonenoid_error").removeClass("d-none");
                var cbcart_ele = document.getElementById("cbcart_phonenoid_error");
                if (cbcart_ele) {
                    document.getElementById("cbcart_phonenoid_error").style.display = "block";
                }
                return false;
            } else {
                jQuery("#cbcart_phonenoid_error").addClass("d-none");
                var cbcart_ele = document.getElementById("cbcart_phonenoid_error");
                if (cbcart_ele) {
                    document.getElementById("cbcart_phonenoid_error").style.display = "none";
                }
                return true;
            }
        });


        var cbcart_element1 = jQuery("#cbcart_email").val();
        if (cbcart_element1 != "") {
            jQuery("#cbcart_alert").css("display", "block");
            jQuery("#cbcart_usernameform").removeClass("d-none");
            jQuery("#cbcart_emailform").addClass("d-none");

        } else {
            jQuery("#cbcart_alert").css("display", "none");
            jQuery("#cbcart_emailform").removeClass("d-none");
            jQuery("#cbcart_usernameform").addClass("d-none");
        }

        // function to check customer checkbox is checked or not
        jQuery("#cbcart_customer_checkbox").change(function () {
            if (this.checked) {
                jQuery("#cbcart_displayCustomerMsgDiv").removeClass("d-none");
            } else {
                jQuery("#cbcart_displayCustomerMsgDiv").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_customer_checkbox").prop("checked") === true) {
            jQuery("#cbcart_displayCustomerMsgDiv").removeClass("d-none");
        } else {
            jQuery("#cbcart_displayCustomerMsgDiv").addClass("d-none");
        }

        // function to check customer checkbox is checked or not
        jQuery("#cbcart_cf7_checkbox").change(function () {
            if (this.checked) {
                jQuery("#cbcart_displayCf7Div").removeClass("d-none");
            } else {
                jQuery("#cbcart_displayCf7Div").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_cf7_checkbox").prop("checked") === true) {
            jQuery("#cbcart_displayCf7Div").removeClass("d-none");
        } else {
            jQuery("#cbcart_displayCf7Div").addClass("d-none");
        }

        // function to check customer checkbox is checked or not
        jQuery("#cbcart_cf7customer_checkbox").change(function () {
            if (this.checked) {
                jQuery("#cbcart_displayCf7Div2").removeClass("d-none");
            } else {
                jQuery("#cbcart_displayCf7Div2").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_cf7customer_checkbox").prop("checked") === true) {
            jQuery("#cbcart_displayCf7Div2").removeClass("d-none");
        } else {
            jQuery("#cbcart_displayCf7Div2").addClass("d-none");
        }

        // function to check customer checkbox is checked or not
        jQuery("#cbcart_admin_checkbox").change(function () {
            if (this.checked) {
                jQuery("#cbcart_displayAdminMsgDiv").removeClass("d-none");
            } else {
                jQuery("#cbcart_displayAdminMsgDiv").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_admin_checkbox").prop("checked") === true) {
            jQuery("#cbcart_displayAdminMsgDiv").removeClass("d-none");
        } else {
            jQuery("#cbcart_displayAdminMsgDiv").addClass("d-none");
        }
        //function to check click to chat account 1
        jQuery("#cbcart_is_ac_1").change(function () {
            if (this.checked) {
                jQuery("#cbcart_display_ac_1").removeClass("d-none");
            } else {
                jQuery("#cbcart_display_ac_1").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_is_ac_1").prop("checked") === true) {
            jQuery("#cbcart_display_ac_1").removeClass("d-none");
        } else {
            jQuery("#cbcart_display_ac_1").addClass("d-none");
        }

        //function to check click to chat account 1
        jQuery("#cbcart_is_ac_2").change(function () {
            if (this.checked) {
                jQuery("#cbcart_display_ac_2").removeClass("d-none");
            } else {
                jQuery("#cbcart_display_ac_2").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_is_ac_2").prop("checked") === true) {
            jQuery("#cbcart_display_ac_2").removeClass("d-none");
        } else {
            jQuery("#cbcart_display_ac_2").addClass("d-none");
        }

        //function to check click to chat account 1
        jQuery("#cbcart_is_ac_3").change(function () {
            if (this.checked) {
                jQuery("#cbcart_display_ac_3").removeClass("d-none");
            } else {
                jQuery("#cbcart_display_ac_3").addClass("d-none");
            }
        });
        if (jQuery("#cbcart_is_ac_3").prop("checked") === true) {
            jQuery("#cbcart_display_ac_3").removeClass("d-none");
        } else {
            jQuery("#cbcart_display_ac_3").addClass("d-none");
        }

        // function to switch between nav bar tabs
        jQuery("ul.nav-tabs a").on('click',function (e) {
            e.preventDefault();
            jQuery(this).tab("show");
        });

        //for tooltip
        jQuery(function () {
            jQuery('[data-toggle="tooltip"]').tooltip();
        });
//dnd click
        jQuery("#cbcart_dnd_enable").on('click',function () {
            checkdnd();
        });

        function checkdnd() {
            if (jQuery("#cbcart_dnd_enable").prop("checked") === true) {
                jQuery("#cbcart_dnd_to").prop("disabled", false);
                jQuery("#cbcart_dnd_from").prop("disabled", false);
                jQuery(".cbcart_godndMsg").css("display", "");
                jQuery(".cbcart_notdndMsg").css("display", "none");
            } else {
                jQuery("#cbcart_dnd_to").prop("disabled", true);
                jQuery("#cbcart_dnd_from").prop("disabled", true);
                jQuery(".cbcart_notdndMsg").css("display", "");
                jQuery(".cbcart_godndMsg").css("display", "none");
            }
        }

        //ac click
        jQuery("#cbcart_ac_enable").on('click',function () {
            checkac();
        });


        function checkac() {
            if (jQuery("#cbcart_ac_enable").prop("checked") === true) {
                jQuery("#cbcart_trigger_setting_1").prop("disabled", false);
                jQuery("#cbcart_trigger_time1").prop("disabled", false);

            } else {
                jQuery("#cbcart_trigger_setting_1").prop("disabled", true);
                jQuery("#cbcart_trigger_time1").prop("disabled", true);

            }
        }

    });

    jQuery(".form-content").on("submit",function () {
        var values = [];
        jQuery(".cbcart_messages-box").each(function () {
            var int = jQuery(this).find("input").val();
            var val = jQuery(this).find("select").val();
            if (int != undefined && int != null && int != "") {
                if (val === "select_hour") {
                    int = int * 60;
                } else if (val === "select_day") {
                    int = int * 1440;
                }
                values.push(parseInt(int));
            }
        });
        for (var cbcart_i = 0; cbcart_i < values.length; cbcart_i++) {
            for (var cbcart_j = 0; cbcart_j < values.length; cbcart_j++) {
                if (cbcart_i <= cbcart_j) {
                    if (values[cbcart_i] > values[cbcart_j]) {
                        alert("All schedule time are greater then previous values");
                        return false;
                    }
                }
            }
        }
    });
})(jQuery);


/**
 * to block special character from string
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function blockSpecialChar(e) {
    var k;
    document.all ? (k = e.keyCode) : (k = e.which);
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k === 8 || k === 32 || (k >= 48 && k <= 57) || k === 39);
}

function activeTab(tab){
    jQuery('.nav-tabs a[href="#' + tab + '"]').tab('show');
}

/**
 * function for placeholder input selection
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function getInputSelection(el) {
    var start = 0, end = 0, normalizedValue, range, textInputRange, len, endRange;
    if (typeof el.selectionStart === "number" && typeof el.selectionEnd === "number") {
        start = el.selectionStart;
        end = el.selectionEnd;
    } else {
        range = document.selection.createRange();
        if (range && range.parentElement() === el) {
            len = el.value.length;
            normalizedValue = el.value.replace(/\n/g, "\n");
            textInputRange = el.createTextRange();
            textInputRange.moveToBookmark(range.getBookmark());
            endRange = el.createTextRange();
            endRange.collapse(false);
            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                start = end = len;
            } else {
                start = -textInputRange.moveStart("character", -len);
                start += normalizedValue.slice(0, start).split("\r\n").length - 1;
                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                    end = len;
                } else {
                    end = -textInputRange.moveEnd("character", -len);
                    end += normalizedValue.slice(0, end).split("\r\n").length - 1;
                }
            }
        }
    }
    return {
        start: start, end: end,
    };
}

/**
 * function to move placeholder
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function offsetToRangeCharacterMove(el, offset) {
    return offset - (el.value.slice(0, offset).split("\n").length - 1);
}

/**
 * to move characters and check text range
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function setSelection(el, start, end) {
    if (typeof el.selectionStart === "number" && typeof el.selectionEnd === "number") {
        el.selectionStart = start;
        el.selectionEnd = end;
    } else if (typeof el.createTextRange != "undefined") {
        var range = el.createTextRange();
        var startCharMove = offsetToRangeCharacterMove(el, start);
        range.collapse(true);
        if (start === end) {
            range.move("character", startCharMove);
        } else {
            range.moveEnd("character", offsetToRangeCharacterMove(el, end));
            range.moveStart("character", startCharMove);
        }
        range.select();
    }
}

/**
 * function to copy text at cartel
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function insertTextAtCaret(el, text) {
    var pos = getInputSelection(el).end;
    var newPos = pos + text.length;
    var val = el.value;
    el.value = val.slice(0, pos) + text + val.slice(pos);
    setSelection(el, newPos, newPos);
}

/**
 * tfunction to add placeholder at particular textarea
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function add_placeholder(text_area_id, placeholder) {
    var textarea = document.getElementById(text_area_id);
    textarea.focus();
    insertTextAtCaret(textarea, placeholder);
    return false;
}

/**
 * function to get messages and display error message if null
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function cbcart_submitfunction() {
    var cbcart_owner_message = document.getElementById("cbcart_message").value;
    var cbcart_customer_maessage = document.getElementById("cbcart_customer_message").value;
    var cbcart_word = "{#var#}";
    if (cbcart_owner_message.indexOf(cbcart_word) != -1) {
        event.preventDefault ? event.preventDefault() : (event.returnValue = false);
        document.getElementById("cbcart_message_variable_error").style.display = "block";
        return false;
    } else if (cbcart_customer_maessage.indexOf(cbcart_word) != -1) {
        event.preventDefault ? event.preventDefault() : (event.returnValue = false);
        document.getElementById("cbcart_message_variable_error").style.display = "block";
        document.getElementById("cbcart_message_variable_error").style.display = "none";
        return false;
    } else {
        document.getElementById("cbcart_message_variable_error").style.display = "none";
        return true;
    }
}

/**
 * function to check for form validation
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function cbcart_FormValidation() {
    var txtmobile = document.getElementById("cbcart_admin_mobile").value;
    var phoneno = /^[0-9]*$/;
    if (txtmobile.length < 5 || txtmobile.length > 15) {
        document.getElementById("cbcart_phonemsg").innerHTML = "Number must be atleast 5 digits";
        return false;
    } else {
        document.getElementById("cbcart_phonemsg").innerHTML = "";
        return true;
    }
    document.forms["cbcart_form1"].on("submit");
}

function cbcart_otpvalidation() {
    var otp1 = document.getElementById("cbcart_otp1").value;
    var otp2 = document.getElementById("cbcart_otp2").value;
    var otp3 = document.getElementById("cbcart_otp3").value;
    var otp4 = document.getElementById("cbcart_otp4").value;

    var otp = otp1.concat(otp2, otp3, otp4);
    jQuery("#cbcart_otp").val(otp);
}

function cbcart_show_status() {
    jQuery("#cbcart_status1").removeClass("d-none");
    return false;
}

function cbcart_show_status2() {
    jQuery("#cbcart_status2").removeClass("d-none");
}

function cbcart_show_status3() {
    jQuery("#cbcart_status3").removeClass("d-none");
}

function cbcart_show_status4() {
    jQuery("#cbcart_status4").removeClass("d-none");
}

function cbcart_show_status5() {
    jQuery("#cbcart_status5").removeClass("d-none");
}

function cbcart_show_status_order_admin() {
    jQuery("#cbcart_status1_order_admin").removeClass("d-none");
}

function cbcart_show_status_order_customer() {
    jQuery("#cbcart_status1_order_customer").removeClass("d-none");
}

function cbcart_show_status_cf7_1() {
    jQuery("#cbcart_status1_cf7_1").removeClass("d-none");
}

function cbcart_show_status_cf7_2() {
    jQuery("#cbcart_status1_cf7_2").removeClass("d-none");
}

/**
 * function to check if number or not and prevent paste event
 *
 * @since    1.0.0
 * @version    3.0.4
 */
function isNumber(evt) {
    var theEvent = evt || window.event;
    if (theEvent.type === "paste") {
        theEvent.returnValue = false;
    } else {
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

function getApprovedSMSTemplate1() {
    var copyText = document.getElementById("myText2");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    var toolTipText = document.getElementById("msgCopied1");
    document.getElementById("msgCopied1").innerHTML = "Message Copied!";
    toolTipText.classList.add("show");
    document.execCommand("copy");
    setTimeout(function () {
        toolTipText.classList.remove("show");
    }, 1000);
}

jQuery(document).on("ready",function () {
    var cbcart_i = 0;
    jQuery(".cbcart_messages-box input[type='checkbox']").each(function (index) {
        if (jQuery(this).is(":checked") === true) {
            jQuery(this)
                .closest(".cbcart_settings_card")
                .find(".cbcart-card-body")
                .removeClass("d-none");
        }else{
            jQuery(this)
                .closest(".cbcart_settings_card")
                .find(".cbcart-card-body")
                .addClass("d-none");
        }
        cbcart_i++;
    });
    jQuery(".cbcart_messages-box input[type='checkbox']").change(function () {
        if (jQuery(this).is(":checked") === true) {
            jQuery(this)
                .closest(".cbcart_messages-box")
                .find('input[type="text"]')
                .removeAttr("readonly");
            jQuery(this)
                .closest(".cbcart_messages-box")
                .find("select")
                .removeAttr("readonly");
        } else {
            jQuery(this)
                .closest(".cbcart_messages-box")
                .find('input[type="text"]')
                .attr("readonly", "readonly");
            jQuery(this)
                .closest(".cbcart_messages-box")
                .find("select")
                .attr("readonly", "readonly");
        }
        var cbcart_i = 0;
        jQuery(".cbcart_messages-box input[type='checkbox']").each(function (index) {
            if (jQuery(this).is(":checked") === true) {
                if (cbcart_i != index) {
                    jQuery(this)
                        .closest(".cbcart_settings_card")
                        .find(".cbcart-card-body")
                        .addClass("d-none");
                    jQuery(this).prop("checked", false);
                    alert("Not Allowed. Please select in sequence");
                    jQuery(this)
                        .closest(".cbcart_messages-box")
                        .find("textarea")
                        .attr("readonly", "readonly");
                    jQuery(this)
                        .closest(".cbcart_messages-box")
                        .find('input[type="text"]')
                        .attr("readonly", "readonly");
                    jQuery(this)
                        .closest(".cbcart_messages-box")
                        .find("select")
                        .attr("readonly", "readonly");
                }
                cbcart_i++;
            }else{
                if (cbcart_i != index) {
                    jQuery(this)
                        .closest(".cbcart_settings_card")
                        .find(".cbcart-card-body")
                        .addClass("d-none");
                }
            }
        });
        if (jQuery(this).is(":checked") === true) {
            jQuery(this)
                .closest(".cbcart_settings_card")
                .find(".cbcart-card-body")
                .removeClass("d-none");
        }else{
            jQuery(this)
                .closest(".cbcart_settings_card")
                .find(".cbcart-card-body")
                .addClass("d-none");
        }
    });

    jQuery(".cbcart_chat_card input[type='radio']").change(function () {
        cbcart_check_widget_type_radio();
        cbcart_check_radio_icon_default();
    });
    cbcart_check_widget_type_radio();
    function cbcart_check_widget_type_radio(){
        if (jQuery('input[name=cbcart_only_icon]').is(":checked") === true) {
            jQuery('input:radio[name=cbcart_only_icon]').parent().removeClass('cbcart_border');
            jQuery('input:radio[name=cbcart_only_icon]').parent().removeClass('shadow');
            jQuery("input[type='radio'][name='cbcart_only_icon']:checked").parent().addClass('shadow');
            jQuery("input[type='radio'][name='cbcart_only_icon']:checked").parent().addClass('cbcart_border');

            var cbcart_i=jQuery("input[type='radio'][name='cbcart_only_icon']:checked").val();
            if(cbcart_i==="onlyicon"){
                jQuery("#cbcart_widget_text").attr("readonly", "readonly");
                jQuery("#cbcart_widget_tooltip").removeClass('d-none');

                for(cbcart_i=1;cbcart_i<9; cbcart_i++){
                    jQuery('input[value=cbcart-icon-'+cbcart_i+']').parent().removeClass('opacity-50');
                    jQuery('input[name=cbcart_icon_set]').attr("disabled",false);

                }
            }
            else {
                jQuery("#cbcart_widget_text").removeAttr("readonly");
                jQuery("#cbcart_widget_tooltip").addClass('d-none');
                for(cbcart_i=2;cbcart_i<9; cbcart_i++){
                    jQuery('input[value=cbcart-icon-'+cbcart_i+']').parent().removeClass('cbcart_border');
                    jQuery('input[value=cbcart-icon-'+cbcart_i+']').parent().addClass('opacity-50');
                    jQuery('input[name=cbcart_icon_set]').attr("disabled",true);
                }
            }
        }
    }
    jQuery(".cbcart_chat_icon_card input[type='radio']").change(function () {
        if (jQuery(this).is(":checked") === true) {
            jQuery('input:radio[name=' + this.name + ']').parent().removeClass('cbcart_border');
            jQuery('input:radio[name=' + this.name + ']').parent().removeClass('shadow');
            jQuery(this).parent().addClass('shadow');
            jQuery(this).parent().addClass('cbcart_border');
        }
    });
    jQuery(".cbcart_icon_type_div input[type='radio']").change(function () {
        cbcart_check_widget_type_radio();
        cbcart_check_radio_icon_default();

    });
    cbcart_check_radio_icon_default();
    function cbcart_check_radio_icon_default(){
        if (jQuery('input[name=cbcart_icon_type_radio]').is(":checked") === true) {
            var cbcart_i=jQuery("input[type='radio'][name='cbcart_icon_type_radio']:checked").val();
            if(cbcart_i==="cbcart_default"){
                jQuery("#cbcart_icon_link").attr("readonly", "readonly");
                jQuery("#cbcart_icon_type_tooltip").removeClass('d-none');
                jQuery('input[name=cbcart_icon_set]').attr("disabled",false);
                jQuery('input[name=cbcart_icon_set]').parent().removeClass('opacity-50');


                var cbcart_i=jQuery("input[type='radio'][name='cbcart_only_icon']:checked").val();
                if(cbcart_i==="onlyicon"){
                    jQuery("#cbcart_widget_text").attr("readonly", "readonly");
                    jQuery("#cbcart_widget_tooltip").removeClass('d-none');
                    var cbcart_J;
                    for(cbcart_J=2;cbcart_J<9; cbcart_J++){
                        jQuery('input[value=cbcart-icon-'+cbcart_J+']').parent().removeClass('opacity-50');
                        jQuery('input[name=cbcart_icon_set]').attr("disabled",false);
                    }
                }
                else {
                    jQuery("#cbcart_widget_text").removeAttr("readonly");
                    jQuery("#cbcart_widget_tooltip").addClass('d-none');
                    var cbcart_J;
                    for(cbcart_J=2;cbcart_J<9; cbcart_J++){
                        jQuery('input[value=cbcart-icon-'+cbcart_J+']').parent().removeClass('cbcart_border');
                        jQuery('input[value=cbcart-icon-'+cbcart_J+']').parent().removeClass('shadow');
                        jQuery('input[value=cbcart-icon-'+cbcart_J+']').parent().addClass('opacity-50');
                        jQuery('input[name=cbcart_icon_set]').attr("disabled",true);
                    }
                    jQuery('input[value=cbcart-icon-1]').parent().addClass('shadow');
                    jQuery('input[value=cbcart-icon-1]').parent().addClass('cbcart_border');
                    jQuery('input[value=cbcart-icon-1]').attr("checked","checked");
                    jQuery('input[value=cbcart-icon-1]').attr("disabled",true);
                }
            }
            else {
                jQuery('input[name=cbcart_icon_set]').attr("disabled",true);
                jQuery('input[name=cbcart_icon_set]').parent().removeClass('shadow');
                jQuery('input[name=cbcart_icon_set]').parent().removeClass('cbcart_border');
                jQuery('input[name=cbcart_icon_set]').parent().addClass('opacity-50');
                jQuery("#cbcart_icon_link").removeAttr("readonly");
                jQuery("#cbcart_icon_type_tooltip").addClass('d-none');

            }
        }
}
});
jQuery(document).on("ready",function () {
    jQuery("#cbcart_reporttable").DataTable({
        "searching": false, order: [[0, "desc"]],
    });
    jQuery("#cbcart_ordertable").DataTable({
        "searching": false, order: [[0, "desc"]],
    });
    jQuery("#cbcart_dashboardtable").DataTable({
        order: [[0, "desc"]],
    });
});


function countdown(element, minutes, seconds) {
    document.getElementById("cbcart_resend_btn").style.display = "none";
    // set time for the particular countdown
    var time = minutes * 60 + seconds;
    var interval = setInterval(function () {
        var el = document.getElementById(element);
        // if the time is 0 then end the counter
        if (time <= 0) {
            var text = "";
            el.innerHTML = text;
            document.getElementById("cbcart_resend_btn").style.display = "block";
            clearInterval(interval);
            return;
        }
        var minutes = Math.floor(time / 60);
        if (minutes < 10) minutes = "0" + minutes;
        var seconds = time % 60;
        if (seconds < 10) seconds = "0" + seconds;
        var text = 'Resend Code in ' + minutes + ':' + seconds;
        el.innerHTML = text;
        time--;
    }, 1000);
}

function cbcart_backbtn() {
    jQuery("#cbcart_alert").css("display", "none");
    jQuery("#cbcart_emailform").removeClass("d-none");
    jQuery("#cbcart_usernameform").addClass("d-none");
}
function cbcart_copy(){
    // Get the text field
    var copyText = document.getElementById("cbcart_webhook");
    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    var cbcart_tooltip = document.getElementById("cbcart-Tooltip");
    cbcart_tooltip.innerHTML = "Copied";
}

function cbcart_outFunc() {
    var cbcart_tooltip = document.getElementById("cbcart-Tooltip");
    cbcart_tooltip.innerHTML = "Copy to clipboard";

}
function cbcart_reset_alert() {
    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        var proceed1 = confirm("This plugin will reset. please confirm to continue.");
        if (proceed1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

jQuery(document).on("ready",function () {
    var cbcart_check_customise_div = "";
    var cbcart_ele = document.getElementById("cbcart_check_customise_div");
    if (cbcart_ele) {
        cbcart_check_customise_div = cbcart_ele.textContent;
    }
    if (cbcart_check_customise_div == "1") {
        jQuery("#cbcart_cutomise_div").removeClass("d-none");
        jQuery("#cbcart_select_div").addClass("d-none");
    } else {
        jQuery("#cbcart_cutomise_div").addClass("d-none");
        jQuery("#cbcart_select_div").removeClass("d-none");
    }
    var cbcart_messageText = "";
    var cbcart_ele2 = document.getElementById("cbcart_st_body_text");
    if (cbcart_ele2) {
        cbcart_messageText = cbcart_ele2.textContent;
    }
    var cbcart_template_type = "";
    var cbcart_ele3 = document.getElementById("cbcart_ct_template_num");
    if (cbcart_ele3) {
        cbcart_template_type = cbcart_ele3.textContent;
    }
    var cbcart_temp = 0;
    var cbcart_i;
    for (cbcart_i = 0; cbcart_i < 10; cbcart_i++) {
        if (cbcart_messageText.includes("{{" + cbcart_i + "}}")) {
            cbcart_temp++;
            if (cbcart_template_type.includes("ac")) {
                cbcart_messageText = cbcart_messageText.replace("{{" + cbcart_i + "}}", `<select class="form-control cbcart_para_drop" name="cbcart_para` + cbcart_i + `">
        <option value="{{storename}}">{{storename}}</option>
        <option value="{{customername}}">{{customername}}</option>
        <option value="{{storeurl}}">{{storeurl}}</option>
        <option value="{{checkouturl}}">{{checkouturl}}</option></select>`);
            } else if(cbcart_template_type.includes("order")){
                cbcart_messageText = cbcart_messageText.replace("{{" + cbcart_i + "}}", `<select class="form-control cbcart_para_drop" name="cbcart_para` + cbcart_i + `">
                <option value="{{customername}}">{{customername}}</option><option value="{{storename}}">{{storename}}</option>
                    <option value="{{orderdate}}">{{orderdate}}</option>
                    <option value="{{orderid}}">{{ordernumber}}</option>
                    <option value="{{productname}}">{{productname}}</option>
                    <option value="{{amountwithcurrency}}">{{amountwithcurrency}}</option>
                    <option value="{{customeremail}}">{{customeremail}}</option>
                    <option value="{{billingcity}}">{{billingcity}}</option>
                    <option value="{{billingstate}}">{{billingstate}}</option>
                    <option value="{{billingcountry}}">{{billingcountry}}</option>
                    <option value="{{customernumber}}">{{customernumber}}</option>
                    <option value="{{storeurl}}">{{storeurl}}</option></select>`);
            }else if(cbcart_template_type.includes("cf7")) {
                cbcart_messageText = cbcart_messageText.replace("{{" + cbcart_i + "}}", `<select class="form-control cbcart_para_drop" name="cbcart_para` + cbcart_i + `">
                <option value="{{customername}}">{{customername}}</option>
                <option value="{{storename}}">{{storename}}</option>
                <option value="{{customersubject}}">{{customersubject}}</option>
                <option value="{{customermessage}}">{{customermessage}}</option>
                <option value="{{customeremail}}">{{customeremail}}</option>
                <option value="{{customernumber}}">{{customernumber}}</option>
                <option value="{{storeurl}}">{{storeurl}}</option>
                <option value="{{customerdetails}}">{{customerdetails}}</option></select>`);
            }
        }
    }
    jQuery("#cbcart_current_text").html(cbcart_messageText);
});

