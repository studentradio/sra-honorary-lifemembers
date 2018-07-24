<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2017
 * Time: 15:25
 */

namespace StudentRadio\HonoraryLifeMembers;

class MetaBoxes
{

	/**
	 * @var string
	 */
	public $prefix = "sra_hon_member_";

	/**
	 * @var array|string
	 */
	private $post_types;


	/**
	 * MetaBoxes constructor.
	 *
	 * @param array|string $types
	 */
	public function __construct($types)
    {
        $this->post_types = $types;

    }


	/**
	 * @param string $id
	 *
	 * @return string
	 */
	private function fieldID(string $id) {
    	return $this->prefix.$id;
	}


	/**
	 * @param array $meta_boxes
	 *
	 * @return array
	 */
	public function register($meta_boxes) {


        return $meta_boxes;

    }
}
