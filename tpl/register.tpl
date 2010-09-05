{include file="header.tpl"}

<div id="content_inner">

<h2>Register</h2>

<p>Please note: Usernames must be between four and eight characters long and cannot start with a number. You can add more shipping addresses later.</p>

<div id="user_form">

{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}

<form action="" method="post">
<fieldset>
<legend>Account</legend>
<p>
<label>Username</label>
<input type="text" name="username" value="{$user->username}" />
</p>
<p>
<label>email address</label>
<input type="text" name="email" value="{$user->email}" />
</p>
</fieldset>

<fieldset>
<legend>Shipping Address</legend>
<p>
<label>Firstname(s)</label>
<input type="text" name="first_name" value="{$address->first_name}" />
</p>
<p>
<label>Lastname</label>
<input type="text" name="last_name" value="{$address->last_name}" />
</p>
<p>
<label>First Line of Address</label>
<input type="text" name="address1" value="{$address->address1}" />
</p>
<p>
<label>Second Line of Address (Optional)</label>
<input type="text" name="address2" value="{$address->address2}" />
</p>
<p>
<label>City</label>
<input type="text" name="city" value="{$address->city}" />
</p>
<p>
<label>County / State</label>
<input type="text" name="state" value="{$address->state}" />
</p>
<p>
<label>Post Code / Zip</label>
<input type="text" name="zip" value="{$address->zip}" />
</p>
<p>
<label>Country</label>
<select name="country">
{html_options options=$countries selected=$sc}
</select>
</p>
</fieldset>





<p>
<label>&nbsp;</label>
<button type="submit" name="submit">Submit</button>
</p>
</form>

</div>

</div>

{include file="footer.tpl"}