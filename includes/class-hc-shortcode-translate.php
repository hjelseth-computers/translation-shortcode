<?php
/**
 * Class for providing debug data based on a users WordPress environment.
 *
 * @package HC_Shortcode_Translate
 */

/**
 * Class HC_Shortcode_Translate
 */
class HC_Shortcode_Translate {

	/**
	 * Class construct
	 *
	 * Set up WordPress hooks used by the plugin
	 */
	public function __construct() {
		add_shortcode( 'hc-shortcode-translate', array( $this, 'shortcode' ) );
	}

	/**
	 * Function for conditionally displaying content via a shortcode.
	 *
	 * @param array  $atts    The shortcode attributes.
	 * @param string $content The content enclosed in the shortcode.
	 *
	 * @return string
	 */
	public function shortcode( $atts = array(), $content = null ) {
		$atts = shortcode_atts(
			array(
				'lang' => $this->get_default_language(),
			),
			$atts
		);

		// If the current language matches the language attribute, return the content.
		if ( $this->is_current_language( $atts['lang'] ) ) {
			return $content;
		}

		// Return an empty string if the language does not match.
		return '';
	}

	/**
	 * Check if a provided language, in various formats, is the currently viewed language.
	 *
	 * Defaults to `false` if no supporter translation plugins are found.
	 *
	 * @param string $language Language to compare against.
	 *
	 * @return bool
	 */
	private function is_current_language( $language ) {
		if ( function_exists( 'pll_current_language' ) ) {
			if ( strtolower( $language ) === strtolower( pll_current_language() ) ) {
				return true;
			}

			if ( strtolower( $language ) === strtolower( pll_current_language( 'locale' ) ) ) {
				return true;
			}
		}

		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			return strtolower( $language ) === strtolower( ICL_LANGUAGE_CODE );
		}

		return false;
	}

	/**
	 * Returns the sites default language as returned by WordPress.
	 *
	 * Defaults to `en_US` if no supported translation plugins are found.
	 *
	 * @return string
	 */
	private function get_default_language() {
		// Check for the Polylang helper function.
		if ( function_exists( 'pll_default_language' ) ) {
			return pll_default_language( 'locale' );
		}

		// Try to load in WPML.
		global $sitepress;
		if ( is_object( $sitepress ) && method_exists( $sitepress, 'get_default_language' ) ) {
			return $sitepress->get_default_language();
		}

		// No matches found so far, return the default value.
		return 'en_US';
	}
}
