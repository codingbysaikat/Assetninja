<?php

/**
 * Plugin Name:       Assets Management 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Plugin assets management basic plugin
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Saikat Mondal
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       asnj
 * Domain Path:       /languages
 * 
 */
define('ASNJ_ASSETS_DIR',plugin_dir_url(__FILE__)."assets/");
define('ASNJ_NINJA_ASSETS_PUBLIE_DIR',plugin_dir_url(__FILE__)."assets/public");
define('ASNJ_NINJA_ASSETS_ADMIN_DIR',plugin_dir_url(__FILE__)."assets/admin");
define('ASHJ_VERSION',time());
class AssetNinja{
    protected $version;
    function __construct(){
        $this->version = time();
        add_action('plugin_loaded', array($this, 'qrcg_loaded_textdomin'));
        add_action('wp_enqueue_scripts', array($this,'load_fonts_assets'));
        add_action('admin_enqueue_scripts',array($this,'load_admin_assets'));
    } 
    function load_admin_assets($screen){
        $_screen = get_current_screen();
        if('edit.php'== $screen && 'page'== $_screen->post_type){
            wp_enqueue_script('asnj-admin-script',ASNJ_NINJA_ASSETS_ADMIN_DIR.'/js/admin.js',array('jquery'),$this->version,true);
        }
       
    }
    function load_fonts_assets(){
        wp_enqueue_script('asnj-main', ASNJ_NINJA_ASSETS_PUBLIE_DIR."/js/main.js",array('jquery'), $this->version,true);
        //wp_enqueue_script('asnj-another', ASNJ_NINJA_ASSETS_PUBLIE_DIR."/js/another.js", array('jquery','asnj-main'),$this->version,true);
        //wp_enqueue_script('asnj-more',ASNJ_NINJA_ASSETS_PUBLIE_DIR."/js/more.js",array('jquery','asnj-another'), $this->version, true);
        wp_enqueue_style('asnj-main-css',ASNJ_NINJA_ASSETS_PUBLIE_DIR."/css/main.css",null,$this->version);
        // How to send date to the javascript file from PHP
        // exaple now we create a data array

        $js_file = array(
            'asnj-main'=>array('path'=> ASNJ_NINJA_ASSETS_PUBLIE_DIR."/js/main.js", 'dep'=>'jquery')
            

        );
        $data = array(
            'name'=>__('saikat','asnj'),
            'age'=> 24,
            'url'=> esc_url('https://banglashala.com'),
        );
       wp_localize_script('asnj-main','userdata',$data);
    }

    function qrcg_loaded_textdomin(){
        load_plugin_textdomain('asnj', false, dirname(__FILE__ . 'languages'));
    }

}
new AssetNinja();

