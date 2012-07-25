

<div id="data_item">
{if $data_item->heading neq ''}
<h1>{$data_item->heading}</h1>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/edit_heading/{$data_item->id}" method="get">
<div><button type="submit" name="edit_heading" value="1">Edit</button></div>
</form>

{elseif $data_item->body neq ''}

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/edit_body/{$data_item->id}" method="get">
<div><button type="submit" name="edit_body" value="1">Edit</button></div>
</form>

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/edit_body_raw/{$data_item->id}" method="get">
<div><button type="submit" name="edit_body" value="1">Edit Raw</button></div>
</form>

{$data_item->body}



{elseif $data_item->image neq ''}
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/uploads/mid_{$data_item->image}" alt="" />

{elseif $data_item->video neq ''}
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/uploads/tn_{$data_item->video}.jpg" alt="" />
<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/data_item/generate_thumb/{$data_item->id}">Generate New Thumbnail</a></p>
<p>(You may need to refresh your browser before seeing new thumbnails.)</p>

{/if}
</div>