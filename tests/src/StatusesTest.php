<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Payments\PaymentStatus as Core_Statuses;

/**
 * Title: EMS e-Commerce Gateway statuses constants tests
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 2.0.4
 * @since 1.0.0
 */
class StatusesTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test transform.
	 *
	 * @dataProvider status_matrix_provider
	 */
	public function test_transform( $ems_status, $expected ) {
		$status = Statuses::transform( $ems_status );

		$this->assertEquals( $expected, $status );
	}

	public function status_matrix_provider() {
		return [
			[ Statuses::OPEN, Core_Statuses::OPEN ],
			[ 'not existing status', null ],
		];
	}
}
