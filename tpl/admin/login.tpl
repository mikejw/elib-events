{include file="header.tpl"}

<div id="content_inner">

<p>&nbsp;</p><p>&nbsp;</p>

<div id="user_form">

{if sizeof($errors) > 0}
<ul id="error">
{foreach from=$errors item=error}
<li>{$error}</li>
{/foreach}
</ul>
{/if}


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/misc/" method="post">
<p><label for="username">Username</label>
<input id="username" type="text" name="username"
{if isset($username)}
value="{$username}"{/if} /></p>
<p><label for="password">Password</label>
<input id="password" type="password" name="password"
{if isset($password)}
value="{$password}"{/if} /></p>
<p><label>&nbsp;</label><button type="submit" name="login">Login</button></p>
</form>
</div>

</div>

{include file="footer.tpl"}