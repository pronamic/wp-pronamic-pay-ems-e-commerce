<?php

/**
 * Title: EMS e-Commerce Gateway locale helper tests
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_EMS_ECommerce_LocaleHelperTest extends PHPUnit_Framework_TestCase {
	/**
	 * Test transform.
	 *
	 * @dataProvider locale_matrix_provider
	 */
	public function test_transform( $locale, $expected ) {
		$transformed = Pronamic_WP_Pay_Gateways_EMS_ECommerce_LocaleHelper::transform( $locale );

		$this->assertEquals( $expected, $transformed );
	}

	public function locale_matrix_provider() {
		return array(
			array( 'de_DE', Pronamic_WP_Pay_Gateways_EMS_ECommerce_Locales::DE_DE ),
			array( 'not existing status', null ),
		);
	}
}
