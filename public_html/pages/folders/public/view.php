<h1><?=$item['title']?></h1>

<div id="details">
	<div class="field">
		<h4>Date</h4>
        <div><?=$Item->date()?></div>
    </div>
    
    <div class="field">
		<h4>Tags</h4>
        <ul class="tags">
        	<?php
            
				foreach($tags as $tag) {
					$Tag = new Tag();
					$Tag->setData($tag);
					echo $Tag->getListHTML();
				}
				
			?>
        </ul>
        <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
</div>

<div class="hr"></div>

<div class="spacer"></div>