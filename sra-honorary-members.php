<?php
/*
Plugin Name: SRA Honorary Life Members
Plugin URI: https://www.studentradio.org.uk
Description: For Lifers
Version: 1.1
Author: fredbradley
Author URI: https://www.fredbradley.uk
License: MIT
*/

namespace StudentRadio\HonoraryLifeMembers;

if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

$plugin = new Plugin();
