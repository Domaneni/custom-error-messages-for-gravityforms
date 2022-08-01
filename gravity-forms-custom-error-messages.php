<?php
/**
 * Plugin Name: GravityForms - Custom Error Messages
 * Plugin URI: https://domaneni.cz/gfcem
 * Description: Adds custom error messages to GravityForms inputs
 * Version: 1.0.0
 * Author: Zbynek Nedoma
 * Author URI: https://domaneni.cz/
 * License: GPL 3
 * Plugin Slug: gfcem
 */


if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('GravityFormsCustomErrorMessages')) {

	/**
	 * Main GravityFormsCustomErrorMessages Class.
	 *
	 */
	final class GravityFormsCustomErrorMessages {

        /**
         * @var GravityFormsCustomErrorMessages
         */
        private static $instance;

		/**
		 * Main GravityFormsCustomErrorMessages Instance.
		 *
		 * Insures that only one instance of GravityFormsCustomErrorMessages exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @static
		 * @staticvar array $instance
		 * @see GFCEM()
		 * @return object|GravityFormsCustomErrorMessages
		 */
		public static function instance() {
			if (!isset(self::$instance) && !(self::$instance instanceof GravityFormsCustomErrorMessages)) {
				self::$instance = new GravityFormsCustomErrorMessages;
				self::$instance->setup_constants();
				self::$instance->includes();
                self::$instance->support();
                self::$instance->enqueue_scripts();
			}

			return self::$instance;
		}


		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'gfcem'), '1.0.0');
		}


		/**
		 * Disable unserializing of the class.
		 *
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'gfcem'), '1.0.0');
		}


		private function setup_constants() {
			define('GFCEM_SLUG', 'gfcem');
			define('GFCEM_VERSION', '1.0.0');
			// Plugin Root File.
			if (!defined('GFCEM_PLUGIN_FILE')) {
				define('GFCEM_PLUGIN_FILE', __FILE__);
			}

			define('GFCEM_PLUGIN_PATH', dirname(__FILE__));
			define('GFCEM_PLUGIN_BASENAME', plugin_basename(__FILE__));
			define('GFCEM_PLUGIN_URL', plugin_dir_url(__FILE__));
			define('GFCEM_PLUGIN_DIR', plugin_dir_path(__FILE__));
		}


		/**
		 * Include required files.
		 *
		 * @access private
		 * @return void
		 */
		private function includes() {
			require_once GFCEM_PLUGIN_PATH . '/inc/gfcem-setting-fields.php';
			require_once GFCEM_PLUGIN_PATH . '/inc/gfcem-validation.php';
		}

        private function support() {
            add_filter('plugin_action_links_' . GFCEM_PLUGIN_BASENAME, function  ($actions) {
                $custom_links = [
                    'support' => '<a href="https://ko-fi.com/domaneni" target="_blank">Support</a>',
                ];

                return array_merge( $actions, $custom_links );
            }, 10, 1);
        }

        private function enqueue_scripts() {
            add_action('gform_editor_js', function () {
                wp_enqueue_script('gfcem_gform_editor_js', GFCEM_PLUGIN_URL . '/assets/gfcem-gform-editor.js', ['jquery'], GFCEM_VERSION);
                wp_localize_script('gfcem_gform_editor_js', 'gfcem_object', [
                    'gfcem_settings' => apply_filters('gfcem_settings_fields', ['text', 'phone', 'number', 'email', 'textarea', 'radio', 'select', 'checkbox', 'name', 'date', 'time', 'address', 'website',
                        'file', 'list', 'multiselect', 'consent']),
                    'gfcem_not_unique' => apply_filters('gfcem_not_unique_fields', ['checkbox', 'name', 'address', 'file', 'list', 'multiselect', 'consent']),
                    'gfcem_rem_title' => __('Required error message', 'gfcem'),
                    'gfcem_uem_title' => __('Unique error message', 'gfcem'),
                    'gfcem_evem_title' => __('Email validation error message', 'gfcem'),
                ]);
                wp_enqueue_style('gfcem_gform_editor_css', GFCEM_PLUGIN_URL . '/assets/gfcem-style.css', [], GFCEM_VERSION);
            });
        }
	}
}

function GFCEM() {
	return GravityFormsCustomErrorMessages::instance();
}

// Get GFCEM Running.
if (class_exists('GravityFormsCustomErrorMessages')) {
    GFCEM();
}