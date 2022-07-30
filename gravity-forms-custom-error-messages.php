<?php
/**
 * Plugin Name: Gravity Forms - Custom Error Messages
 * Plugin URI: https://domaneni.cz/gfcem
 * Description: Adds custom error messages to GravityForms inputs
 * Version: 1.0.0
 * Author: Zbyněk Nedoma
 * Author URI: https://domaneni.cz/
 * License: A "Slug" license name e.g. GPL12
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
			require_once GFCEM_PLUGIN_PATH . '/inc/gfcem-enqueue-scripts.php';
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
	}
}

function GFCEM() {
	return GravityFormsCustomErrorMessages::instance();
}

// Get GFCEM Running.
if (class_exists('GravityFormsCustomErrorMessages')) {
    GFCEM();
}