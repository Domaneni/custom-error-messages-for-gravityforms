<?php

if (!defined('ABSPATH')) {
	exit;
}

add_action('gform_editor_js', function () {
    wp_enqueue_script('atech_gform_editor_js', GFCEM_PLUGIN_URL . '/assets/gfcem-gform-editor.js', ['jquery'], GFCEM_VERSION);
    wp_localize_script('atech_gform_editor_js', 'gfcem_object', [
        'gfcem_settings' => apply_filters('gfcem_settings_fields', ['text', 'phone', 'number', 'email', 'textarea', 'radio', 'select', 'checkbox', 'name', 'date', 'time', 'address', 'website',
            'file', 'list', 'multiselect', 'consent']),
        'gfcem_not_unique' => apply_filters('gfcem_not_unique_fields', ['checkbox', 'name', 'address', 'file', 'list', 'multiselect', 'consent']),
        'gfcem_rem_title' => __('Required error message', 'gfcem'),
        'gfcem_uem_title' => __('Unique error message', 'gfcem'),
        'gfcem_evem_title' => __('Email validation error message', 'gfcem'),
    ]);
    wp_enqueue_style('atech_gform_editor_css', GFCEM_PLUGIN_URL . '/assets/gfcem-style.css', [], GFCEM_VERSION);
});