<div id="mepr-cm-lists" class="mepr-product-adv-item">
  
  <label ><?php _e('Campaign Monitor Lists for this Membership', 'memberpress-cm'); ?></label>
        
  <?php MeprAppHelper::info_tooltip('mpcm-add-lists',
    __('Enable Campaign Monitor List Subscription Membership', 'memberpress-cm'),
    __('Select Campaing list for which you want to register user on subscription', 'memberpress-cm'));
  
require_once MPCM_PATH.'/lib/csrest_general.php';
require_once MPCM_PATH.'/lib/csrest_clients.php';

$auth = array('api_key' => get_option('mpcm_api_key'));
$wrap = new CS_REST_General($auth);

$result = $wrap->get_clients();
$clients= $result->response;

$wrap_client = new CS_REST_Clients(
    $clients[0]->ClientID,
    $auth);
    $result = $wrap_client->get_lists();
  $lists = $result->response;
  ?>
<select name="mpcm_lists" id="mpcm_lists"  class="mepr-text-input form-field">
    <option value=""><?php _e('Select List','memberpress-cm') ?></option>
    <?php 
        foreach($lists as $list){
            ?>
            <option <?php if($listid==$list->ListID){
                echo 'selected="selected"';
            } ?> value="<?php echo $list->ListID; ?>"><?php echo $list->Name ?></option>
            <?php
        }
    ?>
</select>
</div>
<div id="mepr-cm-lists" class="mepr-product-adv-item">
  
  <label ><?php _e('Campaign Monitor Opt-in Checkbox Label', 'memberpress-cm'); ?></label>
  <input type="text" name="mpcm_checkbox_label" id="mpcm_checkbox_label" value="<?php echo $label_campaign_monitor; ?>" size="50">
</div>
<div id="mepr-cm-lists" class="mepr-product-adv-item">
  
  <label ><?php _e('Campaign Monitor Opt-in Legal Note', 'memberpress-cm'); ?></label>
  <textarea style="width:100%" type="text" name="mpcm_text_legal" id="mpcm_text_legal" ><?php echo $mpcm_text_legal; ?></textarea>
</div>