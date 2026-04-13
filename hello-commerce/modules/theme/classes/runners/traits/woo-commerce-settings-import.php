<?php
namespace HelloCommerce\Modules\Theme\Classes\Runners\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait WooCommerce_Settings_Import {

	private $old_values = [];
	private $imported_pages = [];

	public static function get_name(): string {
		return 'woocommerce-settings';
	}

	protected static function get_keys_to_import(): array {
		return [
			'woocommerce_cart_page_id',
			'woocommerce_checkout_page_id',
			'woocommerce_myaccount_page_id',
			'woocommerce_terms_page_id',
			'woocommerce_purchase_summary_page_id',
			'woocommerce_shop_page_id',
		];
	}

	public function should_import( array $data ) {
		return (
			isset( $data['include'] ) &&
			in_array( 'settings', $data['include'], true ) &&
			! empty( $data['site_settings']['settings'] )
		);
	}

	public function import( array $data, array $imported_data ) {
		$new_site_settings = $data['site_settings']['settings'];

		$pages = $imported_data['content']['page']['succeed'];

		$imported = false;

		foreach ( static::get_keys_to_import() as $key ) {
			if ( ! array_key_exists( $key, $new_site_settings ) ) {
				continue;
			}
			$value = $new_site_settings[ $key ];
			if ( isset( $pages[ $value ] ) ) {
				$page = $pages[ $value ];

				$this->old_values[ $key ] = get_option( $key );
				$update_result = update_option( $key, $page );

				if ( $update_result ) {
					$this->imported_pages[ $key ] = $page;
					$imported = true;
				}
			}
		}

		return [ 'woocommerce-settings' => $imported ];
	}

	public function get_import_session_metadata(): array {
		return [
			'previous_pages' => $this->old_values,
			'imported_pages' => $this->imported_pages,
		];
	}
}
