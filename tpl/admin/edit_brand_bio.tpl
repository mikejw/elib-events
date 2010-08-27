

<form action="" method="post">
<fieldset>
<legend>Edit Biography</legend>
<p>
<label>Biography</label>
<textarea name="bio" rows="" cols="">{$brand->about|replace:'</p><p>':"\r\n"|replace:'<p>':""|replace:'</p>':""}</textarea>
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$brand->id}" />
<button type="submit" name="save">Save</button>
</p>
</fieldset>
</form>