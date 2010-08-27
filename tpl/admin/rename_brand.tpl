

<form action="" method="post">
<fieldset>
<legend>Rename Brand</legend>
<p>
<label>Name</label>
<input type="text" name="artist_alias" value="{$brand->name}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$brand->id}" />
<button type="submit" name="save">Save</button>
</p>
</fieldset>
</form>