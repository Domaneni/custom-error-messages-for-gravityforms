<?php

if (!defined('ABSPATH')) {
	exit;
}

add_filter('gform_field_validation', function ($result, $value, $form, $field) {
    if (!isset($field['gfcemAllowed']) || !$field->gfcemAllowed) {
        return $result;
    }

    if ('email' === $field->type) {
        var_dump($field);
        if (empty($value)) {
            $result['message'] = 'Email by neměl být prázdný';
        } else {
            $result['message'] = 'Prosím vložte validní email';
        }
    }
    return $result;
}, 10, 4);