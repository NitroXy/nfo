<?php

define('DAY_OFFSET', 719528);

class TimetableController extends Controller {
	public function index() {
		$slots = $this->generate_slots();
		list($min, $max) = $this->get_span();
		return $this->render('frontpage', [
			'slots' => $slots,
			'start' => $min,
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

		$items = $this->run_raw_query('SELECT UNIX_TIMESTAMP(`timestamp`) AS `begin`, UNIX_TIMESTAMP(`timestamp`)+`duration`*3600 AS `end`, `text`, `short_name`, `color` as `background`, 1 as `first` FROM `scheme_items`');

		/* calculate a good-enough text color */
		$items = array_map(function($x){
			$int = hexdec(substr($x['background'],1));
			$r = 0xFF & ($int >> 0x10);
			$g = 0xFF & ($int >> 0x8);
			$b = 0xFF & $int;
			$x['luminance'] = sqrt(0.299 * $r*$r + 0.587 * $g*$g + 0.114 * $b*$b);
			return $x;
		}, $items);

		$result = array();
		for ( $day = $min; $day <= $max; $day++ ){
			$daystamp = static::timestamp_from_days($day);

			/* reset 'first' so title is shown again for activities spaning over multiple days */
			$items = array_map(function($x){
				$x['first'] = true;
				return $x;
			}, $items);

			for ( $hour = 0; $hour < 24; $hour++ ){
				$timestamp = $daystamp + $hour * 3600;

				/* a bit inefficient, for each slot it iterates over each item.
				 * quick-and-dirty but would be very slow for a larger set. need to fix
				 * this later when under less time contstraints */
				$result[$day-$min][$hour] = array_filter($items, function($v, $k) use(&$items, $timestamp){
					if ( $timestamp >= $v['begin'] && $timestamp < $v['end'] ){
						$items[$k]['first'] = false;
						return true;
					} else {
						return false;
					}
				}, ARRAY_FILTER_USE_BOTH);
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
