{include file="elib:/admin/admin_header.tpl"}

<div id="operations">
<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey" style="padding:0.5em;">

<div id="op_right">
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/containers" method="get">
<div><button type="submit" name="edit_containers" value="1"{if $event eq 'edit_containers'} disabled="disabled"{/if}>Containers</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/image_sizes" method="get">
<div><button type="submit" name="edit_image_sizes" value="1"{if $event eq 'edit_image_sizes'} disabled="disabled"{/if}>Image Sizes</button></div>
</form>
</div>


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/add_section/{$section_id}" method="get">
<div><button type="submit" name="add_section" value="1"{if $class eq 'data_item'} disabled="disabled"{/if}>Add Section</button></div>
</form>

{if $class eq 'dsection' && $event neq 'data_item'}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/add_data/{$section_id}" method="get">
<div><button type="submit" name="add_data_item" value="1"{if $event eq 'add_data'} disabled="disabled"{/if}>Add Data</button></div>
</form>
<form class="confirm" action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/delete/{$section_id}" method="get">
<div><button type="submit" name="delete_section" value="1"{if $section_id eq 0} disabled="disabled"{/if}>Delete</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/rename/{$section_id}" method="get">
<div><button type="submit" name="rename" value="1"{if $section->id eq 0 || $event eq 'rename'} disabled="disabled"{/if}>Rename</button></div>
</form>

{else}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/data_add_data/{$data_item_id}" method="get">
<div><button type="submit" name="add_data_item" value="1"{if $event eq 'add_data' || !$is_container} disabled="disabled"{/if}>Add Data</button></div>
</form>
<form class="confirm" action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/delete_data_item/{$data_item_id}" method="get">
<div><button type="submit" name="delete_data_item" value="1">Delete</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/rename_data_item/{$data_item_id}" method="get">
<div><button type="submit" name="rename" value="1"{if $event eq 'rename'} disabled="disabled"{/if}>Rename</button></div>
</form>

{/if}


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/change_template/{$section_id}" method="get">
<div><button type="submit" name="change_template" value="1"{if $class eq 'data_item' || $event eq 'change_template' || $section_id eq 0} disabled="disabled"{/if}>Change Template</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/edit_data_item_meta/{$data_item_id}" method="get">
<div><button type="submit" name="edit_meta" value="1"{if $event eq 'edit_meta' || $class eq 'dsection'} disabled="disabled"{/if}>Edit Meta</button></div>
</form>


{if $class eq 'data_item'}
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/data_item_toggle_hidden/{$data_item_id}" method="get">
<div><button type="submit" name="hide" value="1">{if $data_item->hidden}Show{else}Hide{/if}</button></div>
</form>
{elseif $class eq 'dsection' && $section_id > 0}
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/toggle_hidden/{$section_id}" method="get">
<div><button type="submit" name="hide" value="1">{if $section->hidden}Show{else}Hide{/if}</button></div>
</form>
{/if}




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

<div class="grey clear">


{if $section_id != 0}
<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/0">Top Level</a></p>
{/if}

{$sections}



<div id="right">

{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}



{if $event eq 'rename'}
{if $class eq 'dsection'}
{include file="elib:/admin/sections/rename_section.tpl"}
{elseif $class eq 'data_item'}
{include file="elib:/admin/sections/rename_data_item.tpl"}
{/if}

{elseif $event eq 'add_data'}

{include file="elib:/admin/sections/add_data.tpl"}

{elseif $event eq 'add_data_heading'}
{include file="elib:/admin/sections/add_data_heading.tpl"}
{elseif $event eq 'add_data_body'}
{include file="elib:/admin/sections/add_data_body.tpl"}
{elseif $event eq 'add_data_image'}
{include file="elib:/admin/sections/add_data_image.tpl"}
{elseif $event eq 'add_data_video'}
{include file="elib:/admin/sections/add_data_video.tpl"}
{elseif $class eq 'data_item' && $event eq 'default_event'}
{include file="elib:/admin/sections/data_item.tpl"}
{elseif $class eq 'data_item' && $event eq 'edit_heading'}
{include file="elib:/admin/sections/edit_heading.tpl"}
{elseif $class eq 'data_item' && $event eq 'edit_body'}
{include file="elib:/admin/sections/edit_body.tpl"}
{elseif $event eq 'change_template'}
{include file="elib:/admin/sections/change_template.tpl"}
{elseif $event eq 'edit_meta'}
{include file="elib:/admin/sections/edit_meta.tpl"}
{elseif $event eq 'edit_containers'}
{include file="elib:/admin/sections/edit_containers.tpl"}
{/if}

</div>




</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>



{include file="elib:/admin/admin_footer.tpl"}
