<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods as Core_PaymentMethods;
use Pronamic\WordPress\Pay\Core\Statuses;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: EMS e-Commerce
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 1.0.4
 * @since 1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Constructs and initializes an EMS e-Commerce gateway
	 *
	 * @param Config $config
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->set_method( Gateway::METHOD_HTML_FORM );
		$this->set_has_feedback( true );
		$this->set_amount_minimum( 0.01 );

		// Client
		$this->client = new Client();

		$action_url = Client::ACTION_URL_PRODUCTION;

		if ( Gateway::MODE_TEST === $config->mode ) {
			$action_url = Client::ACTION_URL_TEST;
		}

		$this->client->set_action_url( $action_url );
		$this->client->set_storename( $config->storename );
		$this->client->set_secret( $config->secret );
	}

	/**
	 * Get supported payment methods.
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_supported_payment_methods()
	 */
	public function get_supported_payment_methods() {
		return array(
			Core_PaymentMethods::BANCONTACT,
			Core_PaymentMethods::IDEAL,
			Core_PaymentMethods::PAYPAL,
			Core_PaymentMethods::SOFORT,
		);
	}

	/**
	 * Start
	 *
	 * @see Pronamic_WP_Pay_Gateway::start()
	 *
	 * @param Payment $payment
	 */
	public function start( Payment $payment ) {
		$payment->set_action_url( $this->client->get_action_url() );

		$this->client->set_payment_id( $payment->get_id() );
		$this->client->set_language( $payment->get_locale() );
		$this->client->set_currency_numeric_code( $payment->get_currency_numeric_code() );
		$this->client->set_order_id( Util::get_order_id( $this->config->order_id, $payment ) );
		$this->client->set_return_url( home_url( '/' ) );
		$this->client->set_notification_url( home_url( '/' ) );
		$this->client->set_amount( $payment->get_amount() );
		$this->client->set_issuer_id( $payment->get_issuer() );

		$payment_method = PaymentMethods::transform( $payment->get_method() );

		if ( null === $payment_method && '' !== $payment->get_method() ) {
			// Leap of faith if the WordPress payment method could not transform to a EMS method?
			$payment_method = $payment->get_method();
		}

		$this->client->set_payment_method( $payment_method );
	}

	/**
	 * Get the output HTML
	 *
	 * @since 1.0.0
	 * @see Pronamic_WP_Pay_Gateway::get_output_html()
	 */
	public function get_output_fields() {
		return $this->client->get_fields();
	}

	/**
	 * Update status of the specified payment
	 *
	 * @param Payment $payment
	 */
	public function update_status( Payment $payment ) {
		$approval_code = filter_input( INPUT_POST, 'approval_code', FILTER_SANITIZE_STRING );

		$input_hash = filter_input( INPUT_POST, 'response_hash' );

		$hash_values = array(
			$this->client->get_secret(),
			$approval_code,
			filter_input( INPUT_POST, 'chargetotal', FILTER_SANITIZE_STRING ),
			filter_input( INPUT_POST, 'currency', FILTER_SANITIZE_STRING ),
			filter_input( INPUT_POST, 'txndatetime', FILTER_SANITIZE_STRING ),
			$this->client->get_storename(),
		);

		if ( filter_has_var( INPUT_POST, 'notification_hash' ) ) {
			$input_hash = filter_input( INPUT_POST, 'notification_hash' );

			$hash_values = array(
				filter_input( INPUT_POST, 'chargetotal', FILTER_SANITIZE_STRING ),
				$this->client->get_secret(),
				filter_input( INPUT_POST, 'currency', FILTER_SANITIZE_STRING ),
				filter_input( INPUT_POST, 'txndatetime', FILTER_SANITIZE_STRING ),
				$this->client->get_storename(),
				$approval_code,
			);
		}

		$hash = Client::compute_hash( $hash_values );

		// Check if the posted hash is equal to the calculated response or notification hash
		if ( 0 === strcasecmp( $input_hash, $hash ) ) {
			$response_code = substr( $approval_code, 0, 1 );

			switch ( $response_code ) {
				case 'Y' :
					$status = Statuses::SUCCESS;

					break;
				case 'N':
					$status = Statuses::FAILURE;

					$fail_code = filter_input( INPUT_POST, 'fail_rc', FILTER_SANITIZE_NUMBER_INT );

					if ( '5993' === $fail_code ) {
						$status = Statuses::CANCELLED;
					}

					break;

				default:
					$status = Statuses::OPEN;

					break;
			}

			// Set the status of the payment
			$payment->set_status( $status );

			$labels = array(
				'approval_code'           => __( 'Approval code', 'pronamic_ideal' ),
				'oid'                     => __( 'Order ID', 'pronamic_ideal' ),
				'refnumber'               => _x( 'Reference number', 'creditcard', 'pronamic_ideal' ),
				'status'                  => __( 'Status', 'pronamic_ideal' ),
				'txndate_processed'       => __( 'Time of transaction processing', 'pronamic_ideal' ),
				'tdate'                   => __( 'Identification for transaction', 'pronamic_ideal' ),
				'fail_reason'             => __( 'Fail reason', 'pronamic_ideal' ),
				'response_hash'           => __( 'Response hash', 'pronamic_ideal' ),
				'processor_response_code' => __( 'Processor response code', 'pronamic_ideal' ),
				'fail_rc'                 => __( 'Fail code', 'pronamic_ideal' ),
				'terminal_id'             => __( 'Terminal ID', 'pronamic_ideal' ),
				'ccbin'                   => __( 'Creditcard issuing bank', 'pronamic_ideal' ),
				'cccountry'               => __( 'Creditcard country', 'pronamic_ideal' ),
				'ccbrand'                 => __( 'Creditcard brand', 'pronamic_ideal' ),
			);

			$note = '';

			$note .= '<p>';
			$note .= __( 'EMS e-Commerce transaction data in response message:', 'pronamic_ideal' );
			$note .= '</p>';

			$note .= '<dl>';

			foreach ( $labels as $key => $label ) {
				if ( filter_has_var( INPUT_POST, $key ) ) {
					$note .= sprintf( '<dt>%s</dt>', esc_html( $label ) );
					$note .= sprintf( '<dd>%s</dd>', esc_html( filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING ) ) );
				}
			}

			$note .= '</dl>';

			$payment->add_note( $note );
		}
	}
}
