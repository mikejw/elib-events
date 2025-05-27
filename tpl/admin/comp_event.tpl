<h4>Add / Edit Event</h4>

<form action="" method="post" class="form">

    <div class="form-group">
        <label for="name">Name</label>
        <input
                name="name"
                type="text"
                class="form-control {if isset($errors.event_name)}is-invalid{elseif $submitted}is-valid{/if}"
                id="name"
                placeholder="Name"
                value="{if $event->event_name neq ''}{$event->event_name}{else}{$event->event_name}{/if}"
        >
        {if isset($errors.event_name)}
            <div class="invalid-feedback">
                {$errors.event_name}
            </div>
        {/if}
    </div>


    

    <div id="event_start" class="clear">
        <p>
            <label>Start Date{if isset($errors.start_time)}<span class="error">{$errors.start_time}</span>{/if}</label>
            <select name="start_day">
                {html_options options=$select_days selected=$event->getStartDay()}
            </select>
            <select name="start_month">
                {html_options options=$select_months selected=$event->getStartMonth()}
            </select>
            <select name="start_year">
                {html_options options=$select_years selected=$event->getStartYear()}
            </select>
        </p>

        <p>
            <label>Start Time</label>
            <select name="start_hour">
                {html_options options=$select_hours selected=$event->getStartHour()}
            </select>
            <select name="start_minute">
                {html_options options=$select_minutes selected=$event->getStartMinute()}
            </select>
        </p>

    </div>


    <p>
        <label>End Date{if isset($errors.end_time)}<span class="error">{$errors.end_time}</span>{/if}</label>
        <select name="end_day">
            {html_options options=$select_days selected=$event->getEndDay()}
        </select>
        <select name="end_month">
            {html_options options=$select_months selected=$event->getEndMonth()}
        </select>
        <select name="end_year">
            {html_options options=$select_years selected=$event->getEndYear()}
        </select>
    </p>

    <p>
        <label>End Time</label>
        <select name="end_hour">
            {html_options options=$select_hours selected=$event->getEndHour()}
        </select>
        <select name="end_minute">
            {html_options options=$select_minutes selected=$event->getEndMinute()}
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
        <input type="text" name="event_link" value="{$event->event_link}"/>
    </p>

    <p>
        <label>Tickets Link{if isset($errors.tickets_link)}<span class="error">{$errors.tickets_link}</span>{/if}
        </label>
        <input type="text" name="tickets_link" value="{$event->tickets_link}"/>
    </p>

    <p>
        <label>&nbsp;</label>
        <button class="btn btn-default" type="submit" name="submit">Save</button>
        <button class="btn btn-default" type="submit" name="cancel">Cancel</button>
    </p>
</form>
</div>


