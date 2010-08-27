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
