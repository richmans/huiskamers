<?php
namespace Huiskamers;
class Region extends Base {
	public static function table_name() { return 'regions'; }
	public static function fields() {
		return array(
			'name' => array('type' => 'string', 'validate' => 'unique')
		);
	}

	public static function indexes() {
		return array('name');
	}
        
        public function huiskamer_count() {
            $count = 0;
            foreach(Huiskamer::all() as $huiskamer)
            {
                if(in_array($this->id(), $huiskamer->region_ids()))
                {
                    $count++;
                }
            }
            
            return $count;
	} 
        
        public function huiskamer_visible_count() {
            $count = 0;
            foreach(Huiskamer::all() as $huiskamer)
            {
                if(in_array($this->id(), $huiskamer->region_ids()))                
                {
                    if($huiskamer->active() && $huiskamer->available())
                    {
                        $count++;
                    }
                }
            }
            
            return $count;
	} 
}
?>