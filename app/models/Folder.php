<?php


class Folder extends Kate {
	
	public $source = array(
		'type' => 'db',
		'table' => array(
			'name' => array('f'=>'folders'),
			'primary' => 'fid',
			'fields' => '*',
			'nowFields' => 'dateadded'
		)
	);
	
	
	
	/*
	 *
	 * Validate user data
	 *
	 */
	public function validate() {
		
		$data = $this->getData();
		
		if(!isset($data['name']) || empty($data['name'])) {
			Gregory::get()->addError('Vous devez entrer un nom de dossier');
		}
		
		if(Gregory::get()->hasErrors()) {
			throw new Exception('Votre formulaire contient des erreurs');
		}
		
	}
	
	
	/*
	 *
	 * Items query custom parameters
	 *
	 */
	 
	protected function _queryAvailable($select, $value) {
		
		if($value === true || $value === 1 || $value === '1' || $value === 'true') {
			$select->where('f.published = 1 AND f.deleted = 0');
		} else if($value === false || $value === 0 || $value === '0' || $value === 'false') {
			$select->where('f.published = 0 OR f.deleted = 1');
		}
		
		return $select;	
	}
	
}
