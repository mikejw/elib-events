

<form action="" method="post">
<fieldset>
<legend>Add Body Text</legend>
<p>
<label>Body</label>
<textarea name="body" rows="" cols="">{$data_item->body|escape}</textarea>
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$data_item->id}" />
<button type="submit" name="save">Submit</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>