
<form action="" method="post">
<fieldset>
<legend>Change Template</legend>
<p>
<label>Template</label>
<select name="template">
{html_options options=$templates selected=$section->template}
</select>
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$section->id}" />
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>