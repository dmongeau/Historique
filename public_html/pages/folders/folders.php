<?php

Kate::requireModel('Folder');

switch($ACTION) {
	
	case 'add':
	case 'edit':
		
		try {
			
			if(isset($this->ID)) {
				if(is_numeric($this->ID)) {
					$Item = new Folder($this->ID);
				} else {
					$Item = new Folder(array(
						'permalink' => $this->ID
					));
				}
				$item = $Item->fetch();
				$tags = $Item->getTags();
			} else {
				$Item = new Folder();
				$item = array();
				$tags = array();
			}
			
			
			if($_POST) {
				
				try {
					
					$data = $_POST;
					$data['published'] = 1;
					$item = $data;
					
					$Item->setData($item);
					$Item->validate();
					$Item->save();
					
					//Update tags
					$Item->updateTags($data['tags']);
					
					if(Gregory::isAJAX()) {
						$item = $Item->fetch();
						Gregory::JSON(array('success'=>true,'response'=>$item));
					} else {
						if(isset($_REQUEST['next']) && !empty($_REQUEST['next'])) Gregory::redirect($_REQUEST['next']);
						else Gregory::redirect('/');
					}
					
				} catch(Zend_Exception $e) {
					if(!Gregory::isAJAX()) $this->addError('Il s\'est produit une erreur');
					else Gregory::JSON(array('success'=>false, 'error'=>'Il s\'est produit une erreur'));
				} catch(Exception $e) {
					if(Gregory::isAJAX()) Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
					
				}
				
			}
				
				
		} catch(Exception $e) {
			if(Gregory::isAJAX()) Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
			else Gregory::redirect('/');
		}
		
		$this->addStylesheet('/statics/js/lib/Widgets/itemsField/jquery.itemsfield.css');
		$this->addScript('/statics/js/lib/Widgets/itemsField/jquery.itemsfield.js');
		$this->addScript('/statics/js/modules/folders.form.js');
		
		include PATH_MODULE_EVENTS_PUBLIC.'/form.php';
		
		
	break;
	
	
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
		
		$Items = new Folder();
		$items = $Items->getItems($query,$opts);
		
		if($FORMAT == 'json') {
			
			if(isset($query['autocomplete'])) {
				$folders = array();
				foreach($items as $item) {
					$folders[] = array(
						'label' => $item['name'],
						'value' => $item['fid']
					);
				}
				$items = $folders;
				Gregory::JSON($items);
			} else {
				Gregory::JSON(array('success' => true, 'response' => $items));
			}
			
		}
		
	break;

}