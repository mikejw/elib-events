{include file="elib://admin/admin_header.tpl"}

{if $artist->id > 0 && $artist->active neq 1}
<div id="notice">
<p>This artist is currently hidden so will not be visible on the site. This applies to their biography and also their prints. To change this click 'Show Artist'.</p>
</div>
{/if}

<div id="operations">

<div class="grey" style="padding:0.5em;">


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/add" method="get">
<div><button type="submit" name="add" value="1">Add New Artist</button></div>
</form>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/edit_bio/{$artist->id}" method="get">
<div><button type="submit" name="edit_bio" value="1"{if $event eq 'edit_bio' || $artist->id eq 0}disabled="disabled"{/if}>Add/Edit Bio</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/rename/{$artist->id}" method="get">
<div><button type="submit" name="rename" value="1"{if $event eq 'rename' || $artist->id eq 0}disabled="disabled"{/if}>Rename Artist</button></div>
</form>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/upload_image/{$artist->id}" method="get">
<div><button type="submit" name="upload_image" value="1"{if $artist->id eq 0} disabled="disabled"{/if}>Upload Artist Photo</button></div>
</form>

{*
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/delete/{$artist->id}" method="get">
<div><button type="submit" name="delete" value="1">Delete</button></div>
</form>
*}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/toggle_active/{$artist->id}" method="get">
<div><button type="submit" name="toggle_active" value="1"{if $artist->id eq 0}disabled="disabled"{/if}>{if $artist->active}Hide Artist{else}Show Artist{/if}</button></div>
</form>

</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>




<div class="grey clear">


{$banners}



{if $event eq 'rename'}
{include file="elib://admin/rename_artist.tpl"}
{elseif $event eq 'edit_bio'}
{include file="elib://admin/edit_artist_bio.tpl"}
{elseif $event eq 'upload_image'}
{include file="elib://admin/upload_artist_image.tpl"}
{else}

<div id="right">
{if $artist->image neq ''}
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/uploads/mid_{$artist->image}" alt="" />
{else}&nbsp;
{/if}
</div>


{/if}





</div>








{include file="elib://admin/admin_footer.tpl"}