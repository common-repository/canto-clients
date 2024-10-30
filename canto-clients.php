<?php
/*
 *  Plugin Name: Canto Clients
 *  Plugin URL: http://www.CantoThemes.com
 *  Description: Canto Clients simple and effective clients shortcode.
 *  Author: CantoThemes.com
 *  Version: 1.0
 *  Author URI: http://www.CantoThemes.com
 *  Text Domain: canto-clients
 *  License:     GPL-2.0+
 *  License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
define("CANTO_CLIENTS_PATH", plugin_dir_path(__FILE__));
define('CANTO_CLIENTS_URL', plugin_dir_url( __FILE__ ));
define("CANTO_CLIENTS_TXTDOMAIN", 'canto-clients');


require_once( CANTO_CLIENTS_PATH . 'lib/custom.post.class.php' );

add_action('init', 'canto_clients_post_type');

function canto_clients_post_type(){


    //Testomonial post type
    if(class_exists('Canto_CustomPostType')){
        $testomonials_cptype = array(
            'postType' => 'Clients',
            'txtdomain' => CANTO_CLIENTS_TXTDOMAIN,
            'postTypeDesc' => 'Describe about your service.',
            'postTypePublic' => false,
            'pTypePShowUI' => true,
            'pTypeSupport' => array(
                'title',
                'thumbnail'
            ),
            'pTypeRewrite' => false
        );
        $testomonials = new Canto_CustomPostType($testomonials_cptype);

    }


}
add_action('wp_print_styles','canto_clients_styles');
function canto_clients_styles()
{
    wp_register_style( 'canto-clients', CANTO_CLIENTS_URL . 'css/canto_clients.css', array(), time(), 'all');
}
add_action('wp_print_scripts','canto_clients_scripts');
function canto_clients_scripts()
{
    // front-end css
    wp_register_script( 'jquery-black-and-white', CANTO_CLIENTS_URL . 'js/jquery.BlackAndWhite.min.js', array( 'jquery' ), '1.0', true);
}

if (!function_exists('canto_clients')) {
    function canto_clients($atts, $content = null)
    {
        $default = array(
            'count' => 4,
            'hover' => 1,
        );

        $main_atts = shortcode_atts( $default, $atts );
        extract( $main_atts );

        $hover_class = '';

        if ($hover) {
            $hover_class = 'blackandwhite';
            wp_enqueue_script( 'jquery-black-and-white');
        }
        wp_enqueue_style( 'canto-clients');

        $clients = get_posts( array('post_type'=>'clients', 'showposts'=> $count) );

        $output = '';

        $output .= '<style>';
            $output .= '.canto_clients li{width:'.((100/$count)-1).'%;';
            $output .= ($hover) ? 'cursor:pointer;}' : '}' ;
        $output .= '</style>';        
        $output .= '<ul class="canto_clients clearfix">';
        foreach ($clients as $client) {
            if (has_post_thumbnail( $client->ID )) {
                $thumb = get_post_thumbnail_id( $client->ID );
                $img_url = wp_get_attachment_url( $thumb,'full' );
                $output .= '<li class="'.$hover_class.'">';
                    $output .= '<img src="'.$img_url.'" alt="'.$client->post_title.'" />';
                $output .= '</li>';
            }
            
        }
        $output .= '</ul>';

        return $output;
    }
    add_shortcode( 'canto_clients', 'canto_clients' );
}
?>