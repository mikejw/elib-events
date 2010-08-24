
{include file="elib://admin/admin_header.tpl"}


<div class="grey clear">

<table>
<tr>
<th>Order No / Invoice No</th>
<th>Customer</th>
<th>Status</th>
<th>Value</th>
<th>Date</th>
</tr>

{foreach from=$orders item=order}
<tr>
<td><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/order/{$order.id}">00{$order.id}/{$order.stamp|date_format:"%d%m%y"}</a></td>
<td>{$order.username}</td>
<td>{$order.status}</td>
<td>{$order.total}</td>
<td>{$order.stamp|date_format:"%d/%m/%y @ %H:%M:%S"}</td>
</tr>
{/foreach}
</table>




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