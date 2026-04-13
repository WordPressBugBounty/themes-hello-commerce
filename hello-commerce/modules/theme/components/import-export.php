<?php
namespace HelloCommerce\Modules\Theme\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\App\Modules\ImportExportCustomization\Processes\Import as Elementor_Import_Customization;
use Elementor\App\Modules\ImportExportCustomization\Processes\Revert as Elementor_Revert_Customization;
use Elementor\App\Modules\ImportExport\Processes\Import as Elementor_Import;
use Elementor\App\Modules\ImportExport\Processes\Revert as Elementor_Revert;
use HelloCommerce\Modules\Theme\Classes\Runners\Import as Import_Runner;
use HelloCommerce\Modules\Theme\Classes\Runners\Revert as Revert_Runner;
use HelloCommerce\Modules\Theme\Classes\Runners\Import_Customization as Import_Customization_Runner;
use HelloCommerce\Modules\Theme\Classes\Runners\Revert_Customization as Revert_Customization_Runner;
use HelloCommerce\Includes\Utils;

class Import_Export {
	const MIN_ELEMENTOR_CUSTOMIZATION_VERSION = '3.34.0';

	public function register_import_runners( Elementor_Import $import ) {
		$import->register( new Import_Runner() );
	}

	public function register_revert_runners( Elementor_Revert $revert ) {
		$revert->register( new Revert_Runner() );
	}

	public function register_import_runners_customization( Elementor_Import_Customization $import ) {
		$import->register( new Import_Customization_Runner() );
	}

	public function register_revert_runners_customization( Elementor_Revert_Customization $revert ) {
		$revert->register( new Revert_Customization_Runner() );
	}

	public function __construct() {
		if ( Utils::has_pro() ) {
			return;
		}

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, self::MIN_ELEMENTOR_CUSTOMIZATION_VERSION, '>=' ) ) {
			add_action( 'elementor/import-export-customization/import-kit', [ $this, 'register_import_runners_customization' ] );
			add_action( 'elementor/import-export-customization/revert-kit', [ $this, 'register_revert_runners_customization' ] );
		} else {
			add_action( 'elementor/import-export/import-kit', [ $this, 'register_import_runners' ] );
			add_action( 'elementor/import-export/revert-kit', [ $this, 'register_revert_runners' ] );
		}
	}
}
