{include file="header.tpl"}

<div id="content_inner">

<h2>Register</h2>

<p>Please note: Usernames must be between four and eight characters long and cannot start with a number. You can add more shipping addresses later.</p>

<div id="user_form">

<form action="" method="post">
<fieldset>
<legend>Account</legend>
<p>
<label>Username{if isset($errors.username)}<span class="error">{$errors.username}</span>{/if}</label>
<input type="text" name="username" value="{$user->username}" />
</p>
<p>
<label>email address{if isset($errors.email)}<span class="error">{$errors.email}</span>{/if}</label>
<input type="text" name="email" value="{$user->email}" />
</p>
</fieldset>

<fieldset>
<legend>Shipping Address</legend>
<p>
<label>Firstname(s){if isset($errors.first_name)}<span class="error">{$errors.first_name}</span>{/if}</label>
<input type="text" name="first_name" value="{$address->first_name}" />
</p>
<p>
<label>Lastname{if isset($errors.last_name)}<span class="error">{$errors.last_name}</span>{/if}</label>
<input type="text" name="last_name" value="{$address->last_name}" />
</p>
<p>
<label>First Line of Address{if isset($errors.address1)}<span class="error">{$errors.address1}</span>{/if}</label>
<input type="text" name="address1" value="{$address->address1}" />
</p>
<p>
<label>Second Line of Address (Optional){if isset($errors.address2)}<span class="error">{$errors.address2}</span>{/if}</label>
<input type="text" name="address2" value="{$address->address2}" />
</p>
<p>
<label>City{if isset($errors.city)}<span class="error">{$errors.city}</span>{/if}</label>
<input type="text" name="city" value="{$address->city}" />
</p>
<p>
<label>County / State{if isset($errors.state)}<span class="error">{$errors.state}</span>{/if}</label>
<input type="text" name="state" value="{$address->state}" />
</p>
<p>
<label>Post Code / Zip{if isset($errors.zip)}<span class="error">{$errors.zip}</span>{/if}</label>
<input type="text" name="zip" value="{$address->zip}" />
</p>
<p>
<label>Country{if isset($errors.country)}<span class="error">{$errors.country}</span>{/if}</label>
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