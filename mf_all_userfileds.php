<?php

/**
 * Plugin Name:       All User Fields
 * Plugin URI:        https://mario-flores.com
 * Description:       Show all user fields
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Mario Flores
 * Author URI:        https://mario-flores.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mf_user_concent
 * Domain Path:       /languages
 */

add_shortcode('mf_all_userfields', 'mf_get_users');

function mf_get_users()
{
    global $wpdb;
    $settings = get_option('mf_all_userfields');
    $columns = $settings['fields'];
    $user = $wpdb->get_results("select * from wp_users", ARRAY_A);
    $meta_data = get_option('wpcf-usermeta');
    ob_start();
    include(plugin_dir_path(__FILE__) . 'views/list.php');
    return  ob_get_clean();
}

add_action('admin_menu', 'mf_all_userfields_menu');
function mf_all_userfields_menu()
{
    add_options_page('All User Fields', 'MF User Fields', 'manage_options', 'mf-all-userfields', 'mf_all_userfields_settings');
}

function mf_all_userfields_settings()
{
    include(plugin_dir_path(__FILE__) . 'views/settings.php');
}

add_action('admin_init', 'mf_all_userfields_init');

function mf_all_userfields_init()
{
    add_settings_section('mf_all_userfields', 'MF All User Fields', '', 'mf-all-userfields');
    register_setting('mf_all_userfields', 'mf_all_userfields');
    add_settings_field('mf_user_active_fields', 'Fields to display in list', 'mf_active_fields_input', 'mf-all-userfields',  'mf_all_userfields');
}

function mf_active_fields_input()
{
    global $wpdb;
    $settings = get_option('mf_all_userfields');
    $fields = $wpdb->get_results("select Distinct(meta_key) from {$wpdb->prefix}usermeta", ARRAY_A);
    $html = '';
    foreach ($fields as $f) {
        $checked = false;
        if (!empty($settings['fields'])) {
            foreach ($settings['fields'] as $s) {
                if ($s == $f['meta_key']) {
                    $checked = true;
                    break;
                }
            }
        }

        $html .= '<input';
        if ($checked) {
            $html .= ' checked ';
        }
        $html .= ' type="checkbox" name="mf_all_userfields[fields][]" value="' . $f['meta_key'] . '">' . $f['meta_key'] . '<br />';
    }
    echo $html;
}

add_action('wp_enqueue_scripts', 'mf_all_userfields_scripts'); 
function mf_all_userfields_scripts(){
    wp_enqueue_script( 'datatables', '//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js', array( 'jquery' ) );
    wp_enqueue_style( 'datatables-style', '//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css' );

    wp_enqueue_script( 'dataTables.buttons', 'https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'jszip.min', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js' , array( 'jquery' ) );
    wp_enqueue_script( 'pdfmake.min', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array( 'jquery' )  );
    wp_enqueue_script( 'dvfs_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js' , array( 'jquery' ) );
    wp_enqueue_script( 'buttons.html5', 'https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js' , array( 'jquery' ) );
    wp_enqueue_script( 'buttons.print', 'https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js' , array( 'jquery' ) );
}