
<form action="" method="post">
<fieldset>
<legend>Rename Section</legend>
<p>
<label>Label</label>
<input type="text" name="label" value="{$section->label}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$section->id}" />
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>