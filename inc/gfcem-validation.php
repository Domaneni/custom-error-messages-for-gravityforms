<?php

if (!defined('ABSPATH')) {
	exit;
}

add_filter('gform_field_validation', function ($result, $value, $form, $field) {
    if (!isset($field['gfcemAllowed']) || !$field->gfcemAllowed) {
        return $result;
    }

    if ($field->isRequired && isset($field['inputGFCEMMessageRequired'])) {
        if ('checkbox' === $field->type) {
            $all_empty = true;
            foreach ($value as $key => $val) {
                if (!empty($val)) {
                    $all_empty = false;
                    break;
                }
            }

            if ($all_empty) {
                $result['message'] = $field->inputGFCEMMessageRequired;
            }
        } else if (empty($value)) {
            $result['message'] = $field->inputGFCEMMessageRequired;
        }
        return $result;
    }

    if (('email' === $field->type) && !is_email($value) && isset($field['inputGFCEMMessageValidEmail'])) {
        $result['message'] = $field->inputGFCEMMessageValidEmail;
        return $result;
    }

    return $result;
}, 10, 4);

add_filter('gform_duplicate_message', function ($message, $form, $field, $value) {
    if (isset($field['gfcemAllowed']) && $field->gfcemAllowed && !empty($field['inputGFCEMMessageUnique'])) {
        return $field->inputGFCEMMessageUnique;
    }

    return $message;
}, 10, 4);
