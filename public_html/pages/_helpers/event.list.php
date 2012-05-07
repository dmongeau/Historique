<?php

	$data = $this->getData();

?><li class="event">
	<h4><a href="<?=$this->permalink()?>"><?=$data['title']?></a></h4>
    <div class="date"><?=$this->date()?></div>
    <div class="tags">
    	<ul></ul>
    </div>
</li>