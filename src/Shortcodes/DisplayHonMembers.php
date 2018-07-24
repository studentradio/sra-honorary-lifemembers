<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2018
 * Time: 11:20
 */

namespace StudentRadio\HonoraryLifeMembers\Shortcodes;

use StudentRadio\HonoraryLifeMembers\LifeMember;
use StudentRadio\HonoraryLifeMembers\LifeMemberYear;

class DisplayHonMembers extends BaseShortcode {

	protected $tag = 'display-hon-members';
	protected $atts = [];
	protected $years = [

	];

	function list_posts_by_term( $posts, $terms, $count = -1 ) {
		$tax_terms = get_terms( $terms, 'orderby=name');
		$years = [];
		foreach ( $tax_terms as $key => $term ) {
			$year = new LifeMemberYear($term->name);
			$args = array(
				'posts_per_page' => $count,
				$terms => $term->slug,
				'post_type' => $posts,
			);
			$tax_terms_posts = get_posts( $args );

			$output[$key]['people'] = [];
			foreach ( $tax_terms_posts as  $post ) {
				$year->addMember(new LifeMember($post->post_title, $post->post_content));
			}
			$years[$year->year] = $year;
		}

		$this->lifeMembers = $years;
		wp_reset_postdata();
	}

	private function setup() {
		$this->list_posts_by_term('sra-honorary-member', 'life-member-year');
		foreach ($this->lifeMembers as $year) {
			array_push($this->years, $year->year);
		}

	}

	public function render($atts, $content=null) {
		$this->setup();
		echo '<div class="tabbable tabs-left">';
		echo $this->navTabs();
		echo '<div class="tab-content">';
		foreach ($this->years as $key => $year) {

			if ($key===0) {
				$activeTab = true;
			} else {
				$activeTab = false;
			}

			$this->tabPane($year, "header", $activeTab);

		}
		echo '</div>';
		echo '</div>';
	}



	private function tabPane($year, $header, $active=false) {
		?>
		<div id="<?php echo $year;?>" class="tab-pane<?php echo ($active ? " active" : ""); ?>">
			<h3><?php echo $year;?> Honorary Life Members</h3>
			<?php
			foreach ($this->lifeMembers[$year]->members as $member) {
				echo $member;
			}
			?>
		</div>
		<?php
	}

	public function navTabs() {
		ob_start();
		?>
		<ul class="nav nav-tabs">
		<?php
		rsort($this->years);
		foreach ($this->years as $key => $year) {
			if ($key===0) {
				echo '<li class="active">';
			} else {
				echo '<li>';
			}
			?>
				<a href="#<?php echo $year;?>" data-toggle="tab"><?php echo $year; ?></a>
			</li>
			<?php
		}
		?>
		</ul>

		<?php
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}



}
