<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2018
 * Time: 12:27
 */

namespace StudentRadio\HonoraryLifeMembers;


class LifeMember {

	public $name;
	public $bio;

	public function __construct($name, $post_content) {
		$this->name = $name;
		$this->bio = $post_content;
	}

	public function __toString() {
		// TODO: Implement __toString() method.
			$output = '<div class="life-member-bio">';
			$output .= "<h4>".$this->name."</h4>";
			$output .= $this->bio;
			$output .= '</div>';

			return $output;

	}
}
