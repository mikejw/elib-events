
<div id="right">

{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}

<form action="" method="post">
<fieldset>
<legend>Rename Category</legend>
<p>
<label>Name</label>
<input type="text" name="name" value="{$category->name}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$category->id}" />
<button type="submit" name="save">Save</button>
</p>
</fieldset>
</form>
</div>