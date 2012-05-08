
<?php if(isset($Item) && !$Item->isNew()) { ?>
<form action="<?=$Item->permalink('/modifier.html')?>?next=<?=rawurlencode(NE($_REQUEST,'next'))?>" class="login" method="post">
    <h3>Modifier un événement</h3>
<?php } else { ?>
<form action="/evenements/ajouter.html?next=<?=rawurlencode(NE($_REQUEST,'next'))?>" class="login" method="post">
    <h3>Ajouter un événement</h3>
<?php } ?>
    
    <?php if($this->hasMessages('error')) { ?>
    <div class="error">
        <p>Votre formulaire contient des erreurs:</p>
        <?=$this->getMessagesAsHTML('error',true,array('alwaysList'=>true))?>
    </div>
    <?php } ?>
    
    <div class="field">
    	<label>Titre :</label>
        <input type="text" name="title" class="text" value="<?=NE($item,'title')?>" />
        <div class="clear"></div>
    </div>
	
    <div class="field fleft mr20">
    	<label>Date :</label>
        <input type="text" name="date" class="text date" value="<?=NE($item,'date')?>" />
        <div class="clear"></div>
    </div>
	
    <?php
		$time1 = -1;
		$time2 = -1;
		if(isset($item['time']) && !empty($item['time'])) {
			$time = explode(':',$item['time']);
			if(sizeof($time) >= 2) {
				$time1 = $time[0];
				$time2 = $time[1];
			}
		}
	?>
    <div class="field fleft">
    	<label>Heure :</label>
        <div class="mt5">
            <select name="time_1">
                <option name="">--</option>
                <?php for($i = 0; $i < 24; $i++) { ?>
                <option name="<?=$i?>" <?=SEL($time1,$i,'integer')?>><?=$i < 10 ? '0'.$i:$i?></option>
                <?php } ?>
            </select> : 
            <select name="time_2">
                <option name="">--</option>
                <?php for($i = 0; $i < 59; $i++) { ?>
                <option name="<?=$i?>" <?=SEL($time2,$i,'integer')?>><?=$i < 10 ? '0'.$i:$i?></option>
                <?php } ?>
            </select>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
    <div class="spacer-small"></div>
    
    <div class="field">
    	<label>Dossier :</label>
        <select name="fid" class="folder">
        <?php if((int)NE($item,'fid',0) != 0) { ?>
        <option value="<?=$folder['fid']?>" selected="selected"><?=$folder['name']?></option>
        <?php } ?>
        </select>
        <div class="clear"></div>
    </div>
    
    <div class="spacer-small"></div>
    
    <div class="field">
    	<label>Tags :</label>
        <select name="tags[]" class="tags" multiple="multiple">
        	<?php foreach($tags as $tag) { ?>
        	<option value="<?=$tag['tid']?>" selected="selected"><?=$tag['label']?></option>
            <?php } ?>
        </select>
        <div class="clear"></div>
    </div>
    
    <div class="spacer-small"></div>
    
    <p class="field">
    	<a href="<?=NE($_REQUEST,'next','/')?>" class="button">Annuler</a>
        <?php if(isset($Item) && !$Item->isNew()) { ?>
    	<button type="submit">Enregistrer</button>
        <?php } else { ?>
    	<button type="submit">Ajouter</button>
        <?php } ?>
    </p>
</form>