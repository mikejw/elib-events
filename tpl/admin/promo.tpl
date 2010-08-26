{include file="elib://admin/admin_header.tpl"}




{if $event eq 'default_event' || $event eq 'edit'}
<div id="operations">

<div class="grey" style="padding:0.5em;">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/promo/edit/{$promo->id}" method="get">
<div><button type="submit" name="edit" value="1">Edit</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/promo/upload_image/{$promo->id}" method="get">
<div><button type="submit" name="upload_image" value="1">Upload Image</button></div>
</form>
<form class="confirm" action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/promo/delete/{$promo->id}" method="get">
<div><button type="submit" name="delete_promo" value="1">Delete</button></div>
</form>

</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>
{/if}







<div class="grey clear">


<div id="categories">
{$nav}
</div>

{if $event eq 'default_event'}
{include file="elib://admin/promos/promo.tpl"}
{elseif $event eq 'upload_image'}
{include file="elib://admin/promos/upload_image.tpl"}
{elseif $event eq 'edit'}
{include file="elib://admin/promos/edit.tpl"}
{/if}


{*
{if $event eq 'edit'}
{include file="products/edit_product.tpl"}
{elseif $event eq 'upload_image'}
{include file="products/upload_image.tpl"}
{elseif $event eq 'default_event'}
{include file="products/product.tpl"}
{elseif $event eq 'edit_variant'}
{include file="products/edit_variant.tpl"}
{elseif $event eq 'upload_variant_image'}
{include file="products/upload_variant_image.tpl"}
{elseif $event eq 'variant_properties'}
{include file="products/variant_properties.tpl"}
{elseif $event eq 'resize_images'}
{include file="products/resize_images.tpl"}
{/if}
*}


</div>






{include file="elib://admin/admin_footer.tpl"}































{*
{include file="comp_admin.tpl"}
*}

{*
{if $event eq 'edit'}



<div class="contain_center">
<div class="product">
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/img/{if $product->image eq ''}blank.gif{else}uploads/{$product->image}{/if}" alt="" />
</div>
</div>


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/edit/" method="post">
<p><label for="name">Name</label>
<input name="name" type="text" value="{$product->name}" /></p>
<p><label for="category">Category</label>
<select name="category">
{html_options options=$categories selected=$product->category_id}
</select></p>
<p><label for="description">Description</label>
<textarea cols="3"0 rows="9" name="description">{$product->description}</textarea></p>

<p><label for="price">Price</label>
<input type="text" name="price" value="{$product->price}" /></p>


<p>Ranges</p>

{foreach from=$ranges item=range key=key}
<p><label for="range_{$key}">{$range}</label><input id="range_{$key}" type="checkbox" name="range[]" value={$key} {if in_array($key, $product_ranges)}checked{/if} /></p>
{/foreach}

<p><label>&nbsp;</label><input type="submit" name="submit_product" value="Save" /></p>
<input type="hidden" name="id" value="{$product->id}" />
</form>
<div class="clear">&nbsp;</div>




{elseif $event eq 'upload_image'}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/upload_image/" method="post" enctype="multipart/form-data">
<p><label for="file">File</label>
<input type="file" name="file" /></p>
<p>
<input type="hidden" name="id" value={$product->id} />
<input type="submit" name="upload" value="Upload" />
</p>
</form>
{if $error neq ''}
<p>{$error}</p>
{/if}


{elseif $event eq 'attributes'}

<h2>{$product->name}</h2>

<p>Warning: These cannot be modified once there are stock items in the system!</p>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/attributes/" method="post">
{foreach from=$attributes item=attribute key=key}
<p><label for="attr_{$key}">{$attribute}</label><input id="attr_{$key}" type="checkbox" name="attribute[]" value={$key} {if in_array($key, $selected_attr)}checked{/if} {if $stock_exists eq 1}disabled{/if} /></p>
{/foreach}

<p>
<input type="hidden" name="product_id" value="{$product->id}" />
<input type="submit" value="Save" name="save_attr" {if $stock_exists eq 1}disabled{/if} />
</p>
</form>
<div class="clear">&nbsp;</div>

{/if}



{include file="admin_footer.tpl"}
*}