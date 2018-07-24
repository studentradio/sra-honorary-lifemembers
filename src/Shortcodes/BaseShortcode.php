<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2018
 * Time: 11:23
 */

namespace StudentRadio\HonoraryLifeMembers\Shortcodes;


abstract class BaseShortcode {

	public function __construct() {
		$this->init();
	}
	private function init() {
		add_shortcode($this->tag, array($this, 'render'));
	}
	abstract public function render($atts, $content = null);
}
