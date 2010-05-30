

<form action="" method="post">
<fieldset>
<legend>Rename Data Item</legend>
<p>
<label>Label</label>
<input type="text" name="label" value="{$data_item->label}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$data_item->id}" />
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>