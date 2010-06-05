{include file="elib:/admin/admin_header.tpl"}


<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey clear">


{if $error neq ''}
<ul id="error">
{foreach from=$error item=i}
<li>{$i}</li>
{/foreach}
</ul>
{/if}

<form action="" method="post">
<p>
<label>Existing Password</label>
<input type="password" name="old_password" value="" />
</p>
<p>
<label>New Password</label>
<input type="password" name="password1" value="" />
</p>
<p>
<label>New Password (Confirmation)</label>
<input type="password" name="password2" value="" />
</p>
<p>
<label>&nbsp;</label>
<button type="submit" name="submit">Submit</button>
<button type="submit" name="cancel">Cancel</button>
</p>
</form>


</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>




{include file="elib:/admin/admin_footer.tpl"}