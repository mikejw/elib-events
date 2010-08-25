
<div id="right">

<form action="" method="post">
<fieldset><legend>Active Properties</legend>

<p><label>Properties</label>
<span class="checkboxes">
{foreach from=$properties key=id item=property}
<label>
<input type="checkbox" name="property[{$id}]"{if in_array($id, $active_properties) || in_array($id, $inherited_properties)} checked="checked"{/if}{if in_array($id, $inherited_properties)} disabled="disabled"{/if} />{$property.name}</label><br />
{/foreach}
</span>
</p>
<p><label>&nbsp;</label>
<button type="submit" name="save">Save</button>
</p>
</fieldset>
</form>





</div>