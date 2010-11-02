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

<div class="event">
<form action="" method="post">
<p>
<label>Event Name</label>
<input type="text" name="event_name" value="" />
</p>
<p>
<label>Start Date</label>
<select name="start_day">
{html_options options=$select_days selected=$day}
</select>
<select name="start_month">
{html_options options=$select_months selected=$month}
</select>
<select name="start_year">
{html_options options=$select_years selected=$year}
</select>
</p>

<p>
<label>Start Time</label>
<select name="start_hour">
{html_options options=$select_hours selected=$hour}
</select>
<select name="start_minute">
{html_options options=$select_minutes selected=$minute}
</select>
</p>

<p>&nbsp;</p>
<hr />


<p>
<label>End Date</label>
<select name="end_day">
{html_options options=$select_days selected=$day}
</select>
<select name="end_month">
{html_options options=$select_months selected=$month}
</select>
<select name="end_year">
{html_options options=$select_years selected=$year}
</select>
</p>

<p>
<label>End Time</label>
<select name="end_hour">
{html_options options=$select_hours selected=$hour}
</select>
<select name="end_minute">
{html_options options=$select_minutes selected=$minute}
</select>
</p>



<p>
<label>Short Description</label>
<textarea rows="" cols="" name="short_desc"></textarea>
</p>

<p>
<label>Long Description</label>
<textarea rows="" cols="" name="long_desc"></textarea>
</p>


<p>
<label>Facebook Event</label>
<input type="text" name="event_link" value="" />
</p>

<p>
<label>Tickets Link</label>
<input type="text" name="tickets_link" value="" />
</p>

<p>
<label>&nbsp;</label>
<button type="submit" name="submit">Save</button>
<button type="submit" name="cancel">Cancel</button>
</p>
</form>
</div>

</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>




{include file="elib:/admin/admin_footer.tpl"}