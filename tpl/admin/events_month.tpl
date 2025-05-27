{include file="elib:admin/admin_header.tpl"}

<div id="operations">
<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey" style="padding:0.5em;">


<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events" method="get">
<div><button class="btn btn-default" type="submit" name="today" value="1">Goto Today</button></div>
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

<div id="events_nav" class="clear">
<h1>
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/?month={$prev_month_link}"><</a>
<span>{$month}</span>
<a class="end" href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/?month={$next_month_link}">></a>
</h1>
<h1>
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/?month={$prev_year_link}"><</a>
<span>{$year}</span>
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/?month={$next_year_link}">></a>
</h1>
</div>


<table id="month" class="table">
<tr>
<th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th class="bg-light">S</th><th class="bg-light">S</th>
</tr>

<tr>
{counter start=0 assign="j"}
{foreach from=$cal_month item=m key=i}

<td class="{if $m.current_month eq true}current{/if} {if ($i + 1 - $j) % 6 == 0 or ($i + 1) % 7 == 0}bg-light{/if}">

<div class="clear">
<span class="day">{$m.day}</span>
<span class="add">
    <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/add_event/?date={$year}{$m.month|string_format:"%02d"}{$m.day|string_format:"%02d"}">+</a>
</span>
</div>
{if isset($m.events)}
{foreach from=$m.events item=e}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/view_event/{$e.id}">{$e.event_name}</a><br />
{/foreach}
{/if}
</td>

{if ($i+1) % 7 == 0 && $i < 35}
    {counter}
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



{include file="elib:admin/admin_footer.tpl"}
