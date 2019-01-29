<div class="row banner_frm banner_frm-expand midtext fade-up-ani" id="search_banner">
    <form action="{{url('venues/search')}}" method="GET" id="venue_search_main">
        {{--@csrf--}}
        <div class="col-sm-4 form-group loc-field">
            <input type="text" name="location" placeholder="Meeting city e.g. London" class="form-control Search-location" list="Search-location" required>
            <datalist id="Search-location">

            </datalist>
        </div>
        <div class="col-sm-1 form-group per-field">
            <span class="input-number-decrement"><img src="{{url('images/up.png')}}" alt="" /></span>
            <input class="input-number" name="people" type="text" min="0" placeholder="People" required>
            <span class="input-number-increment"><img src="{{url('images/down.png')}}" alt="" /></span>
        </div>
        <div class="col-sm-2 form-group dur-field">
            <select class="selectpicker" name="duration">
                <option value="Full Day">Full Day</option>
                <option value="Morning">Morning</option>
                <option value="Afternoon">Afternoon</option>
                <option value="Evening">Evening</option>
            </select>
        </div>
        <div class="col-sm-2 form-group date-field ">
            <input type="text"  name="start_date" placeholder="Start Date" class="form-control" id="date" required>
        </div>
        <div class="col-sm-2 form-group date-field end-date-field">
            <input type="text"  name="end_date" placeholder="End Date" class="form-control" id="end-date">
        </div>
        <div class="col-sm-2 form-group btn-field">
            <div class="ani-btn"><button type="submit">Search</button></div>
        </div>
    </form>
</div><!-- bannerform -->


<script>
    function checkDays(value) {
        if(value === 'More than one day')
        {
            $('#search_banner').addClass('banner_frm-expand');
        } else {
            $('#search_banner').removeClass('banner_frm-expand');
        }
    }

</script>