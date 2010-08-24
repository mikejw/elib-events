{include file="elib://admin/admin_header.tpl"}


<div id="operations">

<div class="grey" style="padding:0.5em;">

<div id="op_right">
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/properties" method="get">
<div><button type="submit" name="manage_properties" value="1">Manage Properties</button></div>
</form>
</div>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/add_category/{$category->id}" method="get">
<div><button type="submit" name="add_category" value="1"{if sizeof($products) > 0} disabled="disabled"{/if}>Add Category</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/rename/{$category->id}" method="get">
<div><button type="submit" name="rename" value="1"{if $category->id eq 0 || $event eq 'rename'} disabled="disabled"{/if}>Rename Category</button></div>
</form>
<form class="confirm" action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/delete/{$category->id}" method="get">
<div><button type="submit" name="delete_category" value="1"{if $category->id eq 0} disabled="disabled"{/if}>Delete Category</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/add/{$category->id}" method="get">
<div><button type="submit" name="add_product" value="1"{if $category_has_children} disabled="disabled"{/if}>Add Product</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/active_properties/{$category->id}" method="get">
<div><button type="submit" name="active_properties" value="1"{if $category->id eq 0 || $event eq 'active_properties'} disabled="disabled"{/if}>Active Properties</button></div>
</form>

</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>


<div class="grey clear">

{if $category_id != 0}
<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/0/?page=1">Top Level</a></p>
{/if}

<div id="categories">
{$nav}
</div>



{if $event eq 'rename'}
{include file="products/rename.tpl"}
{elseif $event eq 'active_properties'}
{include file="products/active_properties.tpl"}
{elseif $class eq 'product'}
{include file="products/edit_product.tpl"}
{elseif $category_has_children == 0}
{include file="products/products.tpl"}
{/if}


</div>


<p style="line-height: 0.5em;">&nbsp;</p>


<div class="grey" style="padding:0.5em;">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/resize_images" method="get">
<div><button type="submit" name="resize_images" value="1">Resize Images</button></div>
</form>


</div>




{include file="elib://admin/admin_footer.tpl"}









{*

{include file="header.tpl"}

{include file="comp_admin.tpl"}


{foreach from=$categories item=category key=cat_id}
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/edit/" method="post">
<p><label for="name">Name</label>
<input name="name" type="text" value="{$category.name}" /></p>
<p>Default Attributes</p>
{foreach from=$attributes item=attribute key=attr_id}
<p><label for="attr_{$attr_id}">{$attribute}</label>
<input id="attr_{$attr_id}" type="checkbox" name="attribute[]" value={$attr_id} {if in_array($attr_id, $category.attributes)}checked{/if} />
</p>
{/foreach}


<p>
<input type="hidden" name="category_id" value="{$cat_id}" />
<input type="submit" value="Save" name="save_cat" />
</p>

</form>
<div class="clear">&nbsp;</div>
{/foreach}

<p><a href="http://localhost/shop/public_html/admin/range/add/">Add New</a></p>

{include file="footer.tpl"}

*}