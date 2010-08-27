{include file="elib://admin/admin_header.tpl"}


<div id="operations">

<div class="grey" style="padding:0.5em;">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/brand/add" method="get">
<div><button type="submit" name="add" value="1">Add</button></div>
</form>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/brand/edit_bio/{$artist->id}" method="get">
<div><button type="submit" name="edit_bio" value="1"{if $event eq 'edit_bio'}disabled="disabled"{/if}>Edit Bio</button></div>
</form>
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/brand/rename/{$artist->id}" method="get">
<div><button type="submit" name="rename" value="1"{if $event eq 'rename'}disabled="disabled"{/if}>Rename</button></div>
</form>

<form class="confirm" action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/brand/delete/{$artist->id}" method="get">
<div><button type="submit" name="delete" value="1">Delete</button></div>
</form>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category/0" method="get">
<div><button type="submit" name="view_products" value="1"{if $artist->id eq 0}disabled="disabled"{/if}>View Products</button>
<input type="hidden" name="artist_id" value="{$artist->id}" /></div>
</form>

</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>






<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey clear">


{$banners}



<div id="right">

{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}


{if $event eq 'rename'}
{include file="elib://admin/rename_brand.tpl"}
{elseif $event eq 'edit_bio'}
{include file="elib://admin/edit_brand_bio.tpl"}
{/if}



</div>


</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>








{include file="elib://admin/admin_footer.tpl"}