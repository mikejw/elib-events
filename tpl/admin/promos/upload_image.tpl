


<form action="" method="post" enctype="multipart/form-data">
<p><label>File</label>
<input type="file" name="file" /></p>
<p>
<input type="hidden" name="id" value="{$promo->id}" />
<button type="submit" name="upload">Upload</button>
</p>
</form>
{if $error neq ''}
<p>{$error}</p>
{/if}
