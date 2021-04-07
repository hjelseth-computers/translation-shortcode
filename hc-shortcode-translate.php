<?php
/**
 * Plugins primary file, in charge of including all other dependencies.
 *
 * @package HC_Shortcode_Translate
 *
 * @wordpress-plugin
 * Plugin Name: Shortcode Translations
 * Plugin URI: https://www.hcweb.no
 * Description: Allows you to translate chunks of a post or page based on what language is used.
 * Author: Clorith
 * Version: 1.0.0
 * Author URI: https://www.clorith.net
 * Text Domain: hc-shortcode-translate
 */

// Check that the file is nto accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

require_once dirname( __FILE__ ) . '/includes/class-hc-shortcode-translate.php';

new HC_Shortcode_Translate();
