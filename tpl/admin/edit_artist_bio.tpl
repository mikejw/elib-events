
<div id="right">

<form action="" method="post">
<fieldset>
<legend>Edit Biography</legend>
<p>
<label>Biography</label>
<textarea name="bio" rows="" cols="">{$artist->bio|escape}</textarea>
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$artist->id}" />
<button type="submit" name="save">Save</button>
 <button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>

</div>