@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')
    <section class="booking-section notifica-section">
        <div class="container">
            <div class="wrap">
                <div class="full-col book-result">
                    <div class="col-sm-8 book-result-info">
                        {{--<p>Unread Notification</p>--}}
                    </div>
                    <div class="col-sm-4 book-result-form">
                        <form action="#" method="post">
                            <div class="col-xs-4 form-group">
                                <select class="selectpicker">
                                    <option>Sort by</option>
                                    <option>Accending Order</option>
                                    <option>Deccending Order</option>
                                </select>
                            </div>
                            <div class="col-xs-8 form-group">
                                <input   type="text"  name="date" placeholder="Search" class="form-control">
                            </div>
                        </form>
                    </div>
                </div>
                @php
                    if(Auth::check())
                    {
                        if(Auth::user()->type == 'individual')
                        {
                            $booking_url = '/user/dashboard/bookings-detail/';
                        } else {
                            $booking_url = '/company/dashboard/bookings-detail/';
                        }
                    }
                @endphp


                <div class="notification">
                    @foreach($notifications as $notification)
                        @php
                            $read = '';
                            $notification_type = '';
                            $space = get_space($notification->data['booking']['space_id']);

                        if($notifications_types['NewBooking'] == $notification->type || $notifications_types['NewHotelOwnerBooking'] == $notification->type)
                        {
                            $notification_type = 'New Booking';
                        } elseif ($notifications_types['ApproveBooking'] == $notification->type){
                            $notification_type = 'Approve Booking';
                        } elseif ($notifications_types['CancelBooking'] == $notification->type){
                            $notification_type = 'Cancel Booking';
                        }elseif ($notifications_types['ReminderBooking'] == $notification->type){
                            $notification_type = 'Booking Reminder';
                        }

                        if(!$notification->read_at)
                        {
                           $read = 'un-read-notify';
                        }

                        @endphp
                        <a href="{{url($booking_url.$notification->data['booking']['id'].'?read='.$notification->id)}}">
                            <div class="book-list {{$read}}">
                                <div class="b-list-img col-sm-2">
                                    <img src="{{get_space_cover($notification->data['booking']['space_id'])}}" alt="" />
                                </div>
                                <div class="b-list-info col-sm-3">
                                    <h4>{{$space->venue->title}}</h4>
                                    <h3>{{$space->title}}</h3>
                                    <h5>{{$space->venue->city}}</h5>
                                </div>
                                <div class="b-list-date col-sm-3">
                                    {{date('d M', strtotime($notification->data['booking']['start_date']))}} to {{date('d M', strtotime($notification->data['booking']['end_date']))}}<span>{{$notification->data['booking']['purpose']}}</span>
                                </div>
                                <div class="status col-sm-2">
                                    {{$notification_type}}
                                </div>
                                <div class="notify-date col-sm-2">
                                    {{date('d M Y', strtotime($notification->data['booking']['created_at']))}}
                                </div>
                            </div><!--booking list-->
                        </a>
                    @endforeach
                </div>
                {{$notifications->links()}}
            </div>
        </div><!--container-->
        <div class="clearfix"></div>
    </section>
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
    <script>
        $("#venue_search_main").validate({
            rules: {
                location: {
                    required: true
                },
                people: {
                    required: true
                },
            },
            messages: {
                location: {
                    required: "Please select a Location",
                },
                people: {
                    required: "Attendees is Required",
                }
            }
        });


        function submitForm(id) {
            $("#"+id).submit();
        }

    </script>
@endsection

