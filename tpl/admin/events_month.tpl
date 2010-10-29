{include file="elib:/admin/admin_header.tpl"}

<div id="operations">
<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey" style="padding:0.5em;">


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection/add_section/{$section_id}" method="get">
<div><button type="submit" name="add_section" value="1"{if $class eq 'data_item'} disabled="disabled"{/if}>Add Section</button></div>
</form>

</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>
</div>


<p style="line-height: 0.5em;">&nbsp;</p>



<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey clear">

<h1>
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/?month={$prev_month_link}"><</a>
{$month}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/?month={$next_month_link}">></a>
</h1>



<table id="month">
<tr>
{foreach from=$cal_month item=m key=i}


<td{if $m.current_month eq true} class="current"{/if}>
<span class="day">{$m.day}</span></td>

{if ($i+1) % 7 == 0 && $i < 35}
</tr><tr>
{/if}


{/foreach}
</tr>
</table>

</div>




<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>



{include file="elib:/admin/admin_footer.tpl"}
