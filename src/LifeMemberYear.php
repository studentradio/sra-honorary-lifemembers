<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2018
 * Time: 12:29
 */

namespace StudentRadio\HonoraryLifeMembers;


class LifeMemberYear {

	public $year;
	public $members = array();
	public function __construct($year) {
		$this->year = $year;
	}
	public function addMember(LifeMember $member) {
		array_push($this->members, $member);
	}
}
