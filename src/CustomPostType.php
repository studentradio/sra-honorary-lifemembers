<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2017
 * Time: 14:00
 */

namespace StudentRadio\HonoraryLifeMembers;

use PostTypes\PostType;

class CustomPostType {

	/**
	 * @var
	 */
	private $post_type_key;

	/**
	 * @var
	 */
	private $post_type;

	/**
	 * @var array
	 */
	private $supports = [
		"thumbnail",
		"title",
		"editor"

	];

	/**
	 * @var array
	 */
	private $options = [
		"menu_position" => 27,
		"menu_icon"     => "dashicons-awards",
		"label" => "Life Member",
		"has_archive" => false
	];

	/**
	 * @var array
	 */
	public $labels = [
		"name" => "Life Member",
		"menu_name" => "Life Members",
		"add_new_item" => "New Life Member",
		"add_new" => "Add New Life Member",
		"view_items" => "Life Members",
		"all_items" => "All Life Members"
	];

	public function __toString() {
		// TODO: Implement __toString() method.
		return $this->post_type_key;
	}

	/**
	 * CustomPostType constructor.
	 *
	 * @param string $post_key
	 * @param array  $options
	 * @param array  $labels
	 */
	function __construct( string $post_key, array $options = [], array $labels = [] ) {

		//$this->names = [];
		$this->setPostTypeKey( $post_key );

		$this->labels = array_merge( $this->labels, $labels );

		$this->options[ 'supports' ] = $this->supports;

		$this->options = array_merge( $options, $this->options );

	}

	/**
	 *
	 */
	public function registerMetaBoxes() {
		$metabox = new MetaBoxes($this->post_type_key);
		add_filter('rwmb_meta_boxes', [$metabox, 'register']);
	}


	/**
	 *
	 */
	public function register() {

		if (!empty($this->names)) {
			$names = $this->names;
		} else {
			$names = $this->post_type_key;
		}

		$this->post_type = new PostType( $names, $this->options, $this->labels );
		$this->setTaxonomies();
		$this->registerMetaBoxes();


	}

	/**
	 * @param string $key
	 */
	private function setPostTypeKey( string $key ) {

		$key                 = str_replace( " ", "-", $key );
		$this->post_type_key = strtolower( $key );
	}

	/**
	 *
	 */
	private function setTaxonomies() {

		$this->post_type->taxonomy( 'life-member-year' );

	}

}
