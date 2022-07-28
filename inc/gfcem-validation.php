<?php

if (!defined('ABSPATH')) {
	exit;
}

add_filter('gform_field_validation', function ($result, $value, $form, $field) {
    if (!isset($field['gfcemAllowed']) || !$field->gfcemAllowed) {
        return $result;
    }

    if ($field->isRequired && empty($value) && isset($field['inputGFCEMMessageRequired'])) {
        $result['message'] = $field->inputGFCEMMessageRequired;
        return $result;
    }

    if (('email' === $field->type) && !is_email($value)) {
        $result['message'] = 'Prosím vložte validní email';
        return $result;
    }
    return $result;
}, 10, 4);