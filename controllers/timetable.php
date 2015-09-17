<?php

define('DAY_OFFSET', 719528);

class TimetableController extends Controller {
	public function index() {
		$slots = $this->generate_slots();
		return $this->render('frontpage', [
			'slots' => $slots,
		]);
	}

	protected function get_span(){
		global $db;
		return $db->query('SELECT TO_DAYS(MIN(`timestamp`)), TO_DAYS(MAX(`timestamp`)) FROM `scheme_items`')->fetch_array();
	}

	/**
	 * Returns an array [$day][$hour] = $items where $day and $hour
	 * corresponds to the date and items is all scheme items on that slot.
	 */
	protected function generate_slots(){
		list($min, $max) = $this->get_span();

		$items = $this->run_raw_query('SELECT UNIX_TIMESTAMP(`timestamp`) AS `begin`, UNIX_TIMESTAMP(`timestamp`)+`duration`*3600 AS `end`, `text`, `color` FROM `scheme_items`');
		$result = array();
		for ( $day = $min; $day <= $max; $day++ ){
			$daystamp = static::timestamp_from_days($day);
			for ( $hour = 0; $hour < 24; $hour++ ){
				$timestamp = $daystamp + $hour * 3600;

				/* a bit inefficient, for each slot it iterates over each item.
				 * quick-and-dirty but would be very slow for a larger set. need to fix
				 * this later when under less time contstraints */
				$result[$day-$min][$hour] = array_filter($items, function($x) use($timestamp){
					return $timestamp >= $x['begin'] && $timestamp <= $x['end'];
				});
			}
		}
		return $result;
	}

	protected static function timestamp_from_days($days, $offset=0){
		return ($days - DAY_OFFSET) * 86400 + $offset;
	}

	protected function run_raw_query($q) {
		global $db;
		$r = $db->query($q);
		$res = [];

		while($row = $r->fetch_assoc()) {
			$res[] = $row;
		}

		return $res;
	}
}
