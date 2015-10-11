<?php

class Event extends BasicObject {
	protected static function table_name() {
		return "event";
	}

	public static function cached(){
		$event = static::first();

		/* load new data if there isn't any cached event */
		if ( !$event ){
			/* prepare data */
			$data = (array)NXAPI::event_info();
			unset($data['id']); /* BO::update_attributes will believe the object to exist if this is set */
			$data['short_name'] = $data['folder_name'];

			$event = static::update_attributes($data, [
				'permit' => ['name', 'short_name', 'event_start', 'event_end'],
				'create' => true,
				'empty_to_null' => false,
			]);

			if ( $event ){
				$event->commit();
			} else {
				/* just in case, add a placeholder */
				$event = new Event;
				$event->event_id = 0;
				$event->name = 'Placeholder event';
				$event->short_name = 'placeholder';
				$event->event_start = 0;
				$event->event_end = 0;
			}
		}

		return $event;
	}

	public static function flush(){
		foreach ( static::all() as $row ){
			$row->delete();
		}
	}

	public function as_json(){
		return [
			'event_id' => $this->id,
			'name' => $this->name,
			'short_name' => $this->short_name,
			'event_start' => $this->event_start,
			'event_end' => $this->event_end,
		];
	}
}
