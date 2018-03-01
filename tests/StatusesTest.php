<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS_ECommerce;

use Pronamic\WordPress\Pay\Core\Statuses as Core_Statuses;

/**
 * Title: EMS e-Commerce Gateway statuses constants tests
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
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
		return array(
			array( Statuses::OPEN, Core_Statuses::OPEN ),
			array( 'not existing status', null ),
		);
	}
}
