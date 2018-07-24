<?php

namespace StudentRadio\HonoraryLifeMembers;

use StudentRadio\AwardWinners\Importers\AwardsOneImporter;
use StudentRadio\AwardWinners\Importers\Handlers\WPFileUploadHandler;

/**
 * Class Plugin
 *
 * @package StudentRadio\AwardWinners
 */
class Plugin extends BaseController {

	/**
	 * @var
	 */
	private $post_type;
	const PLUGIN_NAME = 'sra-honorary-members';
	CONST POST_TYPE_KEY = 'sra-honorary-member';

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->runUpdateChecker( self::PLUGIN_NAME);
		add_action( 'admin_menu', array($this,'register_my_custom_menu_page') );
		add_action( 'post_updated', array($this,'on_delete_winner'), 10, 3 );
		$this->Shortcodes();
	}

	public function Shortcodes() {
		new Shortcodes\DisplayHonMembers();
	}

	/**
	 *
	 */
	public function register_my_custom_menu_page() {
		add_submenu_page("edit.php?post_type=sra-award-winner", "Importer", "Import Winners", "manage_options", "importer.php", array($this, 'importer_page'));
	}

	/**
	 * @param int $year
	 *
	 * @return bool
	 * @throws \Exception
	 */
	private function validateForm(int $year) {
		if ($year > date("Y") || $year < 2000) {
			throw new \Exception("That Year is not accepted", 406);
			return false;
		}
		return true;
	}

	/**
	 * @throws \Exception
	 */
	public function importer_page() {
		if ($_POST && isset($_POST['year']) && $this->validateForm($_POST['year'])===true) {
			AwardsOneImporter::setYear($_POST['year'])->getWinners()->import();
			echo 'Ran';
		}
error_log("test error logger");
		?>
		<div class="wrap">
			<h2>Import Winners from an API</h2>
			<h3>Please set which year you want to import?</h3>
			<form method="post">
				<input required="required" type="number" name="year" placeholder="<?php echo date("Y")-1;?>" />
				<input type="submit" value="Import" class="button-primary" />
			</form>

		</div>
<?php


	}

	/**
	 * @param $post_ID
	 * @param $post_after
	 * @param $post_before
	 *
	 * @return bool|void
	 * @throws \Exception
	 */
	public function on_delete_winner( $post_ID, $post_after, $post_before ){
		// We check if the global post type isn't ours and just return
		if ($post_after->post_type !== (string) $this->post_type) return;

		if ($post_after->post_status == "trash") {

			try {
				// My custom stuff for deleting my custom post type here
				$upload_folder = WPFileUploadHandler::getUploadFolder( $post_ID );
				array_map( 'unlink', glob( $upload_folder . "/*.*" ) );
				rmdir( $upload_folder );

				return true;

			} catch ( \Exception $e ) {
				throw new \Exception( $e->getMessage(), $e->getCode() );

				return false;
			}
		}
		if ($post_before->post_status == "trash") {
			// TODO: write Restore method (can base it on the year taxonomy and reimport the entire year)?
		}
	}

	/**
	 *
	 */
	public function setupPlugin() {
		// TODO: Implement setupPlugin() method.

		// TODO: Custom Post Type
		$this->createCustomPostType(self::POST_TYPE_KEY)->register();
	}

	/**
	 * @param string $post_type_key
	 *
	 * @return \FredBradley\CranleighCulturePlugin\CustomPostType
	 */
	private function createCustomPostType( string $post_type_key ) {

		$this->post_type = new CustomPostType( $post_type_key );

		return $this->post_type;
	}
}
