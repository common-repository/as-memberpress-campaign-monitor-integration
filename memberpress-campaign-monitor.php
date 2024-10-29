<?php
/*
Plugin Name: AS MemberPress Campaign Monitor Integration
Description: Campaign Monitor Autoresponder integration for MemberPress.
Version: 1.0.0
Author: Akshar Soft Solutions
Author URI: http://aksharsoftsolutions.com/
Text Domain: memberpress-cm
*/

if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

include_once( ABSPATH . 'wp-admin/includes/plugin.php');
  define('MPCM_PLUGIN_NAME','memberpress-campaign-monitor');
  define('MPCM_PATH',WP_PLUGIN_DIR.'/'.MPCM_PLUGIN_NAME);

if(is_plugin_active('memberpress/memberpress.php')):
    
        add_action('mepr_display_autoresponders','mpcm_display_option_fields');
        add_action('mepr-process-options', 'mpcm_store_option_fields');
        add_action('mepr-product-advanced-metabox', 'mpcm_display_membership_options');
        add_action('mepr-product-save-meta',  'mpcm_save_membership_options');
        add_action('mepr-signup',  'mpcm_process_signup');
        add_action('mepr-user-signup-fields','mpcm_display_signup_field');
    
endif;

function mecm_load_language() {
  load_plugin_textdomain( 'memberpress-cm', false, MPCM_PATH.'/languages' );
}
add_action('init', 'mecm_load_language');

function mpcm_display_option_fields(){
    require(MPCM_PATH.'/views/options.php'); 
}

function mpcm_store_option_fields(){
    update_option('mpcm_enabled',        (int)(sanitize_text_field($_POST['mpcm_enabled'])));
    update_option('mpcm_api_key', stripslashes(sanitize_text_field($_POST['mpcm_api_key'])));
    update_option('mpcm_hide_checkbox', (int)(sanitize_text_field($_POST['mpcm_hide_checkbox'])));
}

function mpcm_display_membership_options($product){
    
    if(get_option('mpcm_enabled')!=1){return;} 
    if(get_option('mpcm_api_key')==''){return;}   
    
    $listid = get_post_meta($product->ID, 'mpcm_lists',true);
    $label_campaign_monitor = get_post_meta($product->ID, 'mpcm_checkbox_label',true);
    $label_campaign_monitor = ($label_campaign_monitor!='')?$label_campaign_monitor:"Sign Up for the Newsletter";
    $mpcm_text_legal = get_post_meta($product->ID,'mpcm_text_legal',true);
    require(MPCM_PATH.'/views/membership.php'); 
}

function mpcm_save_membership_options($product){
    update_post_meta($product->ID, 'mpcm_lists', sanitize_title($_POST['mpcm_lists']));
    update_post_meta($product->ID, 'mpcm_checkbox_label', sanitize_text_field($_POST['mpcm_checkbox_label']));
    update_post_meta($product->ID, 'mpcm_text_legal',   sanitize_textarea_field($_POST['mpcm_text_legal']));
}

function mpcm_process_signup( $txn ) {
    if(get_option('mpcm_enabled')!=1){return;} 
    if(get_option('mpcm_api_key')==''){return;}   
    
    if($_POST['mpcm_opt_in']!='on' &&get_option('mpcm_hide_checkbox')!=1){
        return;    
    }
    
    $prd = $txn->product();
    
    $listid= get_post_meta( $prd->ID, 'mpcm_lists', true );
    
    if($listid==''){return;}
  
    $contact        = $txn->user();

    require_once MPCM_PATH.'/lib/csrest_subscribers.php';
    require_once MPCM_PATH.'/lib/csrest_lists.php';
    $auth = array('api_key' => get_option('mpcm_api_key'));
    
    
    
    $wrap = new CS_REST_Subscribers($listid, $auth);
    $result = $wrap->add(array(
        'EmailAddress' => $contact->user_email,
        'Name' =>  $contact->first_name.' '. $contact->last_name,
        'ConsentToTrack' => 'yes',
        'Resubscribe' => true
    ));
   
 
  }
  
function mpcm_display_signup_field(){
  
    if(get_option('mpcm_enabled')!=1){return;} 
    if(get_option('mpcm_api_key')==''){return;}  
    if(get_option('mpcm_hide_checkbox')==1){return;}
    $mepr_options = MeprOptions::fetch();
    $post         = MeprUtils::get_current_post();
     $listid= get_post_meta( $post->ID, 'mpcm_lists', true );
    
    if($listid==''){return;}
    $optin = $optin = $mepr_options->opt_in_checked_by_default;
    $mpcm_label = get_post_meta($post->ID, 'mpcm_checkbox_label',true); 
    $mpcm_text_legal = get_post_meta($post->ID, 'mpcm_text_legal',true); 
    require(MPCM_PATH.'/views/opt-in.php'); 
}