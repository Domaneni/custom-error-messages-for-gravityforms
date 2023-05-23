<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Validate required field option
 */
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

    return $result;
}, 10, 4);

/**
 * Validate email field
 */
add_filter('gform_field_validation', function ($result, $value, $form, $field) {
    if (!isset($field['gfcemAllowed']) || !$field->gfcemAllowed) {
        return $result;
    }

    if ('email' === $field->type) {
        $email = is_array( $value ) ? rgar( $value, 0 ) : $value;

        if (!is_email(trim($email)) && isset($field['inputGFCEMMessageValidEmail'])) {
            $result['message'] = $field->inputGFCEMMessageValidEmail;
            return $result;
        }

        if ($field->emailConfirmEnabled && !empty($email) && isset($field['inputGFCEMMessageConfirmEmail']) ) {
            $confirm = is_array($email) ? rgar($email, 1) : $field->get_input_value_submission('input_' . $field->id . '_2');
            if ($confirm != $email) {
                $result['message'] = $field->inputGFCEMMessageConfirmEmail;
                return $result;
            }
        }
    }

    return $result;
}, 10, 5);

add_filter('gform_duplicate_message', function ($message, $form, $field, $value) {
    if (isset($field['gfcemAllowed']) && $field->gfcemAllowed && !empty($field['inputGFCEMMessageUnique'])) {
        return $field->inputGFCEMMessageUnique;
    }

    return $message;
}, 10, 4);
