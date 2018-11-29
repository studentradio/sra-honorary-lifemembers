<?php

namespace StudentRadio\HonoraryLifeMembers;


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
		$this->Shortcodes();
	}

	public function Shortcodes() {
		new Shortcodes\DisplayHonMembers();
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
