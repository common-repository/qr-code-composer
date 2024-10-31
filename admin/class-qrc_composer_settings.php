<?php
/**
 * The file that defines the bulk print admin area
 *
 * public-facing side of the site and the admin area.
 *
 * @link       https://sharabindu.com
 * @since      1.0.9
 *
 * @package    qrc_composer_pro
 * @subpackage qrc_composer_pro/admin
 */

class QR_code_Admin_settings{

        public function __construct()
        {
        add_action('admin_init', array($this ,'qcr_settings_page'));

       // add_action( 'init', array( $this, 'save_default_settings' ) );

    }

    public function qcr_settings_page()
    {

    register_setting("qrc_composer_settings", "qrc_composer_settings", array()); 
    
    add_settings_section("qrc_design_section", " ", array($this ,'settting_sec_desfifn'), 'qrc_design_sec');
    
    add_settings_section("qrc_download_section", " ", array($this ,'settting_sec_func'), 'qrc_admin_sec');


    add_settings_field("qr_code_size", esc_html__("Front QR Code Size", "qr-code-composer") ,array($this , "qr_input_size"), 'qrc_design_sec', "qrc_design_section");

        add_settings_field("qr_color_management", esc_html__("QR Color", "qr-code-composer") ,array($this , "qr_color_management"), 'qrc_design_sec', "qrc_design_section");

    add_settings_field("qr_bgcolor_management", esc_html__("QR Background Color", "qr-code-composer") , array($this ,"qr_bgcolor_management"), 'qrc_design_sec', "qrc_design_section");


    add_settings_field("qr_download_text", esc_html__("Download QR Button", "qr-code-composer") , array($this ,"qr_download_text"), 'qrc_design_sec', "qrc_design_section");

    add_settings_field("qr_visibity_options", esc_html__("QR Code Visibility", "qr-code-composer") , array($this ,"qr_visibity_options"), 'qrc_design_sec', "qrc_design_section",array('class' =>'qrcnewfeatures qrcodevsbity')); 

    add_settings_field("qr_popup_options", esc_html__("QR Code in Popup", "qr-code-composer") , array($this ,"qr_popup_options"), 'qrc_design_sec', "qrc_design_section" , array('class' =>'qrcnewfeatures'));

    add_settings_field("qr_popup_btndesign", esc_html__("Popup button design", "qr-code-composer") , array($this ,"qr_popup_btndesign"), 'qrc_design_sec', "qrc_design_section" , array('class' =>'qrcnewqr_popup_btndesign'));


    add_settings_field("qr_popup_enablefor", esc_html__("Popup Enable For", "qr-code-composer") , array($this ,"qr_popup_enablefor"), 'qrc_design_sec', "qrc_design_section" , array('class' =>'qrcnewqr_popup_btndesign'));


    add_settings_field("qr_alignment", esc_html__("Alignment", "qrc_composer") , array($this ,"qr_alignment"), 'qrc_admin_sec', "qrc_download_section",array(
            'class'  =>  'alignme', 
        'label_for' => 'qr_alignment',

    ));

    if (class_exists('WooCommerce'))
    {
        add_settings_field("wc_qr_alignment", esc_html__("QR location on product page", "qrc_composer") , array($this ,"wc_qr_alignment"), 'qrc_admin_sec', "qrc_download_section",array(
            'class'  =>  'wcalignme qrcnewfeatures ', 
        'label_for' => 'qrcppagelocation',

    ));

        add_settings_field("qrc_wc_ptab_name", esc_html__("Change Text of Product Tab", "qrc_composer") ,array($this , "qrc_wc_ptab_name"), 'qrc_admin_sec', "qrc_download_section",array(
            'class'  =>  'ptab_name', 
        'label_for' => 'qrc_wc_ptab_name',

    ));

    }

    add_settings_field("qr_checkbox", esc_html__("Hide QR code according to post type", "qrc_composer") ,array($this , "qr_checkbox"), 'qrc_admin_sec', "qrc_download_section" ,array(
            'class'  =>  'qr_checkbox',

    ));


    add_settings_field("qr_checkbox_page", esc_html__("Hide QR code according to Page", "qrc_composer") , array(
        $this,
        "qr_checkbox_page"
    ) , 'qrc_admin_sec', "qrc_download_section" ,array(
            'class'  =>  'qr_checkbox_page',

    ));


    add_settings_field("qr_stcode_management", esc_html__("Shortcode for Current Page URL", "qrc_composer") ,array($this , "qr_stcode_management"), 'qrc_admin_sec', "qrc_download_section",array(
            'class'  =>  'qr_stcode_management',

    ));

    }
   /**
     * This function is a callback function of  add seeting section
     */
    function settting_sec_desfifn()
    {   
        return true;
    }
    function settting_sec_func()
    {   
       ?>
<div class="qrc-box-header" >
            <h3 class="sui-box-title"><?php echo esc_html__('Auto Generate QR', 'qrc_composer') ?></h3>
<p><?php echo esc_html__('These QR codes are automatically displayed after the content of the web page. current page url will be used as content of QR code.', 'qrc_composer') ?><a class="qrcdownsize" id="qrcauto" video-url="https://www.youtube.com/watch?v=LyQGEShmhn8"><span title="Video Documentation" id="qrcdocsides" class="dashicons dashicons-video-alt3"></span></a></p>

        </div>

       <?php

    }

   
    function qr_checkbox_page(){

    $qrc_type_pages = get_posts(array(
            'post_type' => 'page',
            'posts_per_page' => - 1,
        ));
        if ($qrc_type_pages)
        {
            foreach ($qrc_type_pages as $qrc_type_page){

        $options = get_option('qrc_composer_settings');

        $checked = isset($options[$qrc_type_page->ID]) ? 'checked' : '';

            printf('<div style="margin-top:10px"><label class="qrccheckboxwrap" for ="%s">%s
  <input type="checkbox" id="%s"  value="%s" name="qrc_composer_settings[%s]" %s>
  <span class="qrccheckmark"></span>
</label></br></div>', esc_attr($qrc_type_page->ID),esc_html($qrc_type_page->post_title),esc_attr($qrc_type_page->ID),esc_attr($qrc_type_page->ID),esc_attr($qrc_type_page->ID),esc_attr($checked));


        }


    
        }
    }


function qrc_wc_ptab_name()
{

    $options = get_option('qrc_composer_settings');
    $qrc_wc_ptab_name = isset($options['qrc_wc_ptab_name']) ? $options['qrc_wc_ptab_name'] : esc_html__('QR Code','qr-code-composer');

    printf('<input type="text" name="qrc_composer_settings[qrc_wc_ptab_name]" value="%s" placeholder="e:g: QR Code" id="qrc_wc_ptab_name">', esc_attr($qrc_wc_ptab_name)); 

}

function qr_checkbox()
{

    $args = array(
        'public' => true,
    );

        $excluded_posttypes = array('attachment','revision','nav_menu_item','custom_css','customize_changeset','oembed_cache','user_request','wp_block','scheduled-action','product_variation','shop_order','shop_order_refund','shop_coupon','elementor_library','e-landing-page','wp_template','wp_template_part','wp_navigation','wp_global_styles','shop_order_placehold');

    $types = get_post_types( $args);
    $post_types = array_diff($types, $excluded_posttypes);

    foreach ($post_types as $post_type)
    {
        $post_type_title = get_post_type_object($post_type);

        $options = get_option('qrc_composer_settings');

        $checked = isset($options[$post_type]) ? 'checked' : '';

        printf('<div><label class="qrccheckboxwrap"  for ="%s" id="qrc_label_wrap">%s
  <input  type="checkbox" id="%s" value="%s" name="qrc_composer_settings[%s]" %s>
  <span class="qrccheckmark"></span>
</label></br></div>', esc_attr($post_type), esc_html($post_type), esc_attr($post_type),esc_attr($post_type), esc_attr($post_type), esc_attr($checked));




    }


}


/**
 * This function is a callback function of  add seeting field
 */

function qr_input_size()
{

    $options = get_option('qrc_composer_settings');
    $qrc_size = isset($options['qr_code_picture_size_width']) ? $options['qr_code_picture_size_width'] : 200;

        printf('<input type="range" class="qrcranges"  name="qrc_composer_settings[qr_code_picture_size_width]"  id="qwe_sizw" min="50" step="1" max="600" value="%s" oninput="num7.value = this.value"><input type="number" id="num7" value="%s" min="50" step="1" max="600" oninput="qwe_sizw.value = this.value">', $qrc_size, $qrc_size);

 }


/**
 * This function is a callback function of  add seeting field
 */

    function qr_alignment()
    {

    $options = get_option('qrc_composer_settings');
    $qrc_alignment = isset($options['qrc_select_alignment']) ? $options['qrc_select_alignment'] : '';

    ?>
    <select name="qrc_composer_settings[qrc_select_alignment]" id="qr_alignment">
        
    <option value="left" <?php echo esc_attr($qrc_alignment) == 'left' ? 'selected' : '' ?>><?php esc_html_e('Left', 'qr-code-composer'); ?></option>
    <option value="right" <?php echo esc_attr($qrc_alignment) == 'right' ? 'selected' : '' ?>><?php esc_html_e('Right', 'qr-code-composer'); ?></option>   
    <option value="center" <?php echo esc_attr($qrc_alignment) == 'center' ? 'selected' : '' ?>><?php esc_html_e('Center', 'qr-code-composer'); ?></option>

    </select>

    <?php
    }

/**
 * This function is a callback function of  add seeting field
 */

    function qr_download_text()
    {

    $options = get_option('qrc_composer_settings');
    $options_value = isset($options['qr_download_text']) ? $options['qr_download_text'] : 'Download QR 🠋';
    $qr_download_iconclass = isset($options['qr_download_iconclass']) ? $options['qr_download_iconclass'] : '';

    $qr_download_hide = isset($options['qr_download_hide']) ? $options['qr_download_hide'] : 'no';
    $qr_download_brclr = isset($options['qr_download_brclr']) ? $options['qr_download_brclr'] : '#44d813';
    $qrc_dwnbtn_brdius = isset($options['qrc_dwnbtn_brdius']) ? $options['qrc_dwnbtn_brdius'] : '20';
    $qr_download_fntsz = isset($options['qr_download_fntsz']) ? $options['qr_download_fntsz'] : '12';

    ?>
    <div class="qrdownlaodtext">
    <strong>
    <label class="qrc_dwnbtnlabel" for="qrc_dwnbtnlabel"><?php esc_html_e('Remove?', 'qr-code-composer'); ?></label></strong>
    <select name="qrc_composer_settings[qr_download_hide]" class="qrcremovedownlaod" id="qrc_dwnbtnlabel">
        
    <option value="yes" <?php echo esc_attr($qr_download_hide) == 'yes' ? 'selected' : '' ?>><?php esc_html_e('Remove Download Button', 'qr-code-composer'); ?></option>
    <option value="no" <?php echo esc_attr($qr_download_hide) == 'no' ? 'selected' : '' ?>><?php esc_html_e('Keep Download Button', 'qr-code-composer'); ?></option>    

    </select>
   <div class="removealsscolors">
    <?php
   printf('<p><strong>
    <label class="inputetxtas" for="inputetxtas">'.esc_html("Label", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qr_download_text]" value="%s" placeholder="Download Qr" id="inputetxtas"> </p><p class="htmyrmrtdf">🡻 🡳 🡫 🡣 🡓 🡇  🠟 🠋 ⯯ ⮟ ⮇ <span>HTML symbols, <a href="https://www.w3schools.com/charsets/ref_utf_arrows.asp"> More..</a></span></p>', esc_attr($options_value)); 

        printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qr_download_fntsz">'.esc_html("Font Size", "qr-code-composer").'</label></strong><input type="number" name="qrc_composer_settings[qr_download_fntsz]" value="%s"  id="qr_download_fntsz" min="10" max="30"></p>', esc_attr($qr_download_fntsz)); 

    $value = (isset($options['qr_dwnbtn_color'])) ? $options['qr_dwnbtn_color'] : '#000';
    printf('<p class="qrc_dwnbtn"><strong>
    <label class="qrc_dwnbtnlabel" for="qr_dwnbtn_color">'.esc_html("Text Color", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qr_dwnbtn_color]" value="%s" class="qrc-btn-color-picker" id="qr_dwnbtn_color"></p>', esc_attr($value));
    $valuebg = (isset($options['qr_dwnbtnbg_color'])) ? $options['qr_dwnbtnbg_color'] : '#44d813';
    printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qr_dwnbtnbg_color">'.esc_html("Background", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qr_dwnbtnbg_color]" value="%s" class="qrc-btn-bg-picker" id="qr_dwnbtnbg_color"></p>', esc_attr($valuebg));


    printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qr_download_brclr">'.esc_html("Border Color", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qr_download_brclr]" value="%s"  id="qr_download_brclr"></p>', esc_attr($qr_download_brclr));

    printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qrc_dwnbtn_brdius">'.esc_html("Border Radius", "qr-code-composer").'</label></strong><input type="number" name="qrc_composer_settings[qrc_dwnbtn_brdius]" value="%s"  id="qrc_dwnbtn_brdius" min="0" max="50"></p></div></div>', esc_attr($qrc_dwnbtn_brdius)); 



    }
/**
 * This function is a callback function of  add seeting field
 */

    function qr_visibity_options()
    {

    $options = get_option('qrc_composer_settings');
    $qrchidefrontend = isset($options['qrchidefrontend']) ? 'checked' : '';

        printf('<div class="onoffswitch"><input type="checkbox" value="qrchidefrontend" class="onoffswitch-checkbox" id="qrchidefrontend"  name="qrc_composer_settings[qrchidefrontend]" %s tabindex="0"><label class="onoffswitch-label" for="qrchidefrontend">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span></label></div>',$qrchidefrontend);

        ?>

    <p class="qrcvisisbolity"><?php esc_html_e('If the Switcher is on, the QR code from the frontend will be removed and only the download button will be visible. But Clicking the download button will download the QR code instantly.', 'qr-code-composer'); ?></p>
    <?php
    }
/**
 * This function is a callback function of  add seeting field
 */

    function qr_popup_enablefor()
    {

    $options = get_option('qrc_composer_settings');
    $popupcustomqr = isset($options['popupcustomqr']) ? 'checked' : '';
    $popupvcardqr = isset($options['popupvcardqr']) ? 'checked' : '';

        printf('<div class="popupqrdefine"><p><input type="checkbox"  checked  id="popupcuurent">
    <label class="qrc_dwnbtnlabel">'.esc_html("Auto Generate QR / Current Page QR", "qr-code-composer").'</label></p>');

        printf('<p><input type="checkbox" name="qrc_composer_settings[popupcustomqr]" %s  id="popupcustomqr">
    <label class="qrc_dwnbtnlabel" for="popupcustomqr">'.esc_html("Various Components QR", "qr-code-composer").'</label></p>', esc_attr($popupcustomqr)); 

        printf('<p><input type="checkbox" name="qrc_composer_settings[popupvcardqr]" %s  id="popupvcardqr">
    <label class="qrc_dwnbtnlabel" for="popupvcardqr">'.esc_html("vCard QR", "qr-code-composer").'</label></p>', esc_attr($popupvcardqr));

        printf('<p><input type="checkbox" id="popupintegrte">
    <label class="qrc_dwnbtnlabel" for="popupintegrte">'.esc_html("Integration QR (Pro)", "qr-code-composer").'</label></p><p class="htmyrmrtdf"><span>'.esc_html("When you Checked for popup, the associated shortcode will also enable the popup behavior", "qr-code-composer").'</span></p></div>'); 
    }
/**
 * This function is a callback function of  add seeting field
 */

    function qr_popup_btndesign()
    {

    $options = get_option('qrc_composer_settings');

    $qrcpopuptext = isset($options['qrcpopuptext']) ? $options['qrcpopuptext'] : 'View To Click  ⮞ ';
    $qrcpopup_bg = (isset($options1['qrcpopup_bg'])) ? $options1['qrcpopup_bg'] : '#44d813';
    $qrcpopup_color = (isset($options1['qrcpopup_color'])) ? $options1['qrcpopup_color'] : '#000';
    $qrcpopup_brclr = (isset($options1['qrcpopup_brclr'])) ? $options1['qrcpopup_brclr'] : '#32a518';
    $qrcpopup_brdius = (isset($options1['qrcpopup_brdius'])) ? $options1['qrcpopup_brdius'] : '20';
    $qrcpopup_fntsize = isset($options1['qrcpopup_fntsize']) ? $options1['qrcpopup_fntsize'] : '12';
    printf('<p><strong>
    <label class="inputetxtas" for="qrcpopuptext">'.esc_html("Label", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qrcpopuptext]" value="%s" placeholder="View QR code" id="qrcpopuptext"></p><p class="htmyrmrtdf">🡲 🡪 ⮞ ⯈ 🠊 🠞 🠦 🠮 🡆 🢂 → ⇒ ⇢ <span>HTML symbols</span></p>', esc_attr($qrcpopuptext)); 

        printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qrcpopup_fntsize">'.esc_html("Font Size", "qr-code-composer").'</label></strong><input type="number" name="qrc_composer_settings[qrcpopup_fntsize]" value="%s"  id="qrcpopup_fntsize" min="10" max="30"></p>', esc_attr($qrcpopup_fntsize)); 



    printf('<p class="qrc_dwnbtn"><strong>
    <label class="qrc_dwnbtnlabel" for="qrcpopup_color">'.esc_html("Color", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qrcpopup_color]" value="%s" id="qrcpopup_color"></p>', esc_attr($qrcpopup_color));



    printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qrcpopup_bg">'.esc_html("Background", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qrcpopup_bg]" value="%s" id="qrcpopup_bg"></p></div></div>', esc_attr($qrcpopup_bg));

    printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qrcpopup_brclr">'.esc_html("Border Color", "qr-code-composer").'</label></strong><input type="text" name="qrc_composer_settings[qrcpopup_brclr]" value="%s"  id="qrcpopup_brclr"></p>', esc_attr($qrcpopup_brclr));

        printf('<p><strong>
    <label class="qrc_dwnbtnlabel" for="qrcpopup_brdius">'.esc_html("Border Radius", "qr-code-composer").'</label></strong><input type="number" name="qrc_composer_settings[qrcpopup_brdius]" value="%s"  id="qrcpopup_brdius"  min="0" max="50"></p>', esc_attr($qrcpopup_brdius)); 

    }

    function qr_popup_options()
    {

    $options = get_option('qrc_composer_settings');

    $qrcpopupenbl = isset($options['qrcpopupenbl']) ? 'checked' : '';
   $qrc_design_type = isset($options['qrc_design_type']) ? $options['qrc_design_type'] : 'popup';
   $qrc_popupdesign = isset($options['qrc_popupdesign']) ? $options['qrc_popupdesign'] : 'center';
   $qrc_tooltipdesign = isset($options['qrc_tooltipdesign']) ? $options['qrc_tooltipdesign'] : 'leftTop';




    ?>
    <div class="qrdownlaodtext">

    <?php
        printf('<div class="onoffswitch"><input type="checkbox" value="qrcpopupenbl" class="onoffswitch-checkbox" id="qrcpopupenbl"  name="qrc_composer_settings[qrcpopupenbl]" %s tabindex="0"><label class="onoffswitch-label" for="qrcpopupenbl">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span></label></div>',$qrcpopupenbl);

        ?>
      

    <p class="qrcvisisbolity"  style="margin-bottom:12px;"><?php esc_html_e('If the switcher is on, the popup button will be visible instead of the frontend QR image. Click on the popup button to see the QR code.', 'qr-code-composer'); ?></p>
   <div class="removePopupsecte">
    <strong>
    <label class="qrc_dwnbtnlabel" for="qrc_design_type"><?php esc_html_e('Display Type:', 'qr-code-composer'); ?></label></strong>
     <select name="qrc_composer_settings[qrc_design_type]" id="qrc_design_type">
        
    <option value="tooltip" <?php echo esc_attr($qrc_design_type) == 'tooltip' ? 'selected' : '' ?>><?php esc_html_e('ToolTip', 'qr-code-composer'); ?></option>
    <option value="popup" <?php echo esc_attr($qrc_design_type) == 'popup' ? 'selected' : '' ?>><?php esc_html_e('PopUp', 'qr-code-composer'); ?></option>    

    </select> 

    <p  id="qrc_popupdesignwrap">
    <strong>
        <label class="qrc_dwnbtnlabel" for="qrc_popupdesign"><?php esc_html_e('Popup Position:', 'qr-code-composer'); ?></label></strong>
     <select name="qrc_composer_settings[qrc_popupdesign]"  id="qrc_popupdesign">
        
    <option value="center" <?php echo esc_attr($qrc_popupdesign) == 'center' ? 'selected' : '' ?>><?php esc_html_e('Center', 'qr-code-composer'); ?></option>
    <option value="leftTop" <?php echo esc_attr($qrc_popupdesign) == 'leftTop' ? 'selected' : '' ?>><?php esc_html_e('Left Top', 'qr-code-composer'); ?></option>
    <option value="centerTop" <?php echo esc_attr($qrc_popupdesign) == 'centerTop' ? 'selected' : '' ?>><?php esc_html_e('Center Top', 'qr-code-composer'); ?></option>
    <option value="rightTop" <?php echo esc_attr($qrc_popupdesign) == 'rightTop' ? 'selected' : '' ?>><?php esc_html_e('Right Top', 'qr-code-composer'); ?></option>
    <option value="leftBottom" <?php echo esc_attr($qrc_popupdesign) == 'leftBottom' ? 'selected' : '' ?>><?php esc_html_e('Left Bottom', 'qr-code-composer'); ?></option>
    <option value="centerBottom" <?php echo esc_attr($qrc_popupdesign) == 'centerBottom' ? 'selected' : '' ?>><?php esc_html_e('Center Bottom', 'qr-code-composer'); ?></option>    
    <option value="rightBottom" <?php echo esc_attr($qrc_popupdesign) == 'rightBottom' ? 'selected' : '' ?>><?php esc_html_e('Right Bottom', 'qr-code-composer'); ?></option>    
    <option value="centerTopSlide" <?php echo esc_attr($qrc_popupdesign) == 'centerTopSlide' ? 'selected' : '' ?>><?php esc_html_e('Center Top Slide', 'qr-code-composer'); ?></option>    
    <option value="centerBottomSlide" <?php echo esc_attr($qrc_popupdesign) == 'centerBottomSlide' ? 'selected' : '' ?>><?php esc_html_e('Center Bottom Slide', 'qr-code-composer'); ?></option>    
    <option value="leftTopSlide" <?php echo esc_attr($qrc_popupdesign) == 'leftTopSlide' ? 'selected' : '' ?>><?php esc_html_e('Left Top Slide', 'qr-code-composer'); ?></option>    
    <option value="leftBottomSlide" <?php echo esc_attr($qrc_popupdesign) == 'leftBottomSlide' ? 'selected' : '' ?>><?php esc_html_e('Left Bottom Slide', 'qr-code-composer'); ?></option>    
    <option value="rightTopSlide" <?php echo esc_attr($qrc_popupdesign) == 'rightTopSlide' ? 'selected' : '' ?>><?php esc_html_e('Right Top Slide', 'qr-code-composer'); ?></option>    
    <option value="rightBottomSlide" <?php echo esc_attr($qrc_popupdesign) == 'rightBottomSlide' ? 'selected' : '' ?>><?php esc_html_e('Right Bottom Slide', 'qr-code-composer'); ?></option>    

        </select> 
    </p>

    <p id="qrc_tooltipdesignwrap">
    <strong>
    <label class="qrc_dwnbtnlabel" for="qrc_tooltipdesign"><?php esc_html_e('Tooltip Position:', 'qr-code-composer'); ?></label></strong>
     <select name="qrc_composer_settings[qrc_tooltipdesign]" class="qrc_tooltipdesign" id="qrc_tooltipdesign">
        
    <option value="bottomLeft" <?php echo esc_attr($qrc_tooltipdesign) == 'bottomLeft' ? 'selected' : '' ?>><?php esc_html_e('Bottom Left', 'qr-code-composer'); ?></option>
    <option value="bottomCenter" <?php echo esc_attr($qrc_tooltipdesign) == 'bottomCenter' ? 'selected' : '' ?>><?php esc_html_e('Bottom Center', 'qr-code-composer'); ?></option>
    <option value="bottomRight" <?php echo esc_attr($qrc_tooltipdesign) == 'bottomRight' ? 'selected' : '' ?>><?php esc_html_e('Bottom Right', 'qr-code-composer'); ?></option>
    <option value="leftTop" <?php echo esc_attr($qrc_tooltipdesign) == 'leftTop' ? 'selected' : '' ?>><?php esc_html_e('Left Top', 'qr-code-composer'); ?></option>
    <option value="leftCenter" <?php echo esc_attr($qrc_tooltipdesign) == 'leftCenter' ? 'selected' : '' ?>><?php esc_html_e('Left Center', 'qr-code-composer'); ?></option>
    <option value="rightTop" <?php echo esc_attr($qrc_tooltipdesign) == 'rightTop' ? 'selected' : '' ?>><?php esc_html_e('Right Top', 'qr-code-composer'); ?></option>    
    <option value="rightCenter" <?php echo esc_attr($qrc_tooltipdesign) == 'rightCenter' ? 'selected' : '' ?>><?php esc_html_e('Right Center', 'qr-code-composer'); ?></option> 

    </select> 
    </p>

    </div>
    </div>
    <?php
    }

/**
 * This function is a callback function of  add seeting field
 */

function wc_qr_alignment()
{

    $options = get_option('qrc_composer_settings');
    $qrc_wc_alignment = isset($options['qrcppagelocation']) ? $options['qrcppagelocation'] : 'inatab';

    ?>
    <select class="select"  name="qrc_composer_settings[qrcppagelocation]" id="qrcppagelocation">
        
    <option value="inatab" <?php echo esc_attr($qrc_wc_alignment) == 'inatab' ? 'selected' : '' ?>><?php esc_html_e('In a tab', 'qrc_composer'); ?></option>
    <option value="endofpmeta" <?php echo esc_attr($qrc_wc_alignment) == 'endofpmeta' ? 'selected' : '' ?>><?php esc_html_e('End of Product Meta', 'qrc_composer'); ?></option>    

    <option value="bellowofcart" <?php echo esc_attr($qrc_wc_alignment) == 'bellowofcart' ? 'selected' : '' ?>><?php esc_html_e('Below the cart button', 'qrc_composer'); ?></option>

     <option value="abvofcart" <?php echo esc_attr($qrc_wc_alignment) == 'abvofcart' ? 'selected' : '' ?>><?php esc_html_e('Above of cart Button', 'qrc_composer'); ?></option>   

    </select>

    <?php
}


    /**
     * Qr background Color field
     */
    function qrc_logo_image()
    { ?>


        <div class="qrcpremiumserttings">
            
            <ul>
                <li>QR eye Design</li>
                <li>Gradient Color</li>
                <li>Logo Upload</li>
            </ul>
        </div>

   <?php }
    /**
     * Qr background Color field
     */
    function qr_bgcolor_management()
    {
        $options = get_option('qrc_composer_settings');

    $bg_value = (isset($options['background'])) ? $options['background'] : 'transparent';
    printf('<input type="text" name="qrc_composer_settings[background]" value="%s"  id="qr_bg" class="qrc-color-picker">',esc_attr($bg_value));

    }

    /**
     *  Qr Color field
     */

    function qr_color_management()
    {
      $options = get_option('qrc_composer_settings');

    $qr_color = (isset($options['qr_color'])) ? $options['qr_color'] : '#000';
    printf('<input type="text" name="qrc_composer_settings[qr_color]" value="%s" class="qrc-color-picker" id="fill">',esc_attr($qr_color));

    }


    function qr_stcode_management()
    {
        printf('<p class="qrcshortvar">
            <input id="qr_stcode_management" type="text" class="shortcodereadoly" value="[qrc_code_composer]" readonly >
            <button type="button" class="qrcclipbtns" data-clipboard-demo data-clipboard-target="#qr_stcode_management" title="copy shortcode"><span class="dashicons dashicons-admin-page"></span></button>
            </p>');

    printf('<div style="width:%s; padding:10px 0px"><em>'.esc_html__('For developer: ','qrc_composer').'<span style="color:#673ab7"><em ><</em>?php echo do_shortcode["qrc_code_composer"];<em>?</em>></<em></span></div>', '90%');

    }

}

