
<?php if(isset($Item) && !$Item->isNew()) { ?>
<form action="<?=$Item->permalink('/modifier.html')?>?next=<?=rawurlencode(NE($_REQUEST,'next'))?>" class="login" method="post">
    <h3>Modifier un dossier</h3>
<?php } else { ?>
<form action="/dossiers/ajouter.html?next=<?=rawurlencode(NE($_REQUEST,'next'))?>" class="login" method="post">
    <h3>Ajouter un dossier</h3>
<?php } ?>
    
    <?php if($this->hasMessages('error')) { ?>
    <div class="error">
        <p>Votre formulaire contient des erreurs:</p>
        <?=$this->getMessagesAsHTML('error',true,array('alwaysList'=>true))?>
    </div>
    <?php } ?>
    
    <div class="field">
    	<label>Nom du dossier :</label>
        <input type="text" name="title" class="text" value="<?=NE($item,'title')?>" />
        <div class="clear"></div>
    </div>
    
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