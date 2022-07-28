<?php

if (!defined('ABSPATH')) {
	exit;
}

add_action('gform_field_advanced_settings', function($placement, $form_id) {
    if (-1 === $placement) {
        ?>
        <li class="gfcemAllowed_field_setting field_setting" style="display: list-item">
            <input type="checkbox" id="field_gfcemAllowed" onclick="SetFieldProperty('gfcemAllowed', this.checked); ToggleInputName()" onkeypress="SetFieldProperty('gfcemAllowed', this.checked); ToggleInputName()"/>
            <label for="field_gfcemAllowed" class="inline"><?php esc_html_e( 'Allow custom error messages', 'gfcem' ) ?></label>
            <br/>
            <div id="field_input_name_container" style="display:none; padding-top:10px;">
                <!-- content dynamically created from js.php -->
            </div>
        </li>
        <?php
    }
}, 10, 2);