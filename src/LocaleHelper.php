<?php

/**
 * Title: EMS e-Commerce locale helper
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_LocaleHelper {
	/**
	 * Get EMS e-Commerce locale by the specified WordPress locale
	 *
	 * @return string|null
	 */
	public static function transform( $locale ) {
		// Supported locales
		$supported = array(
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::DE_DE,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::EN_GB,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::EN_US,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::ES_ES,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::FI_FI,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::FR_FR,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::IT_IT,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::NL_NL,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::PT_BR,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::ZH_CN,
			Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::ZH_TW,
		);

		// @todo Locale transformation
		// print_r( $locale ); exit;

		// Sub string
		$locale = substr( $locale, 0, 2 );

		// Lower case
		$locale = strtoupper( $locale );

		// Is supported?
		if ( in_array( $locale, $supported, true ) ) {
			return $locale;
		}

		return null;
	}
}
