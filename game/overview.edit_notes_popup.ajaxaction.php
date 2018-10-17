<h3>Notatki</h3>
<div style="width:100%; overflow:hidden;">
	<div id="bbcodes">    
		<?php BB::icons(["message","claim"]); ?>
	</div>
	<div><textarea id="message" name="note" style="width:97%;" rows="10" cols="40"></textarea></div>
	<div><input type="button" value="OK" class="btn-default" onclick="editNotes('/game.php?ajaxaction=edit_notes&h=<?php echo $hkey; ?>&village=<?php echo $village['id']; ?>&screen=overview');"/></div>
</div>