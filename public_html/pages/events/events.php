<?php

Kate::requireModel('Event');

switch($ACTION) {
	
	case 'add':
	case 'edit':
		
		try {
			
			if(isset($this->ID)) {
				if(is_numeric($this->ID)) {
					$Item = new Event($this->ID);
				} else {
					$parts = array();
					$parts[] = $PARAMS['year'];
					$parts[] = $PARAMS['month'];
					$parts[] = $PARAMS['day'];
					$parts[] = $this->ID;
					$Item = new Event(array(
						'permalink' => implode('/',$parts)
					));
				}
				$item = $Item->fetch();
				$tags = $Item->getTags();
			} else {
				$Item = new Event();
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
		$this->addScript('/statics/js/modules/events.form.js');
		
		include PATH_MODULE_EVENTS_PUBLIC.'/form.php';
		
		
	break;
	
	case 'view':
		
		try {
			
			if(is_numeric($this->ID)) {
				$Item = new Event($this->ID);
			} else {
				$parts = array();
				$parts[] = $PARAMS['year'];
				$parts[] = $PARAMS['month'];
				$parts[] = $PARAMS['day'];
				$parts[] = $this->ID;
				$Item = new Event(array(
					'permalink' => implode('/',$parts)
				));
			}
			$item = $Item->fetch();
			$tags = $Item->getTags();	
				
		} catch(Exception $e) {
			if(Gregory::isAJAX()) Gregory::JSON(array('success'=>false, 'error'=>$e->getMessage()));
			else Gregory::redirect('/');
		}
		
		$this->addStylesheet('/statics/css/modules/events.view.css');
		
		include PATH_MODULE_EVENTS_PUBLIC.'/view.php';
		
		
	break;

}