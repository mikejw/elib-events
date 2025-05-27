<h4>Add / Edit Event</h4>

<form action="" method="post" class="form">

    <div class="form-group">
        <label for="name">Name</label>
        <input
                name="event_name"
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


    <div class="form-group row mb-2">
        <label for="" class="col-sm-2 col-form-label">Start Date</label>
        
        <select
          name="start_day"
          class="col-sm-2 form-control {if isset($errors.start_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_days selected=$event->getStartDay()}
        </select>
        
        <select
           name="start_month"
           class="col-sm-2 form-control {if isset($errors.start_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_months selected=$event->getStartMonth()}
        </select>

        <select
          name="start_year"
          class="col-sm-2 form-control {if isset($errors.start_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_years selected=$event->getStartYear()}
        </select>

    </div>

    <div class="form-group row mb-2">
        <label for="" class="col-sm-2 col-form-label">Start Time</label>
        
        <select
          name="start_hour"
          class="col-sm-2 form-control {if isset($errors.start_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_hours selected=$event->getStartHour()}
        </select>
        
        <select
           name="start_minute"
           class="col-sm-2 form-control {if isset($errors.start_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_minutes selected=$event->getStartMinute()}
        </select>

        {if isset($errors.start_time)}
            <div class="invalid-feedback">
                {$errors.start_time}
            </div>
        {/if}
    </div>


     <div class="form-group row mb-2">
        <label for="" class="col-sm-2 col-form-label">End Date</label>
        
        <select
          name="end_day"
          class="col-sm-2 form-control {if isset($errors.end_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
           {html_options options=$select_days selected=$event->getEndDay()}
        </select>
        
        <select
           name="end_month"
           class="col-sm-2 form-control {if isset($errors.end_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_months selected=$event->getEndMonth()}
        </select>

        <select
          name="end_year"
          class="col-sm-2 form-control {if isset($errors.end_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_years selected=$event->getEndYear()}
        </select>

    </div>

    <div class="form-group row mb-2">
        <label for="" class="col-sm-2 col-form-label">End Time</label>
        
        <select
          name="end_hour"
          class="col-sm-2 form-control {if isset($errors.end_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
                {html_options options=$select_hours selected=$event->getEndHour()}
            </select>
        
        <select
           name="end_minute"
           class="col-sm-2 form-control {if isset($errors.end_time)}is-invalid{elseif $submitted}is-valid{/if}"
        >
            {html_options options=$select_minutes selected=$event->getEndMinute()}
        </select>

        {if isset($errors.end_time)}
            <div class="invalid-feedback">
                {$errors.end_time}
            </div>
        {/if}
    </div>

    

    <div class="form-group">
        <label for="short_desc">Short Description</label>
        <textarea
                name="short_desc"
                class="form-control {if isset($errors.short_desc)}is-invalid{elseif $submitted}is-valid{/if}"
                id="short_desc"
                rows="10"
                placeholder="Type your short description here&hellip; (Optional)"
        >{$event->short_desc}</textarea>
        {if isset($errors.short_desc)}
            <div class="invalid-feedback">
                {$errors.short_desc}
            </div>
        {/if}
    </div>

    <div class="form-group">
        <label for="long_desc">Long Description</label>
        <textarea
                name="long_desc"
                class="form-control {if isset($errors.long_desc)}is-invalid{elseif $submitted}is-valid{/if}"
                id="long_desc"
                rows="10"
                placeholder="Type your long description here&hellip; (Optional)"
        >{$event->long_desc}</textarea>
        {if isset($errors.long_desc)}
            <div class="invalid-feedback">
                {$errors.long_desc}
            </div>
        {/if}
    </div>


    <div class="form-group">
        <label for="event_link">Facebook Event</label>
        <input
                name="event_link"
                type="text"
                class="form-control {if isset($errors.event_link)}is-invalid{elseif $submitted}is-valid{/if}"
                id="event_link"
                placeholder="URL&hellip; (Optional)"
                value="{if $event->event_link neq ''}{$event->event_link}{else}{$event->event_link}{/if}"
        >
        {if isset($errors.event_link)}
            <div class="invalid-feedback">
                {$errors.event_link}
            </div>
        {/if}
    </div>


    <div class="form-group">
        <label for="tickets_link">Tickets</label>
        <input
                name="tickets_link"
                type="text"
                class="form-control {if isset($errors.tickets_link)}is-invalid{elseif $submitted}is-valid{/if}"
                id="tickets_link"
                placeholder="URL&hellip; (Optional)"
                value="{if $event->tickets_link neq ''}{$event->tickets_link}{else}{$event->tickets_link}{/if}"
        >
        {if isset($errors.tickets_link)}
            <div class="invalid-feedback">
                {$errors.tickets_link}
            </div>
        {/if}
    </div>

    
    <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary mb-2">Submit</button>
        <button type="submit" name="cancel" class="btn btn-primary mb-2">Cancel</button>
        <input type="hidden" name="csrf_token" value="{$csrf_token}" />
    </div>

</form>
</div>


