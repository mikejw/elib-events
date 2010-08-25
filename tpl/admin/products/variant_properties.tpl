


<div id="properties">

<div class="product">
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/{if $variant->image eq ''}img/blank.gif{else}uploads/mid_{$variant->image}{/if}" alt="" />
</div>

{if sizeof($properties) > 0}
<fieldset><legend>Set Variant Properties</legend>
<form action="" method="post">
{foreach from=$properties key=id item=property}
<p><label>{$property.name}</label>
<select name="property[{$id}]">
<option value="0">Null</option>
{if sizeof($property.option) > 0}
{foreach from=$property.option item=option key=option_id}
<option value="{$option_id}"{if in_array($option_id, $options)} selected="selected"{/if}>{$option}</option>
{/foreach}
{/if}
</select>
</p>
{/foreach}
<p><label>&nbsp;</label>
<button type="submit" name="save">Save</button>
</p>
</form>
</fieldset>
{else}
<p>This product variant is in a category which has no active properties.</p>
{/if}

</div>
