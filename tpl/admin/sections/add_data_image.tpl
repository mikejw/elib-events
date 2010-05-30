

{if $error neq ''}
<ul id="error">
<li>{$error}</li>
</ul>
{/if}

<form action="" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Add Image</legend>
<p>
<label>File</label>
<input type="file" id="file" name="file" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{if $class eq 'data_item'}{$data_item->id}{else}{$section_id}{/if}" />
<button type="submit" name="save">Submit</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>

