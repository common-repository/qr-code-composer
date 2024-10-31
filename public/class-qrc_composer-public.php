<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sharabindu.com
 * @since      2.0.9
 *
 * @package    Qrc_composer
 * @subpackage Qrc_composer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Qrc_composer
 * @subpackage Qrc_composer/public
 * @author     Sharabindu Bakshi <sharabindu86@gmail.com>
 */
class Qrc_composer_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    2.0.9
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    2.0.9
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    public $subdomain;
    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.9
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = plugin_basename(__FILE__);
        $this->version = $version;
    
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    2.0.9
     */
    public function enqueue_styles()
    {
         wp_register_style('qrc-css', QRC_COMPOSER_URL . 'public/css/qrc.css', array() ,$this->version, 'all');
        wp_enqueue_style('qrc-css');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    2.0.9
     */
    public function enqueue_scripts()
    {

         wp_register_script('qrcode-composer', QRC_COMPOSER_URL . 'admin/js/qrcodecomposer.js', array(
            'jquery'
        ) , $this->version, true);

        wp_register_script('qrccreateqr', QRC_COMPOSER_URL . 'public/js/qrcode.js', array(
        'jquery','qrcode-composer'
        ) ,$this->version, true);

        $options1 = get_option('qrc_composer_settings');

        $qrc_size = isset($options1['qr_code_picture_size_width']) ? $options1['qr_code_picture_size_width'] : 200;

        $quiet = isset($options1['quiet']) ? $options1['quiet'] : '0';
        $ecLevel = isset($options1['ecLevel']) ? $options1['ecLevel'] : 'L';
        $cuttenttitlr = get_the_title();

        $background = (isset($options1['background'])) ? $options1['background'] : 'transparent';
        $qr_color = (isset($options1['qr_color'])) ? $options1['qr_color'] : '#000';
        $qrcomspoer_options = array(
            'size' => $qrc_size,
            'color' => $qr_color,
            'background' => $background,
            'quiet' => $quiet,
            'ecLevel' => $ecLevel,
        );
        wp_localize_script( 'qrccreateqr', 'datas', $qrcomspoer_options ); 
    }

    /**
     * This function is display Qr code on frontend.
     */

    public function qcr_code_element($content)
    {
        require QRC_COMPOSER_PATH . 'includes/data/data.php';

        if (!empty($options1)){
            $singlular_exclude = is_singular($options1);
            $single_exclude = is_page($options1);
        }else
        {
            $singlular_exclude = '';
            $single_exclude = '';
        }

        if (($qrc_meta_display == '2') or ($singlular_exclude) or is_singular('product') or ($single_exclude)){
            $content .= '';
        }elseif(function_exists('bp_search_is_search') &&
            bp_search_is_search()){
            $content .= '';
        }else{ 
        $content .= do_shortcode('[qrc_code_composer]');

             }
            return $content;  
    }


    /**
     * This function is Provide for Createing Woocomerce custom product tab for Qr Code
     */

    public function woo_custom_product_tabs($tabs)
    {

        $options = get_option('qrc_composer_settings');

        $qrc_wc_ptab_name = isset($options['qrc_wc_ptab_name']) ? $options['qrc_wc_ptab_name'] : esc_html__('QR Code','qr-code-composer');

        $tabs['qty_pricing_tab'] = array(
            'title' => $qrc_wc_ptab_name ,
            'priority' => 100,
            'callback' => array(
                $this,
                'woo_qrc_tab_content'
            )
        );

        $qrc_meta_display = get_post_meta(get_the_ID() , 'qrc_metabox', true);
      
        if (!empty($options))
        {
            $singlular_wc_exclude = is_singular($options);
        }
        else
        {
            $singlular_wc_exclude = '';
        }

        if (($qrc_meta_display == '2') or ($singlular_wc_exclude))
        {
            return false;
        }
        else
        {
            return $tabs;

        }

    }

    public function woo_qrc_tab_content()
    {
       $content = do_shortcode('[qrc_code_composer]');

        return printf('%s', $content);

    }

}

