<?php

/**
 * Title: EMS e-Commerce integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2017
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_Integration extends Pronamic_WP_Pay_Gateways_AbstractIntegration {
	public function __construct() {
		$this->id            = 'ems-ecommerce';
		$this->name          = 'EMS e-Commerce';
		$this->product_url   = '';
		$this->dashboard_url = array(
			__( 'test', 'pronamic_ideal' ) => 'https://test.ipg-online.com/vt/login',
			__( 'live', 'pronamic_ideal' ) => 'https://www.ipg-online.com/vt/login',
		);
		$this->provider      = 'ems';

		// Actions
		$function = array( 'Pronamic_WP_Pay_Gateways_EMS_ECommerce_Listener', 'listen' );

		if ( ! has_action( 'wp_loaded', $function ) ) {
			add_action( 'wp_loaded', $function );
		}
	}

	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_EMS_ECommerce_ConfigFactory';
	}

	public function get_settings_class() {
		return 'Pronamic_WP_Pay_Gateways_EMS_ECommerce_Settings';
	}

	/**
	 * Get required settings for this integration.
	 *
	 * @see https://github.com/wp-premium/gravityforms/blob/1.9.16/includes/fields/class-gf-field-multiselect.php#L21-L42
	 * @since 1.0.0
	 * @return array
	 */
	public function get_settings() {
		$settings = parent::get_settings();

		$settings[] = 'ems_ecommerce';

		return $settings;
	}
}
