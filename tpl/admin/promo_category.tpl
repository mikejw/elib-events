{include file="elib://admin/admin_header.tpl"}




{if $event eq 'default_event' || $event eq 'edit'}
<div id="operations">

<div class="grey" style="padding:0.5em;">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/promo_category/add/{$category->id}" method="get">
<div><button type="submit" name="add_promo" value="1">Add Promo</button></div>
</form>

{*
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/edit/{$product->id}" method="get">
<div><button type="submit" name="edit" value="1">Edit</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/upload_image/{$product->id}" method="get">
<div><button type="submit" name="upload_image" value="1">Upload Image</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/delete/{$product->id}" method="get">
<div><button type="submit" name="delete_product" value="1">Delete</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/add_variant/{$product->id}" method="get">
<div><button type="submit" name="add_variant" value="1">Add Variant</button></div>
</form>
*}

</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>
{/if}








<div class="grey clear">


{if $category_id != 0}
<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/promo_category/0/?page=1">Top Level</a></p>
{/if}


<div id="categories">
{$nav}
</div>

{if $event eq 'default_event'}
{include file="elib://admin/promos/promos.tpl"}
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
