<?php
/**
 * REM countries ref from WooCommerce countries class
 * @since 10.8.8
 */

defined( 'ABSPATH' ) || exit;

/**
 * The REM countries class stores country/state data.
 */
class REM_Countries {

	/**
	 * Auto-load in-accessible properties on demand.
	 *
	 * @param  mixed $key Key.
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( 'countries' === $key ) {
			return $this->get_countries();
		} elseif ( 'states' === $key ) {
			return $this->get_states();
		}
	}

	/**
	 * Get all countries.
	 *
	 * @return array
	 */
	public function get_countries() {
		if ( empty( $this->countries ) ) {
			$this->countries = apply_filters( 'rem_countries', include REM_PATH . '/inc/admin/countries.php' );
		}

		return $this->countries;
	}

	/**
	 * Check if a given code represents a valid ISO 3166-1 alpha-2 code for a country known to us.
	 *
	 * @since 10.8.8
	 * @param string $country_code The country code to check as a ISO 3166-1 alpha-2 code.
	 * @return bool True if the country is known to us, false otherwise.
	 */
	public function country_exists( $country_code ) {
		return isset( $this->get_countries()[ $country_code ] );
	}

	/**
	 * Get the states for a country.
	 *
	 * @param  string $cc Country code.
	 * @return false|array of states
	 */
	public function get_states( $cc = null ) {
		if ( ! isset( $this->states ) ) {
			$this->states = apply_filters( 'rem_states', include REM_PATH . '/inc/admin/states.php' );
		}

		if ( ! is_null( $cc ) ) {
			return isset( $this->states[ $cc ] ) ? $this->states[ $cc ] : false;
		} else {
			return $this->states;
		}
	}
}
