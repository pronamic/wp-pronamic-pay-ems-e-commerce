<?php

namespace Pronamic\WordPress\Pay\Gateways\EMS\ECommerce;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethod;
use Pronamic\WordPress\Pay\Core\PaymentMethods as Core_PaymentMethods;
use Pronamic\WordPress\Pay\Payments\PaymentStatus;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: EMS e-Commerce
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author Reüel van der Steege
 * @version 3.0.1
 * @since 1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Client.
	 *
	 * @var Client
	 */
	protected $client;

	/**
	 * Config.
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Constructs and initializes an EMS e-Commerce gateway
	 *
	 * @param Config $config Config.
	 * @return void
	 */
	public function __construct( Config $config ) {
		parent::__construct();

		$this->config = $config;

		$this->set_method( self::METHOD_HTML_FORM );

		// Client.
		$this->client = new Client();

		$this->client->set_action_url( $config->get_action_url() );
		$this->client->set_storename( (string) $config->storename );
		$this->client->set_secret( (string) $config->secret );

		// Methods.
		$this->register_payment_method( new PaymentMethod( Core_PaymentMethods::BANCONTACT ) );
		$this->register_payment_method( new PaymentMethod( Core_PaymentMethods::IDEAL ) );
		$this->register_payment_method( new PaymentMethod( Core_PaymentMethods::PAYPAL ) );
		$this->register_payment_method( new PaymentMethod( Core_PaymentMethods::SOFORT ) );
	}

	/**
	 * Start
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 *
	 * @see Core_Gateway::start()
	 */
	public function start( Payment $payment ) {
		$payment->set_action_url( $this->client->get_action_url() );
	}

	/**
	 * Get the output HTML
	 *
	 * @param Payment $payment Payment.
	 * @return array<string, string>
	 *
	 * @see     Core_Gateway::get_output_html()
	 * @since   1.0.0
	 * @version 2.0.4
	 */
	public function get_output_fields( Payment $payment ) {
		$this->client->set_payment_id( (string) $payment->get_id() );
		$this->client->set_currency_numeric_code( (string) $payment->get_total_amount()->get_currency()->get_numeric_code() );
		$this->client->set_order_id( $payment->format_string( (string) $this->config->order_id ) );
		$this->client->set_return_url( home_url( '/' ) );
		$this->client->set_notification_url( home_url( '/' ) );
		$this->client->set_amount( $payment->get_total_amount() );
		$this->client->set_issuer_id( $payment->get_meta( 'issuer' ) );

		// Language.
		$customer = $payment->get_customer();

		if ( null !== $customer ) {
			$locale = $customer->get_locale();

			if ( null !== $locale ) {
				$this->client->set_language( $locale );
			}
		}

		// Payment method.
		$payment_method = PaymentMethods::transform( $payment->get_payment_method() );

		if ( null === $payment_method && '' !== $payment->get_payment_method() ) {
			// Leap of faith if the WordPress payment method could not transform to a EMS method?
			$payment_method = $payment->get_payment_method();
		}

		if ( null !== $payment_method ) {
			$this->client->set_payment_method( $payment_method );
		}

		return $this->client->get_fields();
	}

	/**
	 * Update status of the specified payment
	 *
	 * @param Payment $payment Payment.
	 * @return void
	 */
	public function update_status( Payment $payment ) {
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( ! \array_key_exists( 'approval_code', $_POST ) ) {
			return;
		}

		$approval_code = \sanitize_text_field( \wp_unslash( $_POST['approval_code'] ) );

		$input_hash = null;

		$hash_values = [];

		if ( \array_key_exists( 'response_hash', $_POST ) ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Use raw hash input in comparison.
			$input_hash = \wp_unslash( $_POST['response_hash'] );

			$hash_values = [
				$this->client->get_secret(),
				$approval_code,
				array_key_exists( 'chargetotal', $_POST ) ? \sanitize_text_field( \wp_unslash( $_POST['chargetotal'] ) ) : '',
				array_key_exists( 'currency', $_POST ) ? \sanitize_text_field( \wp_unslash( $_POST['currency'] ) ) : '',
				array_key_exists( 'txndatetime', $_POST ) ? \sanitize_text_field( \wp_unslash( $_POST['txndatetime'] ) ) : '',
				$this->client->get_storename(),
			];
		}

		if ( \array_key_exists( 'notification_hash', $_POST ) ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Use raw hash input in comparison.
			$input_hash = \wp_unslash( $_POST['notification_hash'] );

			$hash_values = [
				array_key_exists( 'chargetotal', $_POST ) ? \sanitize_text_field( \wp_unslash( $_POST['chargetotal'] ) ) : '',
				$this->client->get_secret(),
				array_key_exists( 'currency', $_POST ) ? \sanitize_text_field( \wp_unslash( $_POST['currency'] ) ) : '',
				array_key_exists( 'txndatetime', $_POST ) ? \sanitize_text_field( \wp_unslash( $_POST['txndatetime'] ) ) : '',
				$this->client->get_storename(),
				$approval_code,
			];
		}

		if ( null === $input_hash || empty( $hash_values ) ) {
			return;
		}

		$hash = Client::compute_hash( $hash_values );

		// Check if the posted hash is equal to the calculated response or notification hash.
		if ( 0 !== strcasecmp( $input_hash, $hash ) ) {
			return;
		}

		$response_code = substr( $approval_code, 0, 1 );

		switch ( $response_code ) {
			case 'Y':
				$status = PaymentStatus::SUCCESS;

				break;
			case 'N':
				$status = PaymentStatus::FAILURE;

				$fail_code = \array_key_exists( 'fail_rc', $_POST ) ? filter_var( $_POST['fail_rc'], \FILTER_SANITIZE_NUMBER_INT ) : '';

				if ( '5993' === $fail_code ) {
					$status = PaymentStatus::CANCELLED;
				}

				break;
			default:
				$status = PaymentStatus::OPEN;

				break;
		}

		$payment->set_status( $status );

		// Transaction ID.
		if ( array_key_exists( 'endpointTransactionId', $_POST ) ) {
			$transaction_id = \sanitize_text_field( \wp_unslash( $_POST['endpointTransactionId'] ) );

			$payment->set_transaction_id( $transaction_id );
		}

		// Add payment note.
		$labels = [
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
		];

		$note = sprintf(
			'<p>%s</p',
			\__( 'EMS e-Commerce transaction data in response message:', 'pronamic_ideal' )
		);

		$note .= '<dl>';

		foreach ( $labels as $key => $label ) {
			if ( ! \array_key_exists( $key, $_POST ) ) {
				continue;
			}

			$note .= sprintf(
				'<dt>%s</dt><dd>%s</dd>',
				\esc_html( $label ),
				\esc_html( \sanitize_text_field( \wp_unslash( $_POST[ $key ] ) ) )
			);
		}

		$note .= '</dl>';

		$payment->add_note( $note );

		// phpcs:enable WordPress.Security.NonceVerification.Missing
	}
}
