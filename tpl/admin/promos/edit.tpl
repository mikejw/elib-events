


<div class="product">
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/{if $promo->image eq ''}img/blank.gif{else}uploads/mid_{$promo->image}{/if}" alt="" />
</div>

{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}

<fieldset><legend>Edit Product</legend>
<form action="" method="post">
<p><label>Name</label>
<input name="name" type="text" value="{$promo->name}" /></p>

<p><label>URL</label>
<input type="text" name="url" value="{$promo->url}" /></p>


<p><label>&nbsp;</label>
<input type="hidden" name="id" value="{$promo->id}" />
<button type="submit" name="save">Save</button></p>
</form>
</fieldset>
<div class="clear">&nbsp;</div>

