{include file="header.tpl"}

<div id="content_inner">

<h2>Sign In</h2>

<p>&nbsp;</p><p>&nbsp;</p>

<div id="user_form">

<form action="" method="post">
<fieldset>
<legend>Login</legend>
<p><label for="username">Username{if isset($errors.username)}<span class="error">{$errors.username}</span>{/if}</label>
<input id="username" type="text" name="username"
{if isset($username)}
value="{$username}"{/if} /></p>
<p><label for="password">Password{if isset($errors.password)}<span class="error">{$errors.password}</span>{/if}</label>
<input id="password" type="password" name="password"
{if isset($password)}
value="{$password}"{/if} /></p>
</fieldset>
<p><label>&nbsp;</label><button type="submit" name="login">Sign in</button>
</p>
</form>

{if isset($errors.success)}
<ul id="error">
<li>{$errors.success}</li>
</ul>
{/if}



</div>



</div>

{include file="footer.tpl"}