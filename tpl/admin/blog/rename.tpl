

<form action="" method="post">
<fieldset>
<legend>Rename Category</legend>
<p>
<label>Label</label>
<input type="text" name="label" value="{$blog_category->label}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$blog_category->id}" />
<button type="submit" name="save">Save</button>
</p>
</fieldset>
</form>