<?php
namespace HelloCommerce\Modules\Theme\Classes\Runners\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait WooCommerce_Settings_Revert {

	public static function get_name(): string {
		return 'woocommerce-settings';
	}

	public function should_revert( array $data ): bool {
		return isset( $data['runners'][ static::get_name() ] );
	}

	public function revert( array $data ) {
		$data = $data['runners'][ static::get_name() ];

		$previous_pages = $data['previous_pages'];

		foreach ( $previous_pages as $key => $value ) {
			update_option( $key, $value );
		}
	}
}
