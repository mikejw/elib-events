
{include file="admin_header.tpl"}


{if $event neq 'rename'}
<div id="operations">
<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey" style="padding:0.5em;">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/containers/add" method="get">
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
{/if}








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


{if $event eq 'rename'}
<fieldset><legend>Rename Container</legend>
<form action="" method="post">
<p><label>Name</label>
<input type="text" value="{$container->name}" name="name" />
</p>
<p><label>&nbsp;</label>
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</form>
</fieldset>

{else}
<div id="properties">

<form action="" method="post">

{foreach from=$containers key=id item=container}

<fieldset><legend>{$container.name}</legend>

<p class="f_actions">
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/containers/rename/{$id}">Rename</a> |
<a class="confirm" href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/containers/remove/{$id}">Remove</a></p>



<p class="clear">
<label>Image Size</label>

<span class="radios">
{html_checkboxes name="image_size[$id]" options=$image_sizes separator="<br />" selected=$container.image_size_ids}
</span>
</p>


{*
{if sizeof($container.image_sizes) > 0}
<p>
<label>&nbsp;</label>
<span>
<table class="inner">
{foreach from=$container.image_sizes item=image_size key=image_size_id}
<tr>
<td>{$image_size}</td>
<td><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/containers/remove_size/{$id}?size={$image_size_id}">Remove</a></td>
</tr>
{/foreach}
</table>
</span>
</p>
{/if}
*}


{*
{if sizeof($container.available_image_sizes) > 0}
<p><label>&nbsp;</label>
<select name="image_size">
{html_options options=$container.available_image_sizes}
</select>

<input type="text" value="{if $submitted_option->property_id eq $id}{$submitted_option->option_val}{/if}" name="option" />
<input type="hidden" name="id" value="{$id}" />
<button type="submit" name="add_option">Add</button>
</p>
{/if}
*}



</fieldset>
{/foreach}

<p>
<button type="submit" name="save">Save</button> 
<button type="submit" name="cancel">Cancel</button>
</p>
</form>
</div>

{/if}


<p class="clear">&nbsp;</p>




</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>






{include file="admin_footer.tpl"}


