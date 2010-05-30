

<form action="" method="post">
<fieldset>
<legend>Edit Heading</legend>
<p>
<label>Heading</label>
<input type="text" name="heading" value="{$data_item->heading}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$data_item->id}" />
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>