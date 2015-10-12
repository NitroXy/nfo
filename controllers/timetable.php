<?php

define('DAY_OFFSET', 719528);

class TimetableController extends Controller {
	public function index() {
		$days = $this->build_items();
		list($min, $max) = $this->get_span();
		return $this->render('frontpage', [
			'days' => $days,
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
	protected function build_items(){
		global $db;
		list($min, $max) = $this->get_span();

		$items = $db->query('SELECT UNIX_TIMESTAMP(`timestamp`) AS `begin`, UNIX_TIMESTAMP(`timestamp`)+`duration`*3600 AS `end`, `text`, `short_name`, `color` as `background` FROM `scheme_items` ORDER BY begin');


		$days = [];
		for ( $day = $min; $day <= $max; $day++ ){
			$daystamp = static::timestamp_from_days($day);
			$dayObj = new stdClass();
			$dayObj->begin = $daystamp;
			$dayObj->end = $daystamp + 24 * 3600;
			$dayObj->columns = 1;
			$dayObj->items = [];
			$days[] = $dayObj;
		}

		$current_day_index = 0;

		foreach($items as $item) {
			/* calculate a good-enough text color */
			$int = hexdec(substr($item['background'],1));
			$r = 0xFF & ($int >> 0x10);
			$g = 0xFF & ($int >> 0x8);
			$b = 0xFF & $int;
			$item['background'] = [];
			$item['background']['r'] = $r;
			$item['background']['g'] = $g;
			$item['background']['b'] = $b;
			$item['luminance'] = sqrt(0.299 * $r*$r + 0.587 * $g*$g + 0.114 * $b*$b);
			$item['collisions'] = [];
			$item['column'] = -1;
			$item['max_column'] = 0; // max column in collision with this item

			$day = $days[$current_day_index];
			if($item['begin'] >= $day->end) {
				++$current_day_index;
				$day = $days[$current_day_index];
			}

			$end_time = $item['end'];
			$local_day_index = $current_day_index;

			while($end_time > $day->end) {
				$item['end'] = $day->end;
				$days[$local_day_index]->items[] = $item;
				++$local_day_index;
				if($local_day_index >= count($days))
					break;

				$day = $days[$local_day_index];
				$item['begin'] = $day->begin;
			}

			if($local_day_index < count($days)) {
				$item['end'] = $end_time;
				$days[$local_day_index]->items[] = $item;
			}
		}

		for ($day_index = 0; $day_index < count($days); ++$day_index) {
			$day = &$days[$day_index];
			$items = &$day->items;
			$num_items = count($days[$day_index]->items);
			// Calculate collisions:
			for($i = 0; $i < $num_items; ++$i) {
				for($j = $i+1; $j < $num_items; ++$j) {
					// I know the items are in strict ascending order from the previous step.
					if($items[$j]['begin'] < $items[$i]['end']) {
						$items[$i]['collisions'][] = $j;
						$items[$j]['collisions'][] = $i;
					} else {
						break;
					}
				}
			}

			$max_column = 0;

			// Now allocate a column to each event
			for($i = 0; $i < $num_items; ++$i) {
				$item = &$items[$i];
				$column = 0;
				$occupied = count($item['collisions']) > 0;
				while($occupied) {
					$occupied = false;
					foreach($item['collisions'] as $collision) {
						if($collision > $i)
							continue;

						if($items[$collision]['column'] == $column) {
							$occupied = true;
							++$column;
							$items[$collision]['max_column'] = max($items[$collision]['max_column'], $column);
							break;
						}
					}
				}

				$item['column'] = $column;
				$item['max_column'] = $column;

				foreach($item['collisions'] as $collision) {
					$item['max_column'] = max($item['max_column'], $items[$collision]['column']);
				}
				$max_column = max($max_column, $column);
			}

			foreach($items as &$item) {
				foreach($item['collisions'] as $collision) {
					$item['max_column'] = max($item['max_column'], $items[$collision]['max_column']);
					static::flood_max_column($items, $items[$collision], $item['max_column']);
				}
			}

			$day->columns = $max_column + 1;

			// Finally, calculate size and offset of each item
			foreach($items as &$item) {
				$scale = $day->columns / ($item['max_column'] + 1);
				$item['offset'] = round((($scale * $item['column']) / $day->columns) * 100.0, 2);
				$item['size'] = round(($scale / $day->columns) * 100.0, 2);
				$item['hours'] = ($item['end'] - $item['begin']) / 3600.0;
				$item['start'] = ($item['begin'] - $day->begin) / 3600.0;
			}

		}

		return $days;
	}

	protected static function flood_max_column(&$items, &$item, $max_column) {
		if($max_column > $item['max_column']) {
			$item['max_column'] = $max_column;
			foreach($item['collisions'] as $collision) {
				static::flood_max_column($items, $items[$collision], $max_column);
			}
		}
	}

	protected static function timestamp_from_days($days, $offset=0){
		return ($days - DAY_OFFSET) * 86400 + $offset;
	}
}
