


<form action="" method="post" enctype="multipart/form-data">
<p><label for="file">File</label>
<input type="file" name="file" /></p>
<p>
<input type="hidden" name="id" value="{$artist->id}" />
<button type="submit" name="upload">Upload</button>
 <button type="submit" name="cancel">Cancel</button>
</p>
</form>
{if $error neq ''}
<p>{$error}</p>
{/if}
