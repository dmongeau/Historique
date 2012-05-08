<?php

Kate::requireModel('Tag');

switch($ACTION) {
	
	default:
		
		$page = (int)NE($_REQUEST,'p',1);
		$rpp = (int)NE($_REQUEST,'rpp',20);
		
		$query = array(
			'available' => true,
		);
		$opts = array(
			'page' => $page,
			'rpp' => $rpp
		);
		
		if(isset($_REQUEST['term']) && !empty($_REQUEST['term'])) {
			$query['autocomplete'] = $_REQUEST['term'];
		}
		
		$Items = new Tag();
		$items = $Items->getItems($query,$opts);
		
		if($FORMAT == 'json') {
			
			if(isset($query['autocomplete'])) {
				$tags = array();
				foreach($items as $item) {
					$tags[] = array(
						'label' => $item['label'],
						'value' => $item['tid']
					);
				}
				$items = $tags;
				Gregory::JSON($items);
			} else {
				Gregory::JSON(array('success' => true, 'response' => $items));
			}
			
		}
		
	break;

}