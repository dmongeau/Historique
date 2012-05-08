<?php

	$this->addScript('http://www.google.com/jsapi');
	$this->addStylesheet('/statics/css/modules/home.css');
	$this->addScript('/statics/js/modules/home.js');
	
	
	/*
	 *
	 * À refaire, vraiment vraiment pas optimisé
	 *
	 */
	
	Kate::requireModel('Event');
	
	$from = strtotime(date('Y-m-d 00:00:00',time()))-(30*24*3600);
	
	$page = 1;
	$rpp = 20;
	$query = array(
		'from' => $from,
		'order by' => 'date desc',
		'available' => true
	);
	
	$colsForJS = array('Total des événements');
	if(isset($PARAMS['wildcard']) && !empty($PARAMS['wildcard'])) {
		$tagsKeys = explode('/',$PARAMS['wildcard']);
		$Events = new Event();
		$allEvents = $Events->getItems($query,array('page'=>$page,'rpp'=>$rpp));
		$query['tags'] = $tagsKeys;
		$cols = array();
		Kate::requireModel('Tag');
		foreach($tagsKeys as $tag) {
			try {
				$Tag = new Tag(array('key' => $tag));
				$tag = $Tag->fetch();
				$cols[] = $tag;
				$colsForJS[] = $tag['label'];
			} catch(Exception $e) {}
		}
	}
	
	$Events = new Event();
	$events = $Events->getItems($query,array('page'=>$page,'rpp'=>$rpp));
	
	$eventsForJS = array();
	$eventsMaxValue = 0;
	foreach($events as $event) {
		$date = $event['date'];
		if(!isset($eventsForJS[$date])) {
			$eventsForJS[$date] = array('Total des événements' => 0);
			if(isset($cols) && sizeof($cols)) {
				foreach($cols as $col) {
					$eventsForJS[$date][$col['label']] = 0;
				}
			}
		}
		if(isset($cols) && sizeof($cols)) {
			$Event = new Event();
			$Event->setData($event);
			$tags = $Event->getTags();
			foreach($tags as $tag) {
				foreach($cols as $col) {
					if((int)$col['tid'] == (int)$tag['tid']) {
						$eventsForJS[$date][$col['label']]++;
					}
				}
			}
		} else {
			$eventsForJS[$date]['Total des événements']++;
		}
		if($eventsForJS[$date] > $eventsMaxValue) $eventsMaxValue = $eventsForJS[$date];
	}
	
	if(isset($allEvents)) {
		foreach($allEvents as $event) {
			$date = $event['date'];
			if(!isset($eventsForJS[$date])) {
				$eventsForJS[$date] = array('Total des événements' => 0);
				if(isset($cols) && sizeof($cols)) {
					foreach($cols as $col) {
						$eventsForJS[$date][$col['label']] = 0;
					}
				}
			}
			$eventsForJS[$date]['Total des événements']++;
			if($eventsForJS[$date] > $eventsMaxValue) $eventsMaxValue = $eventsForJS[$date];
		}
	}
	
	$tags = Kate::getAll('Tag', array(
		'available' => true,
		'sort' => 'popular'
	), array('page'=>1,'rpp'=>20));



?>
<div id="timeline"></div>

<div class="hr"></div>

<div id="left">
    
    <div id="results">
        <ul class="list">
        <?php
        
        
            foreach($events as $event) {
                    
                $Event = new Event();
                $Event->setData($event);
                echo $Event->getListHTML();
            }
        
        ?>
        </ul>
    </div>
    
    <script type="text/javascript">
        var EVENTS_COLS = <?=json_encode($colsForJS)?>;
		var EVENTS = <?=json_encode($eventsForJS)?>;
		var EVENTS_MAX_VALUE = <?=$eventsMaxValue?>;
    </script>
</div>

<div id="right">

    <div id="tags">
		<ul>
        	<li class="selected">
                <a href="/">
                    <span class="check"><span class="color" style="background:#03C;"></span></span>
                    <span class="label">Tous les événements</span>
                    <span class="clear"></span>
                </a>
            </li>
        <?php
        
        
            foreach($tags as $tag) {
                    
                $Tag = new Tag();
                $Tag->setData($tag);
				?>
                <li class="<?=in_array($tag['clean'],$query['tags']) ? 'selected':''?>">
                	<a href="<?=$Tag->permalink()?>">
                        <span class="check"><span class="color"></span></span>
                        <span class="label"><?=$tag['label']?></span>
                        <span class="clear"></span>
                    </a>
                </li>
                <?php
            }
        
        ?>
        </ul>
    </div>

</div>

<div class="clear"></div>
<div class="spacer-small"></div>