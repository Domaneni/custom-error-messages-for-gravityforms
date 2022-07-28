<?php

if (!defined('ABSPATH')) {
	exit;
}

add_action('gform_editor_js', function () {
    wp_enqueue_script('atech_gform_editor_js', GFCEM_PLUGIN_URL . '/assets/gfcem-gform-editor.js', ['jquery'], GFCEM_VERSION);
});