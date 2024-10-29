<div id="mepr-campaign-monitor" class="mepr-autoresponder-config">
  <input type="checkbox" name="mpcm_enabled" id="mpcm_enabled" <?php checked(get_option('mpcm_enabled')); ?> />
  <label for="mpcm_enabled"><?php _e('Enable Campaign Monitor', 'memberpress-cm'); ?></label>
</div>
<div id="mpcm_hidden_area" class="mepr-options-sub-pane">
  <div id="mpcm-api-key">
    <label>
      <span><?php _e('Campaign Monitor API Key:', 'memberpress-cm'); ?></span>
      <input type="text" name="mpcm_api_key" id="mpcm_api_key" value="<?php echo (get_option('mpcm_api_key')); ?>" class="mepr-text-input form-field" size="90" />
    </label>
    <div>
      <span class="description">
        <?php _e('You can find your API key under your Account settings at createsend.com.', 'memberpress-cm'); ?>
      </span>
    </div>
  </div>
  
</div>
<div id="mpcm_hidden_area" class="mepr-options-sub-pane">
  <div id="mpcm-api-key">
    <label  for="mpcm_hide_checkbox">
       <span><?php _e('Hide Opt In Check box on Sign Up Page', 'memberpress-cm'); ?></span>
    </label>
      <input type="checkbox" name="mpcm_hide_checkbox" id="mpcm_hide_checkbox" <?php echo checked(get_option('mpcm_hide_checkbox')); ?> class="mepr-text-input form-field" size="90" />
   
   
  </div>
  
</div>