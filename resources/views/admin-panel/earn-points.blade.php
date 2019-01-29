@extends('admin-panel.layouts.app')

@section('css-link')

@endsection

{{--@section('header')--}}
{{----}}
{{--@endsection--}}

@section('left-panel')
    @include('admin-panel.layouts.left-panel')
@endsection

@section('main-panel')
    {{--@include('admin-panel.layouts.main-panel')--}}
    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">
        <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home / Add Earn Points</li>
            </ol>

        </div>
        <!-- END RIBBON -->


        <!-- MAIN CONTENT -->
        <div  id="content" style="opacity: 1;">
            <!--
                The ID "widget-grid" will start to initialize all widgets below
                You do not need to use widgets if you dont want to. Simply remove
                the <section></section> and you can use wells or panels instead
                -->

            <!-- widget grid -->
            <section id="widget-grid" class="">
                <!-- row -->
                <div class="row">
                    @if (session('msg-success'))
                        <p class="alert alert-success" role="alert">
                            {{ session('msg-success') }}
                        </p>
                    @endif

                    @if (session('msg-error'))
                        <p class="alert alert-success" role="alert">
                            {{ session('msg-error') }}
                        </p>
                    @endif

                        <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
                            <div class="jarviswidget jarviswidget-sortable" id="wid-id-0">
                                <header role="heading" class="ui-sortable-handle">
                                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                                    <h2>Promotions </h2>

                                    </header>
                                <div role="content">


                                        <div class="widget-body no-padding">
                             <form class="smart-form" action="{{url('/admin/save/earn-points')}}" method="post" id="add_discount_form">
                        @csrf
                        <!-- NEW WIDGET START -->

                                    <fieldset>
                                        <input type="hidden" name="count" value="3">
                                        <div class="row">

                                            <section style="padding: 14px;"><h1 class="input">Silver Member</h1></section>
                                            <section class="col col-6">
                                                <label class="input">
                                                    Number Of Bookings
                                                    <input name="booking-number-1" value="{{isset($discount_silver) ? $discount_silver->no_of_booking : 0}}" min="0" max="100" placeholder="" type="number" required>
                                                </label>
                                            </section>
                                            <section class="col col-6">
                                                <label class="input">
                                                    Saved In Percentage
                                                    <input type="hidden" name="type1" value="silver">
                                                    <input name="discount1" value="{{isset($discount_silver) ? $discount_silver->discount : 0}}" min="0" max="100" placeholder="Discount %" type="number" required>
                                                </label>
                                            </section>
                                        </div>
                                        <div class="row">
                                            <section style="padding: 14px;"><h1 class="input">Gold Member</h1></section>
                                            <section class="col col-6">
                                                <label class="input">
                                                    Number Of Bookings
                                                    <input name="booking-number-2" value="{{isset($discount_gold) ? $discount_gold->no_of_booking : 0}}" min="0" max="100" placeholder="" type="number" required>
                                                </label>
                                            </section>
                                            <section class="col col-6">
                                                <label class="input">
                                                    Saved In Percentage
                                                    <input type="hidden" name="type2" value="gold">
                                                    <input class="form-control" name="discount2" value="{{isset($discount_gold) ? $discount_gold->discount : 0}}" min="0" max="100" placeholder="Discount %" type="number" required>
                                                </label>
                                            </section>
                                        </div>
                                        <div class="row">
                                            <section style="padding: 14px;"><h1 class="input">Platinum Member</h1></section>
                                            <section class="col col-6">
                                                <label class="input">
                                                    Number Of Bookings
                                                    <input name="booking-number-3" value="{{isset($discount_platinum) ? $discount_platinum->no_of_booking : 0}}" min="0" max="100" placeholder="" type="number" required>
                                                </label>
                                            </section>
                                            <section class="col col-6">
                                                <label class="input">
                                                    Saved In Percentage
                                                    <input type="hidden" name="type3" value="platinum">
                                                    <input class="form-control" name="discount3" value="{{isset($discount_platinum) ? $discount_platinum->discount : 0}}" min="0" max="100" placeholder="Discount %" type="number" required>
                                                </label>
                                            </section>
                                        </div>
                                    </fieldset>
                                    <footer>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-save"></i>
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-default" onclick="window.history.back();">
                                            Back
                                        </button>
                                    </footer>
                                <!-- this is what the user will see -->


                    </form>
                        </div>
                                </div>
                            </div>
                        </article>
                </div>

                <!-- end row -->

                <!-- row -->

                <div class="row">

                    <!-- a blank row to get started -->
                    <div class="col-sm-12">
                        <!-- your contents here -->
                    </div>

                </div>

                <!-- end row -->

            </section>
            <!-- end widget grid -->

        </div>
        <!-- END MAIN CONTENT -->

    </div>
    <!-- END MAIN PANEL -->


@endsection

@section('footer')
    @include('admin-panel.layouts.footer')
@endsection

@section('shortcut')
    @include('admin-panel.layouts.shortcut')
@endsection

@section('scripts')
    @include('admin-panel.layouts.scripts')

    <!-- PAGE RELATED PLUGIN(S) -->



    <script type="text/javascript">

        // $("#add_discount_form").validate();
        // $('#add_discount_form').bootstrapValidator({
        //     feedbackIcons : {
        //         valid : 'glyphicon glyphicon-ok',
        //         invalid : 'glyphicon glyphicon-remove',
        //         validating : 'glyphicon glyphicon-refresh'
        //     }
        // });

        var error_message = "Please enter the required field";
        $("#add_discount_form").validate(
            {
                ignore: [],
                debug: false,
                rules: {
                    "booking-number-1": {
                        required: true
                    },
                    discount1: {
                        required: true
                    },
                    "booking-number-2": {
                        required: true
                    },
                    discount2: {
                        required: true
                    },
                    "booking-number-3": {
                        required: true
                    },
                    discount3: {
                        required: true
                    },
                },
                messages:
                    {
                        "booking-number-1": {
                            required: error_message
                        },
                        discount1: {
                            required: error_message
                        },
                        "booking-number-2": {
                            required: error_message
                        },
                        discount2: {
                            required: error_message
                        },
                        "booking-number-3": {
                            required: error_message
                        },
                        discount3: {
                            required: error_message
                        },
                    },
            }
        );

    </script>

@endsection

