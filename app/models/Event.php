<?php


class Event extends Kate {
	
	public $source = array(
		'type' => 'db',
		'table' => array(
			'name' => array('e'=>'events'),
			'primary' => 'eid',
			'fields' => '*',
			'nowFields' => 'dateadded'
		)
	);
	
	public function permalink($end = '') {
		$data = $this->getData();
		
		return '/evenements/'.$data['permalink'].(!empty($end) ? '/'.ltrim($end,'/'):'.html');
	}
	
	public function date($end = '') {
		$data = $this->getData();
		
		return Bob::create('date',$data['date'])->format();
	}
	
	/*
	 *
	 * Related items
	 *
	 */
	public function getTags($query = array(), $opts = array()) {
		
		Kate::requireModel('Tag');
		
		$Item = new Tag();
		$items = $Item->getItems(array_merge(array(
			'eid' => $this->getPrimary(),
			'available' => true
		),$query), array_merge(array(
			'page' => -1,
			'rpp' => 20
		),$opts));
		
		return $items;
	}
	
	public function updateTags($items) {
		
		$tags = array();
		$tids = array();
		foreach($items as $item) {
			if(preg_match('/^[0-9]+$/',$item)) {
				$tid = (int)$item;
			} else {
				try {
					Kate::requireModel('Tag');
					$Tag = new Tag(array(
						'key' => $item
					));
					$tid = (int)$Tag->getPrimary();
				} catch(Exception $e) {
					$Tag = new Tag();
					$Tag->setData(array(
						'label' => $item,
						'published' => 1
					));
					$Tag->save();
					$tid = (int)$Tag->getPrimary();
				}
			}
			if(!in_array($tid,$tids)) {
				$tags[] = array(
					'tid' => $tid,
					'published' => 1
				);
				$tids[] = $tid;
			}
		}
		
		$etids = array();
		foreach($tags as $tag) {
			$tag['eid'] = $this->getPrimary();
			$select = Gregory::get()->db->select()->from(array('et'=>'events_tags'),array('etid'))
												->where('et.eid = ?',$this->getPrimary())
												->where('et.tid = ?',$tag['tid']);
			$item = Gregory::get()->db->fetchRow($select);
			if($item) {
				if(isset($tag['dateadded'])) unset($tag['dateadded']);
				Gregory::get()->db->update('events_tags',$tag,Gregory::get()->db->quoteInto('etid = ?',$item['etid']));
				$etids[] = $item['etid'];
			} else {
				$tag['uid'] = Gregory::get()->auth->isLogged() ? Gregory::get()->auth->getIdentity()->uid:0;
				$tag['dateadded'] = date('Y-m-d H:i:s');
				Gregory::get()->db->insert('events_tags',$tag);
				$etids[] = Gregory::get()->db->lastInsertId();
			}
		}
		
		$wheres = array();
		$wheres[] = Gregory::get()->db->quoteInto('eid = ?',$this->getPrimary());
		if(sizeof($etids)) $wheres[] = 'etid NOT IN('.Gregory::get()->db->quote($etids).')';
		Gregory::get()->db->delete('events_tags','('.implode(') AND (',$wheres).')');
		
	}
	
	
	
	/*
	 *
	 * HTML Templates
	 *
	 */
	public function getListHTML() {
		
		ob_start();
		include PATH_PAGES.'/_helpers/event.list.php';
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
		
		if(!isset($data['title']) || empty($data['title'])) {
			Gregory::get()->addError('Vous devez entrer un titre');
		}
		
		if(!isset($data['date']) || empty($data['date'])) {
			Gregory::get()->addError('Vous devez entrer une date');
		}
		
		if(isset($data['date']) && !preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/',$data['date'])) {
			Gregory::get()->addError('Vous devez entrer une date au format AAAA-MM-JJ');
		}
		
		if(Gregory::get()->hasErrors()) throw new Exception('Votre formulaire contient des erreurs');
		
	}
	
	
	
	/*
	 *
	 * Data filters
	 *
	 */
	
	protected function _putTitle($data,$value,$inputs) {
		
		$date = strtotime($inputs['date']);
		
		$data['title'] = $value;
		$parts = array();
		$parts[] = date('Y',$date);
		$parts[] = date('m',$date);
		$parts[] = date('d',$date);
		$parts[] = trim(Bob::create('string',$value)->toPermalink(),'-');
		$data['permalink'] = implode('/',$parts);
		
		return $data;
	}
	
	
	/*
	 *
	 * Items query custom parameters
	 *
	 */
	 
	protected function _queryAvailable($select, $value) {
		
		if($value === true || $value === 1 || $value === '1' || $value === 'true') {
			$select->where('e.published = 1 AND e.deleted = 0');
		} else if($value === false || $value === 0 || $value === '0' || $value === 'false') {
			$select->where('e.published = 0 OR e.deleted = 1');
		}
		
		return $select;	
	}
	
	protected function _queryTags($select, $value) {
		
		if(!empty($value)) {
			$wheres  = array();
			foreach($value as $item) {
				if(is_numeric($item)) {
					$wheres[] = Gregory::get()->db->quoteInto('et.tid = ?',$item);
				} else {
					$wheres[] = Gregory::get()->db->quoteInto('t.clean = ?',strtolower(trim(Bob::create('string',$item)->toPermalink(),'-')));
				}
			}
			if(sizeof($wheres)) {
				$select->joinLeft(array('et'=>'events_tags'),'et.eid = e.eid',array(null));
				$select->joinLeft(array('t'=>'tags'),'t.tid = et.tid',array(null));
				$select->where('('.implode(') OR (',$wheres).')');
			}
		} else {
			$select->where('e.eid = -1');
		}
		
		return $select;	
	}
	
	protected function _queryFrom($select, $value) {
		
		if(!empty($value)) {
			$time = is_numeric($value) ? $value:strtotime($time);
			$select->where('e.date >= ?',date('Y-m-d',$time));
		} else {
			$select->where('e.eid = -1');
		}
		
		return $select;	
	}
	
	protected function _queryTo($select, $value) {
		
		if(!empty($value)) {
			$time = is_numeric($value) ? $value:strtotime($time);
			$select->where('e.date < ?',date('Y-m-d',$time+(3600*24)));
		} else {
			$select->where('e.eid = -1');
		}
		
		return $select;	
	}
	
}
