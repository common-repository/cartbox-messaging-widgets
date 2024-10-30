<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_logo  = cbcart_logonew_black;
$cbcart_check     = CBCART_DIR . CBCART_DOMAIN . esc_url( '/admin/images/cbcart-check.png' ,'cartbox-messaging-widgets');
$cbcart_cloud_setup     = cbcart_cloudsetup_img;
$cbcart_ptoken     = cbcart_p_token_img;
$cbcart_logo1 = cbcart_globicon;
$cbcart_logo2 = cbcart_chat_icon;
$cbcart_create_template=cbcart_template_img;
$cbcart_ispage="0";
if (isset( $_POST['cbcart_test1'] )  ) {

    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_start_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_start_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_start_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_start' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_update_arr = array(
        'isvisited'=>'1',
    );
    $cbcart_result = update_option( 'cbcart_startup', wp_json_encode( $cbcart_update_arr ) );
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}
$cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
if($cbcart_page==="cbcart_tutorial"){
    $cbcart_ispage="1";
}
$cbacrt_iswoo="";
if ( class_exists( 'WooCommerce' ) ) {
    $cbacrt_iswoo="true";
}else{
    $cbacrt_iswoo="false";
}
$cbcart_blogurl = "https://www.cartbox.net/blog/how-to-set-webhook-to-receive-incoming-messages/";
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <img src="<?php echo esc_url( $cbcart_logo ); ?>" class="cbcart_imgclass">
        </div>
        <div class="cbcart_startup_heading text-center mt-3"><?php esc_html_e('Cartbox - WooCommerce Plugin','cartbox-messaging-widgets') ?></div>
        <div class="cbcart_lbl3 text-center cbcart_fw-400"><?php esc_html_e('Powered by Cloud API from WhatsApp','cartbox-messaging-widgets') ?> &trade;</div>
    </div>
</div>
<?php
if($cbacrt_iswoo==="false"){?>
    <div class="bg-white cbcart_steps_box">
        <div class="py-3 px-5 text-danger"><h4><label class=" fa fa-warning"></label>
            <?php esc_html_e(" WooCommerce is required for this plugin.",'cartbox-messaging-widgets') ?>
        <a href="<?php echo esc_url( get_site_url() ); ?>/wp-admin/plugin-install.php?s=woocomerce&tab=search&type=term"><?php esc_html_e( 'Install Plugin Now','cartbox-messaging-widgets' ); ?></a>
        </h4>
        </div>
    </div>
    <?php
}
?>
<div class="bg-white cbcart_steps_box">
    <div class="row m-0 p-0">
        <div class="col-12 m-0  p-0">
            <div class="cbcart_steps_card1">
                <div class="text-center">
                    <label class="cbcart_label_info">
                        <?php esc_html_e('Thank you for installing the plugin. To set your plugin up further, we will need you to setup a WhatsApp Cloud API account. Once your Cloud API setup is done, you will get your Business Account ID, Phone Number ID and Permanent Token through WhatsApp. For more information on setup, please refer to the tutorials below.','cartbox-messaging-widgets');?>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white cbcart_steps_box">
    <div class="row m-0 p-3">
        <div class="col-12">
            <label class="cbcart_startup_heading cbcart_fw-700 text-black"><?php esc_html_e('Cloud API Setup Tutorials','cartbox-messaging-widgets');?></label>
        </div>
        <div class=" cbcart_startup_hr"><hr></div>
        <div class="row m-0">
            <div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 1','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="https://www.cartbox.net/blog/how-to-setup-whatsapp-cloud-api/" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url($cbcart_cloud_setup,'cartbox-messaging-widgets'); ?>"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to setup WhatsApp cloud API?','cartbox-messaging-widgets'); ?></label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 2','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="https://www.cartbox.net/blog/how-to-generate-the-permanent-token-in-cloud-api/" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url($cbcart_ptoken,'cartbox-messaging-widgets'); ?>"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to generate the permanent token in cloud API?','cartbox-messaging-widgets') ?></label>
                    </div>
                </div>
            </div><div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 3','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="https://www.cartbox.net/blog/how-to-create-templates-on-whatsapp-cloud-api/" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url($cbcart_create_template,'cartbox-messaging-widgets'); ?>"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to create templates on WhatsApp cloud API?','cartbox-messaging-widgets'); ?></label>
                    </div>
                </div>
            </div><div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 4','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="<?php esc_url($cbcart_blogurl);?>>" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url(CBCART_URL); ?>/admin/images/cbcart-maxresdefault.jpg"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to setup WhatsApp cloud API?','cartbox-messaging-widgets'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white cbcart_steps_box">
    <div class="row m-0 p-3">
        <div class="col-12">
            <label class="cbcart_startup_heading cbcart_fw-700 text-black"><?php esc_html_e('Benefits of WhatsApp Cloud API','cartbox-messaging-widgets');?></label>
        </div>
        <div class=" cbcart_startup_hr"><hr></div>
        <div class="col-12">
            <div class="row m-0 justify-content-between">
                <div class="cbcart_col_auto ">
                    <div class="card cbcart_steps_card cbcart_ml-18">
                        <div class="cbcart_steps_num"><?php esc_html_e('1','cartbox-messaging-widgets') ?></div>
                        <div class="text-center">
                            <div class="cbcart_check_round">
                                <img src="<?php echo esc_url($cbcart_check); ?>" alt="<?php esc_attr_e('check image','cartbox-messaging-widgets') ?>"  >
                            </div>
                            <div class="cbcart_steps_text"><?php esc_html_e("Send up to 1,00,000 messages/day from your own WhatsApp number",'cartbox-messaging-widgets')?></div>
                        </div>
                    </div>
                </div>
                <div class="cbcart_col_auto">
                    <div class="card cbcart_steps_card">
                        <div class="cbcart_steps_num"><?php esc_html_e('2','cartbox-messaging-widgets') ?></div>
                        <div class="text-center">
                            <div class="cbcart_check_round">
                                <img src="<?php echo esc_url($cbcart_check); ?>" alt="<?php esc_attr_e('check image','cartbox-messaging-widgets') ?>"  >
                            </div>
                            <div class="cbcart_steps_text"><?php esc_html_e("No setup charges and pay message charge directly to Facebook.",'cartbox-messaging-widgets')?></div>
                        </div>
                    </div>
                </div>
                <div class="cbcart_col_auto">
                    <div class="card cbcart_steps_card">
                        <div class="cbcart_steps_num"><?php esc_html_e('3','cartbox-messaging-widgets') ?></div>
                        <div class="text-center">
                            <div class="cbcart_check_round">
                                <img src="<?php echo esc_url($cbcart_check) ?>" alt="<?php esc_attr_e('check image','cartbox-messaging-widgets') ?>"  >
                            </div>
                            <div class="cbcart_steps_text"><?php esc_html_e("Get free 1000 messages every month.",'cartbox-messaging-widgets')?><br><br></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white cbcart_steps_box">
    <div class="row m-0 p-3">
        <div class="col-12">
            <label class="cbcart_startup_heading cbcart_fw-700 text-black"><?php esc_html_e('Important Note','cartbox-messaging-widgets');?></label>
        </div>
        <div class=" cbcart_startup_hr"><hr></div>
        <div class="row">
            <div class="col-9">
                <div class="cbcart_startup_list">
                    <label class="cbcart_lbl3 cbcart_fw-400"><?php esc_html_e('You will need the following to get started:','cartbox-messaging-widgets'); ?></label>
                    <ul>
                        <li class="cbcart_lbl cbcart_fw-400"><i class="fa fa-circle"></i><?php esc_html_e('Email','cartbox-messaging-widgets');?></li>
                        <li class="cbcart_lbl cbcart_fw-400"><i class="fa fa-circle"></i><?php esc_html_e('Live website URL','cartbox-messaging-widgets');?></li>
                        <li class="cbcart_lbl cbcart_fw-400"><i class="fa fa-circle"></i><?php esc_html_e('Facebook account','cartbox-messaging-widgets');?></li>
                        <li class="cbcart_lbl cbcart_fw-400"><i class="fa fa-circle"></i><b><?php esc_html_e('A mobile number that has never been previously ','cartbox-messaging-widgets');?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_html_e('used on WhatsApp(extremely important)','cartbox-messaging-widgets');?></b></li>
                        <li class="cbcart_lbl cbcart_fw-400"><i class="fa fa-circle"></i><?php esc_html_e('Country specific company formation documents','cartbox-messaging-widgets');?></li>
                        <li class="cbcart_lbl cbcart_fw-400"><i class="fa fa-circle"></i><?php esc_html_e('Company address and ID verification documents','cartbox-messaging-widgets');?></li>
                    </ul>
                </div>
            </div>
            <div class="col-3 align-self-center ">
                <div class="card cbcart_card cbcart_support_card_static">
                    <img src="<?php echo esc_url($cbcart_logo2); ?>" class="cbcart_chatimg"/>
                    <div class="card-body p-1">
                        <div><label class="cbcart_lbl"><?php esc_html_e('Need Support: ','cartbox-messaging-widgets');  ?>
                            </label><br></div>
                        <div class="mt-3"><img src="<?php echo esc_url( $cbcart_logo1 ); ?>" class="cbcart_globeimg"/><a href="<?php echo esc_url( cbcart_product_page_url); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Website','cartbox-messaging-widgets' );  ?></a><br></div>
                        <div class="mt-3"><i class="fa  fa-comment-o"></i><a href="<?php echo esc_url( cbcart_site); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Chat','cartbox-messaging-widgets');?></a><br></div>
                        <div class="mt-3"><i class="fa  fa-whatsapp"></i><a href="<?php echo esc_url(cbcart_whatsapp_link); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('WhatsApp','cartbox-messaging-widgets');?></a></div>
                        <div class="mt-3"><i class="fa  fa-envelope-o"></i><a href="mailto:hi@cartbox.net" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Email','cartbox-messaging-widgets');?></a><br></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($cbcart_ispage==="0"){ ?>
    <div class="cbcart_steps_box mb-5 pb-5">

    <form method="post" name="cbcart_form1" action="">
        <?php wp_nonce_field( 'cbcart_start', 'cbcart_start_nonce' ); ?>
       <?php  if($cbacrt_iswoo==="false"){?>
        <button class="btn cbcart-btn-theme-static top-0 mt-5 disabled" name="cbcart_test1"><?php esc_html_e('Start Now','cartbox-messaging-widgets'); ?></button>
<?php }else{ ?>
        <button class="btn cbcart-btn-theme-static top-0 mt-5" name="cbcart_test1"><?php esc_html_e('Start Now','cartbox-messaging-widgets'); ?></button>
<?php } ?>
        <div class="row m-0">
            <div class="col-6">
                <div class="card m-auto shadow">
                    <div class="text-center">
                        <label class="cbcart_startup_heading"><?php esc_html_e('Step : 1','cartbox-messaging-widgets'); ?></label>
                        <br>
                        <label class="cbcart_lbl3 cbcart_fw-400">
                            <?php esc_html_e('Setup Cloud API On Facebook developer portal.' ,'cartbox-messaging-widgets'); ?>
                        </label>
                        <br>
                        <a href="https://developers.facebook.com/" target="_blank"><button type="button" class="btn cbcart_btn-theme btn-secondary m-3"><?php esc_html_e('Facebook cloud Setup','cartbox-messaging-widgets'); ?></button></a>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card m-auto shadow">
                    <div class="text-center">
                        <label class="cbcart_startup_heading"><?php esc_html_e('Step : 2','cartbox-messaging-widgets'); ?></label>
                        <br>
                        <label class="cbcart_lbl3 cbcart_fw-400"><?php esc_html_e('Done with Cloud API Setup on Facebook? ','cartbox-messaging-widgets') ?>
                        </label>
                        <br>
                        <?php wp_nonce_field( 'cbcart_start', 'cbcart_start_nonce' ); ?>
                        <?php  if($cbacrt_iswoo==="false"){?>
                            <button class="btn cbcart_btn-theme m-3 disabled" name="cbcart_test1"><?php esc_html_e('Start Now','cartbox-messaging-widgets'); ?></button>
                            <?php }else{?>
                            <button class="btn cbcart_btn-theme m-3" name="cbcart_test1"><?php esc_html_e('Start Now','cartbox-messaging-widgets'); ?></button>
                        <?php  }?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>