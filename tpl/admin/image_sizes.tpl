{include file="elib:/admin/admin_header.tpl"}

<div id="operations">
<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey" style="padding:0.5em;">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/image_sizes/add" method="get">
<div><button type="submit" name="add" value="1">Add</button></div>
</form>


</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>




<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey">



{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}

<div id="image_sizes">

<form action="" method="post">

<table>
<tr>
<th>Name</th><th>Prefix</th><th>Max Width</th><th>Max Height</th>
<th>&nbsp;</th>
</tr>
{foreach from=$image_sizes item=i}
<tr>
<td><span id="name_{$i.id}" class="edit_box">{$i.name}</span></td>
<td><span id="prefix_{$i.id}" class="edit_box">{$i.prefix}</span></td>
<td><span id="width_{$i.id}" class="edit_box">{$i.width}</span></td>
<td><span id="height_{$i.id}" class="edit_box">{$i.height}</span></td>
<td>
<a class="confirm" href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/image_sizes/remove/{$i.id}">Remove</a> | 
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/image_sizes/update/{$i.id}">Update</a>
</td>
</tr>
{/foreach}
</table>

{*
<p>
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
*}
</form>
</div>




<p class="clear">&nbsp;</p>




</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>




{include file="elib:/admin/admin_footer.tpl"}


