<?php

	$this->addScript('http://www.google.com/jsapi');
	$this->addStylesheet('/statics/css/modules/home.css');
	$this->addScript('/statics/js/modules/home.js');
	
	
	
	Kate::requireModel('Event');
	
	$from = strtotime(date('Y-m-d 00:00:00',time()))-(30*24*3600);
	
	$page = 1;
	$rpp = 20;
	$query = array(
		'from' => $from,
		'order by' => 'date desc',
		'available' => true
	);
	
	if(isset($PARAMS['wildcard']) && !empty($PARAMS['wildcard'])) {
		$query['tags'] = explode('/',$PARAMS['wildcard']);
	}
	
	$Events = new Event();
	$events = $Events->getItems($query,array('page'=>$page,'rpp'=>$rpp));
	
	$eventsForJS = array();
	$eventsMaxValue = 0;
	foreach($events as $event) {
		$date = $event['date'];
		if(!isset($eventsForJS[$date])) $eventsForJS[$date] = 0;
		$eventsForJS[$date]++;
		if($eventsForJS[$date] > $eventsMaxValue) $eventsMaxValue = $eventsForJS[$date];
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