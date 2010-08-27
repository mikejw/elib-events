
{include file="elib://admin/admin_header.tpl"}


<div class="grey clear">

<table>
<tr>
<th>Order No / Invoice No</th>
<th>Customer</th>
<th>Status</th>
<th>Value</th>
<th>Date</th>
</tr>

{foreach from=$orders item=order}
<tr>
<td><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/order/{$order.id}">00{$order.id}/{$order.stamp|date_format:"%d%m%y"}</a></td>
<td>{$order.username}</td>
<td>{$order.status}</td>
<td>{$order.total}</td>
<td>{$order.stamp|date_format:"%d/%m/%y @ %H:%M:%S"}</td>
</tr>
{/foreach}
</table>




</div>






{include file="elib://admin/admin_footer.tpl"}
