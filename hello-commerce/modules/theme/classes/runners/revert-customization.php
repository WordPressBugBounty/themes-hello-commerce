<?php
namespace HelloCommerce\Modules\Theme\Classes\Runners;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\App\Modules\ImportExportCustomization\Runners\Revert\Revert_Runner_Base;
use HelloCommerce\Modules\Theme\Classes\Runners\Traits\WooCommerce_Settings_Revert;

class Revert_Customization extends Revert_Runner_Base {
	use WooCommerce_Settings_Revert;
}
