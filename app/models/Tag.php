<?php


class Tag extends Kate {
	
	public $source = array(
		'type' => 'db',
		'table' => array(
			'name' => array('t'=>'tags'),
			'primary' => 'tid',
			'fields' => '*',
			'nowFields' => 'dateadded'
		)
	);
	
	public function permalink($end = '') {
		$data = $this->getData();
		
		return '/'.$data['clean'].(!empty($end) ? '/'.ltrim($end,'/'):'/');
	}
	
	
	
	/*
	 *
	 * HTML Templates
	 *
	 */
	public function getListHTML() {
		
		ob_start();
		include PATH_PAGES.'/_helpers/tag.list.php';
		$content = ob_get_clean();
		
		return $content;	
	}
	
	
	
	/*
	 *
	 * Validate user data
	 *
	 */
	public function validate() {
		
		$data = $this->getData();
		
		if(!isset($data['label']) || empty($data['label'])) {
			Gregory::get()->addError('Vous devez entrer un titre');
		}
		
	}
	
	public function _putLabel($data, $value, $inputs) {
		
		$data['label'] = $value;
		$data['clean'] = strtolower(trim(Bob::create('string',$value)->toPermalink(),'-'));
		
		return $data;
	}
	
	
	/*
	 *
	 * Items query custom parameters
	 *
	 */
	 
	protected function _queryAvailable($select, $value) {
		
		if($value === true || $value === 1 || $value === '1' || $value === 'true') {
			$select->where('t.published = 1 AND t.deleted = 0');
		} else if($value === false || $value === 0 || $value === '0' || $value === 'false') {
			$select->where('t.published = 0 OR t.deleted = 1');
		}
		
		return $select;	
	}
	
	protected function _queryKey($select, $value) {
		
		if(!empty($value)) {
			$select->where('t.clean = ?',strtolower(trim(Bob::create('string',$value)->toPermalink(),'-')));
		}
		
		return $select;	
	}
	
	protected function _querySort($select, $value) {
		
		switch($value) {
			case 'popular':
				$order = new Zend_Db_Expr('(SELECT COUNT(1) FROM events_tags AS ets WHERE ets.tid = t.tid)');
				$select->order($order);
			break;
		}
		
		return $select;	
	}
	
	protected function _queryEid($select, $value) {
		
		if(!empty($value)) {
			$select->joinLeft(array('et' => 'events_tags'),'et.tid = t.tid',array(null))
					->where('et.eid = ?',$value);
		}
		
		return $select;	
	}
	
}
