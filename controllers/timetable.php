<?php

class TimetableController extends Controller {
	public function index() {
		//$items = SchemeItem::all();

        $r = $this->run_raw_query('select DAY(timestamp) as day, count(*) as count from scheme_items group by DAY(timestamp);');

        $spans = [ ];
        // Process the days
        foreach($r as $d) {
            // Assemble this day
            $day = $d['day'];
            $items[$day] = [];
            $spans[$day] = 1;

            // Get the items that occur in this day
            $r2 = $this->run_raw_query('select TIME(timestamp) as time, text, duration, color from scheme_items where DAY(timestamp)='.$day.';');
            foreach($r2 as $t) {
                $time = intval(explode(':', $t['time'])[0], 10);
                $text = $t['text'];
                $duration = $t['duration'];
                $color = $t['color'];

                // Check if this overlaps with any other
                foreach($r2 as $t2) {
                    if($t['text'] == $t2['text']) {
                        continue;
                    }

                    $t2_time = intval(explode(':', $t2['time'])[0], 10);
                    if($t2_time >= $time &&
                       ($t2_time + $t2['duration']) <= ($time + $duration)) {
                        // overlap
                        $spans[$day] = 2;
                    }
                }

                $items[$day][$time] = [ $text, $duration, $color ];
            }
        }

		return $this->render('frontpage', array('scheme' => $items, 'spans' => $spans, 'newsfeed' => '' /*Newsfeed::Render()*/));
	}

   public function run_raw_query($q) {
        global $db;
        $r = $db->query($q);
        $res = [];

        while($row = $r->fetch_assoc()) {
            $res[] = $row;
        }

        return $res;
    }
	
	public function get() {
        global $db;

        $r = $this->run_raw_query('select DAY(timestamp) as day, count(*) as count from scheme_items group by DAY(timestamp);');

        $output = [ ];
        // Process the days
        foreach($r as $d) {
            // Assemble this day
            $day = $d['day'];
            //$n = $d['count'];
            echo '> '.$day.'<br>';

            // Get the items that occur in this day
            $r2 = $this->run_raw_query('select TIME(timestamp) as time, count(*) as count, text, duration from scheme_items where DAY(timestamp)='.$day.' group by time;');
            foreach($r2 as $t) {
                $time = $t['time'];
                $tn = $t['count'];
                $text = $t['text'];
                $duration = $t['duration'];

                if($tn > 1) {
                    // New column ...
                }

                echo '----> '.$time.'('.$duration.') "'.$text.'"<br>';
            }
        }
		die();
	}
}
?>
