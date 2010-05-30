

<form action="" method="post">
<fieldset>
<legend>Add Heading</legend>
<p>
<label>Heading</label>
<input type="text" name="heading" value="{$data_item->heading}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{if $class eq 'data_item'}{$data_item->id}{else}{$section_id}{/if}" />
<button type="submit" name="save">Submit</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>