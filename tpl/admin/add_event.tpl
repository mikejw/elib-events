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
<label>Event Name{if isset($errors.event_name)}<span class="error">{$errors.event_name}</span>{/if}</label>
<input type="text" name="event_name" value="{$event->event_name}" />
</p>

<div id="event_start" class="clear">
<p>
<label>Start Date{if isset($errors.start_time)}<span class="error">{$errors.start_time}</span>{/if}</label>
<select name="start_day">
{html_options options=$select_days selected=$event->start_day}
</select>
<select name="start_month">
{html_options options=$select_months selected=$event->start_month}
</select>
<select name="start_year">
{html_options options=$select_years selected=$event->start_year}
</select>
</p>

<p>
<label>Start Time</label>
<select name="start_hour">
{html_options options=$select_hours selected=$event->start_hour}
</select>
<select name="start_minute">
{html_options options=$select_minutes selected=$event->start_minute}
</select>
</p>

</div>


<p>
<label>End Date{if isset($errors.end_time)}<span class="error">{$errors.end_time}</span>{/if}</label>
<select name="end_day">
{html_options options=$select_days selected=$event->end_day}
</select>
<select name="end_month">
{html_options options=$select_months selected=$event->end_month}
</select>
<select name="end_year">
{html_options options=$select_years selected=$event->end_year}
</select>
</p>

<p>
<label>End Time</label>
<select name="end_hour">
{html_options options=$select_hours selected=$event->end_hour}
</select>
<select name="end_minute">
{html_options options=$select_minutes selected=$event->end_minute}
</select>
</p>



<p>
<label>Short Description</label>
<textarea rows="" cols="" name="short_desc">{$event->short_desc}</textarea>
</p>

<p>
<label>Long Description</label>
<textarea rows="" cols="" name="long_desc">{$event->long_desc}</textarea>
</p>


<p>
<label>Facebook Event{if isset($errors.event_link)}<span class="error">{$errors.event_link}</span>{/if}</label>
<input type="text" name="event_link" value="{$event->event_link}" />
</p>

<p>
<label>Tickets Link{if isset($errors.tickets_link)}<span class="error">{$errors.tickets_link}</span>{/if}</label>
<input type="text" name="tickets_link" value="{$event->tickets_link}" />
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