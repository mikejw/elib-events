
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
<legend>Rename Artist</legend>
{*
<p>
<label>Alias</label>
<input type="text" name="artist_alias" value="{$artist->artist_alias}" />
</p>
*}
<p>
<label>Forename</label>
<input type="text" name="forename" value="{$artist->forename}" />
</p>
<p>
<label>Surename</label>
<input type="text" name="surname" value="{$artist->surname}" />
</p>
<p>
<label>&nbsp;</label>
<input type="hidden" name="id" value="{$artist->id}" />
<button type="submit" name="save">Save</button>
 <button type="submit" name="cancel">Cancel</button>
</p>
</fieldset>
</form>

</div>