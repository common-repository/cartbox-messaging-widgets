(function ($) {
    'use strict';
    if (cbcart_popup_object.cbcart_enable_popup === '1') {
        jQuery(document).on('click', '.add_to_cart_button', function(){
            const cbcart_popupClicked = getCookie('popup_clicked');
            if (cbcart_popupClicked !== 'true') {
                    // Display the popup
                var cbcart_chat_setting = {
                                cbcart_enable_popup: cbcart_popup_object.cbcart_enable_popup,
                                cbcart_modalheading_text: cbcart_popup_object.cbcart_modalheading_text,
                                cbcart_modalheading_color: cbcart_popup_object.cbcart_modalheading_color,
                                cbcart_modal_text: cbcart_popup_object.cbcart_modal_text,
                                cbcart_modal_text_color: cbcart_popup_object.cbcart_modal_text_color,
                                cbcart_modal_placeholder: cbcart_popup_object.cbcart_modal_placeholder,
                                cbcart_button_text: cbcart_popup_object.cbcart_button_text,
                                cbcart_button_text_color: cbcart_popup_object.cbcart_button_text_color,
                                cbcart_button_color: cbcart_popup_object.cbcart_button_color,
                                cbcart_consent_text: cbcart_popup_object.cbcart_consent_text,
                            }
                cbcart_createModal();
                function cbcart_createModal() {
                    // Create modal element
                    var cbcart_modal = document.createElement("div");
                    cbcart_modal.id = "cbcart_modal";
                    cbcart_modal.className = "cbcart_modal";

                    // Create modal content element
                    var cbcart_modalContent = document.createElement("div");
                    cbcart_modalContent.className = "cbcart-modal-content";

                    // Create modal body
                    var cbacart_modalBody = document.createElement("p");
                    cbacart_modalBody.className = "cbcart_modal_p";

                    cbacart_modalBody.innerHTML = ` <div class="">
                                 <div class="border-bottom-0">
                                     <button type="button" class="close cbcart-modal-close-icon" data-dismiss="modal" id="cbacrt_close_modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                     </button>
                                 </div>
                                 <div class="cbcart_header">
                                    <div class=" cbcart_icon_img_space">
                                         <span class="cbcart-modal-heading-icon">&#128722;</span>
                                     </div>
                                     <div class="cbcart_icon_img_right_space">
                                         <label class="modal-title cbcart_modalheading" id="cbcart_modal_heading">` + cbcart_chat_setting.cbcart_modalheading_text + `</label><br>
                                         <label class="cbcart_modal_text" id="cbcart_modal_text">` + cbcart_chat_setting.cbcart_modal_text + `</label>
                                     </div>
                                 </div>
                                 <form class="form_modal" id="cbcart-modal-form" method="post">
                                     <div class="cbcart-modal-body">
                                     <label class="cbcart_error_msg d-none" id="cbcart_error"></label>

                                     <div class="cbcart_input_div">
                                         <input type="text" class=" cbcart_phnno_input" name="cbcart_modal_mobileno" id="cbcart_modal_mobileno" autocomplete="off" maxlength="200" placeholder="` + cbcart_chat_setting.cbcart_modal_placeholder + `" class="cbcart_message form-control "/>
                                         </div>
                                        <label class="cbcart-form-check cbcart_modal_text">` + cbcart_chat_setting.cbcart_consent_text + `
                                             <input class=" mt-2" type="checkbox" id="cbcart_modal_checkbox">
                                              <span class="cbcart_checkmark"></span>
                                        </label>
                                    </div>
                                     <div class="cbcart_btn">
                                        <button type="submit" name="cbcart_modal_submit" id="cbcart_modal_button" class=" cbcart_modal_submit">` + cbcart_chat_setting.cbcart_button_text + `</button>
                                    </div>
                                </form>
                            </div>`;

                    //<label class="container">One
                    //   <input type="checkbox" checked="checked">
                    //   <span class="checkmark"></span>
                    // </label>
                    // Append elements to modal content
                    cbcart_modalContent.appendChild(cbacart_modalBody);

                    // Append modal content to modal
                    cbcart_modal.appendChild(cbcart_modalContent);

                    // Append modal to document
                    document.body.appendChild(cbcart_modal);
                    const cbcart_modalheading_color = document.getElementById('cbcart_modal_heading');
                    cbcart_modalheading_color.style.color = cbcart_chat_setting.cbcart_modalheading_color;
                    const cbcart_modal_text_color = document.getElementById('cbcart_modal_text');
                    cbcart_modal_text_color.style.color = cbcart_chat_setting.cbcart_modal_text_color;
                    const cbcart_button_text_color = document.getElementById('cbcart_modal_button');
                    cbcart_button_text_color.style.color = cbcart_chat_setting.cbcart_button_text_color;
                    cbcart_button_text_color.style.backgroundColor = cbcart_chat_setting.cbcart_button_color;
                    document.getElementById("cbcart_modal_button").classList.add("cbcart_button_disabled");
                    jQuery("#cbcart_modal_checkbox").click(function () {
                        if (this.checked) {
                            // Checkbox is checked, enable the button
                            document.getElementById("cbcart_modal_button").classList.remove("cbcart_button_disabled");
                        } else {
                            // Checkbox is not checked, disable the button
                            document.getElementById("cbcart_modal_button").classList.add("cbcart_button_disabled");
                        }
                    });
                    const cbcart_form = document.getElementById('cbcart-modal-form');


                    cbcart_form.addEventListener('submit', (event) => {

                        var cbcart_flag = '0';

                        // Get the value of the phone number field
                        var cbcart_phoneNumber = jQuery("#cbcart_modal_mobileno").val();

                        // Define a regular expression for a valid phone number
                        var cbcart_phoneNumberRegex = /^[0-9]{7,}$/;

                        // Test the value against the regular expression
                        var isValid = cbcart_phoneNumberRegex.test(cbcart_phoneNumber);

                        // If the phone number is not valid, prevent the form from being submitted
                        if (!isValid) {
                            cbcart_flag = '0';
                            jQuery("#cbcart_error").text("Please enter correct number");
                            jQuery("#cbcart_error").removeClass("d-none");
                            var modal = document.getElementById("cbcart_modal");
                            modal.style.display = "block";
                            event.preventDefault();
                        } else {
                            cbcart_flag = '1';
                            // event.preventDefault();
                            //storing data in cookies
                            setCookie('popup_clicked', 'true', 7);

                            const cbcart_checkbox = document.getElementById('cbcart_modal_checkbox');
                            if (cbcart_checkbox.checked) {
                                cbcart_flag = '1';
                            } else {
                                cbcart_flag = '0';
                            }
                            if (cbcart_flag === '1') {
                                var cbcart_number = document.getElementById('cbcart_modal_mobileno').value;
                                var data_ = {
                                    action: "cbcart_early_modal_data", cbcart_number: cbcart_number,
                                }
                                $.ajax({
                                    type: "POST",
                                    url: cbcart_popup_object.ajax_url,
                                    data: data_,
                                    success: function (result) {
                                    }
                                });
                                var modal = document.getElementById("cbcart_modal");
                                modal.style.display = "none";
                            }
                        }
                    });
                }

            showModal();
            function showModal() {
                var modal = document.getElementById("cbcart_modal");
                modal.style.display = "block";
            }
            jQuery('#cbacrt_close_modal').click(function () {
                var modal = document.getElementById("cbcart_modal");
                modal.style.display = "none";
            });
            }
        });

        // Define the setCookie function
        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            const expires = `expires=${d.toUTCString()}`;
            document.cookie = `${cname}=${cvalue};${expires};path=/`;
        }

// Define the getCookie function
        function getCookie(cname) {
            const name = `${cname}=`;
            const decodedCookie = decodeURIComponent(document.cookie);
            const ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return '';
        }

// Use the setCookie and getCookie
    }
})(jQuery);
