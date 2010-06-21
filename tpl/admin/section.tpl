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

{if $class eq 'section'}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/add_data/{$section_id}" method="get">
<div><button type="submit" name="add_data_item" value="1"{if $event eq 'add_data'} disabled="disabled"{/if}>Add Data</button></div>
</form>
<form class="confirm" action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/delete/{$section_id}" method="get">
<div><button type="submit" name="delete_section" value="1"{if $section_id eq 0} disabled="disabled"{/if}>Delete</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/rename/{$section_id}" method="get">
<div><button type="submit" name="rename" value="1"{if $section->id eq 0 || $event eq 'rename'} disabled="disabled"{/if}>Rename</button></div>
</form>

{elseif $class eq 'data_item'}

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
<div><button type="submit" name="edit_meta" value="1"{if $event eq 'edit_meta' || $class eq 'section'} disabled="disabled"{/if}>Edit Meta</button></div>
</form>


{if $class eq 'data_item'}
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/data_item_toggle_hidden/{$data_item_id}" method="get">
<div><button type="submit" name="hide" value="1">{if $data_item->hidden}Show{else}Hide{/if}</button></div>
</form>
{elseif $class eq 'section'}
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
{if $class eq 'section'}
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







{*



{if sizeof($child_sections) > 0}
<h3>section parent</h3>
{else}
<h3>{$current_section->type|lower}</h3>
{/if}

{if isset($current_section)}
<div id="section">
<h2>Section Operations</h2>
<ul>
<!-- not top level -->
{if $level neq 0}
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/rename/{$current_section->id}">Rename</a></li>
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/remove/{$current_section->id}">Remove</a></li>
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/toggle_hidden/{$current_section->id}">{if $current_section->hidden eq 1}
Unhide{else}Hide{/if}</a></li>
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/change_type/{$current_section->id}">Change Type</a></li>
{if $current_section->link eq ''}
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/make_link/{$current_section->id}">Make External Link</a></li>
{else}
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/remove_link/{$current_section->id}">Remove Link</a></li>
{/if}
{/if}
<!-- has child sections -->
{if sizeof($child_sections) > 0}
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/remove_children/{$section_id}">Remove Child Sections</a></li>
{/if}
<!-- contains data -->
{if $no_data neq 1}
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/destroy_data/{$current_section->id}">Destroy Data</a></li>
{/if}
<!-- not above invalid level -->
{if $level < 2}
<li><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/create/{$section_id}">Add New Child</a></li>
{/if}

</ul>
</div>
{/if}

<div>
<!--<div id="sections">-->
<h2>Child Sections{if $section_id neq 0} [<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/sections/{$parent_id}">Up</a>]
{/if}</h2>
{if sizeof($child_sections) > 0}
<table width="100%" border="0">
<tr>
<th>Label</th><th>URL Component</th><th>Position</th><th>Data Status</th>
</tr>
{section name=section loop=$child_sections}
<tr {cycle values="class=\"alt\", class=\"non_alt\""}>
<td><a {if $child_sections[section].hidden eq 1}class="hidden" {/if}
href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/sections/{$child_sections[section].id}">{$child_sections[section].label}</a></td>
<td class="url">{$child_sections[section].friendly_url|truncate:20:"..."}</td>
<td class="url">

{if $current_section->id eq 0}
{$child_sections[section].position}
{else}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/change_position" method="post">
<select name="position" onchange="javascript: this.form.submit();">
{foreach from=$child_position_options item=position}
<option{if $child_sections[section].position eq $position} selected="selected"{/if}>{$position}</option>
{/foreach}
</select>
<input type="hidden" name="id" value="{$child_sections[section].id}" />
</form>
{/if}
</td>

<td>
{if $child_sections[section].data_status neq 0}
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/img/{if $child_sections[section].data_status eq 1}data_hidden.gif{elseif $child_sections[section].data_status eq 2}data_half.gif{else}data_full.gif{/if}" alt="" width="18" height="18" />
{else}
&nbsp;
{/if}
</td>

</tr>
{/section}
</table>
{else}
<p>No child sections.</p>
{/if}
</div>



{if $no_data neq 1}
{section name=data_item loop=$data}
<div class="{if $data[data_item].hidden eq 1}data_hidden{else}data{/if}">
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/img/uploads/{if $data[data_item].image eq ''}blank.png{else}{$data[data_item].image}{/if}" alt="" />
<h1>{$data[data_item].heading}</h1>
<p>{$data[data_item].body}</p>
<p class="clear">&nbsp;</p>
{if $data[data_item].locked_by eq $user_id || $data[data_item].locked_by eq ''}
<p class="event">
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/edit_text/{$data[data_item].id}">Edit Text</a>
{if $data[data_item].image neq ''}
| <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/reset_image/{$data[data_item].id}">Reset Image</a>
{/if}
| <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/upload_image/{$data[data_item].id}">Upload Image</a>
{if $current_section->type neq 'DEFAULT'}
| <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/remove/{$data[data_item].id}">Remove</a>
{/if}
{if $data[data_item].hidden eq 1}
| <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/unhide/{$data[data_item].id}">Unhide</a>
{else}
| <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/hide/{$data[data_item].id}">Hide</a>
{/if}
</p>
{if $current_section->type eq 'NEWS'}
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/change_position" method="post">
<select name="position" onchange="javascript: this.form.submit();">
{foreach from=$position_options item=position}
<option{if $data[data_item].position eq $position} selected{/if}>{$position}</option>
{/foreach}
</select>


<!--
{html_options name=position options=$position_options selected=$data[data_item].position}
-->

<input type="hidden" name="id" value="{$data[data_item].id}" />
</form>
{/if}

{else}
<p>Locked by user: <strong>{$data[data_item].locked_by_user}</strong></p>
{/if}
</div>
{/section}
{else}
<div class="clear">&nbsp;</div>
{/if}

{if $current_section->type eq 'DEFAULT' || $current_section->type eq 'GALLERY'}
{if sizeof($child_sections) == 0 && $no_data eq 1}
<p>No data in this section. <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/create/{$section_id}">Create Template</a></p>
{/if}
{elseif $current_section->type neq ''}
<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/create/{$section_id}">Add New Data Item</a></p>
{/if}

{if $current_section->type eq 'GALLERY'}
<div class="clear">&nbsp;</div>
<div id="gallery">
<p class="event"><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/upload_gallery_image/{$current_section->id}">Upoad Gallery Image</a></p>
{foreach from=$gallery key=i item=image}
<div class="img">
<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/misc/view_image/?gallery={$gallery_path}&amp;file={$image}">
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/img/{$gallery_path}/tn_{$image}" alt="" />
</a>
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section/remove_gallery_image/{$current_section->id}/?file={$image}">Delete</a></p>
</div>
{/foreach}
</div>
{/if}


*}


{include file="elib:/admin/admin_footer.tpl"}
