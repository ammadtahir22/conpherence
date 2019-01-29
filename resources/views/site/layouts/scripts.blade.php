<script>
    // hide alert massages after 5 sec
    hide_alert();
    function hide_alert()
    {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 8000); // <-- time in milliseconds
    }
</script>
<script type="text/javascript" src="{{url('js/app.js')}}"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{{--<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>--}}
<script type="text/javascript" src="{{url('js/jquery.min.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-viewport-checker/1.8.8/jquery.viewportchecker.min.js"></script>--}}
<script type="text/javascript" src="{{url('js/jquery.viewportchecker.min.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>--}}
<script type="text/javascript" src="{{url('js/modernizr.js')}}"></script>
{{--<script src='https://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>--}}
<script type="text/javascript" src='{{url('js/jquery-ui.js')}}'></script>
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>--}}
<script type="text/javascript" src="{{url('js/owl.carousel.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individuals files as needed -->
<script type="text/javascript" src="{{url('js/bootstrap.js')}}"></script>
{{--<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js'></script>--}}
<script type="text/javascript" src="{{url('js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{url('js/slider.js')}}"></script>
<script type="text/javascript" src="{{url('js/time.js')}}"></script>
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js'></script>--}}

<script type="text/javascript" src="{{url('js/calender.js')}}"></script>
<script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/custom.js')}}"></script>
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0-RC1/js/bootstrap-datepicker.min.js'></script>--}}
{{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.js'></script>--}}
<script src="{{url('js/jquery.dateFormat.js')}}"></script>

<script>
    function save_item_wishlist(id, item, this_id, other_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url('/save/wishlist')}}',
            type: 'post',
            datatype: 'json',
            data: {
                id: id,
                item: item,
            },
            success: function (response) {
                $('#'+this_id).css('display', 'none');
                $('#'+other_id).css('display', 'block');
                if(item === 'space'){
                    $('#wishlistmsg').text('Space added to your wishlist');
                } else {
                    $('#wishlistmsg').text('Venue added to your wishlist');
                }
                $('#wishlistpopup').modal('show');
                setTimeout(function(){
                    $('#wishlistpopup').modal('hide')
                }, 10000);
            },
            error: function (error) {
                location.href= '{{route('login')}}';
            }
        });
    }

    function remove_item_wishlist(id, item, this_id, other_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{url('/remove/wishlist')}}',
            type: 'post',
            datatype: 'json',
            data: {
                id: id,
                item: item,
            },
            success: function (response) {
                $('#'+this_id).css('display', 'none');
                $('#'+other_id).css('display', 'block');
                if(item === 'space'){
                    $('#wishlistmsg').text('Space removed from your wishlist');
                } else {
                    $('#wishlistmsg').text('Venue removed from your wishlist');
                }

                $('#wishlistpopup').modal('show');
                setTimeout(function(){
                    $('#wishlistpopup').modal('hide')
                }, 10000);
            },
            error: function (error) {
                location.href= '{{route('login')}}';
            }
        });
    }
</script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        orientation: 'left bottom',
        autoclose: true,
        todayHighlight: true
    });
</script>


