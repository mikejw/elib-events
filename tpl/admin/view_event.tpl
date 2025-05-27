{include file="elib:admin/admin_header.tpl"}


<div class="grey_top">
<div class="top_right">
<div class="top_left"></div>
</div>
</div>

<div class="grey clear">

<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/events/edit_event/{$event->id}" method="get">
<p><button class="btn btn-default" type="submit" name="edit">Edit</button></p>
</form>


<div class="event">

<p>
<label>Event Name</label>
<span>{$event->event_name}</span>
</p>
<p>
<label>Start</label>
<span>{$event->start_time}</span>
</p>

<p>
<label>End</label>
<span>{$event->end_time}</span>
</p>



<p>
<label>Short Description</label></p>
{$event->short_desc}


<p>
<label>Long Description</label></p>
{$event->long_desc}


<p>
<label>Facebook Event</label>
<span>{$event->event_link}</span>
</p>

<p>
<label>Tickets Link</label>
<span>{$event->tickets_link}</span>
</p>

</div>


</div>
<div class="grey_bottom">
<div class="bottom_right">
<div class="bottom_left"></div>
</div>
</div>




{include file="elib:admin/admin_footer.tpl"}