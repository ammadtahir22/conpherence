<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						{{--<img src="{{url('images/admin-panel/avatars/sunny.png')}}" alt="me" class="online" />--}}
						{{--<span>--}}
						{{----}}
						{{--</span>--}}
						{{--<i class="fa fa-angle-down"></i>--}}
					</a>

				</span>
    </div>
    <!-- end user info -->

    <nav>
        <!--
        NOTE: Notice the gaps after each icon usage <i></i>..
        Please note that these links work a bit different than
        traditional href="" links. See documentation for details.
        -->

        <ul>
            <li>
                <a href="{{url('admin/')}}" title="Mails"><i class="fa fa-lg fa-fw fa fa-dashboard"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li>
                <a href="{{url('admin/mails')}}" title="Mails"><i class="fa fa-lg fa-fw fa fa-envelope"></i> <span class="menu-item-parent">Mails</span></a>
            </li>

            <li>
                <a href="#" title="Users"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">Users</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/users')}}" title="Dashboard"><span class="menu-item-parent">All users</span></a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="{{url('admin/add_user')}}" title="Dashboard"><span class="menu-item-parent">Add user</span></a>--}}
                    {{--</li>--}}
                </ul>
            </li>

            <li>
                <a href="#" title="Blog"><i class="fa fa-lg fa-fw fa fa-book"></i> <span class="menu-item-parent">Page</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/pages')}}" title="All Pages"><span class="menu-item-parent">All Pages</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/page/create')}}" title="Add New Page"><span class="menu-item-parent">Add New Page</span></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{url('admin/subscribers')}}" title="Blog"><i class="fa fa-lg fa-fw fa fa-heart"></i> <span class="menu-item-parent">Subscribers</span></a>
            </li>

            <li>
                <a href="#" title="Blog"><i class="fa fa-lg fa-fw fa fa-photo"></i> <span class="menu-item-parent">Blog</span></a>
                <ul>
                    <li>
                        <a href="#" title="Blog Posts"><span class="menu-item-parent">Post</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/post/create')}}" title="All Posts"><span class="menu-item-parent">Add Post</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/post/all')}}" title="All Posts"><span class="menu-item-parent">All Posts</span></a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" title="Categories"><span class="menu-item-parent">Categories</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/post/category/create')}}" title="Add Category"><span class="menu-item-parent">Add Category</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/post/category/all')}}" title="All Categories"><span class="menu-item-parent">All Categories</span></a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" title="Blog Posts Comments"><span class="menu-item-parent">Comments</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/comments/all')}}" title="All Comments"><span class="menu-item-parent">All Comments</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" title="News"><i class="fa fa-lg fa-fw fa-envelope"></i> <span class="menu-item-parent">News</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/news/create')}}" title="Add News"><span class="menu-item-parent">Add News</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/news/all')}}" title="All News"><span class="menu-item-parent">All News</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/news/category/create')}}" title="Add Category"><span class="menu-item-parent">Add Category</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/news/category/all')}}" title="All Categories"><span class="menu-item-parent">All Categories</span></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" title="Career"><i class="fa fa-lg fa-fw fa-graduation-cap"></i> <span class="menu-item-parent">Career</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/career/create')}}" title="Add Job"><span class="menu-item-parent">Add a Career</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/career/all')}}" title="All Jobs"><span class="menu-item-parent">All Career</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/career/category/create')}}" title="Add Category"><span class="menu-item-parent">Add Category</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/career/category/all')}}" title="All Categories"><span class="menu-item-parent">All Categories</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" title="Career"><i class="fa fa-lg fa-fw fa-suitcase"></i> <span class="menu-item-parent">Bookings</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/booking/all')}}" title="All Bookings"><span class="menu-item-parent">All Bookings</span></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="#" title="Venue"><i class="fa fa-lg fa-fw fa-building"></i> <span class="menu-item-parent">Venue</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/venue/create')}}" title="Add Venue"><span class="menu-item-parent">Add a Venue</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/venue/all')}}" title="All Venues"><span class="menu-item-parent">All Venues</span></a>
                    </li>
                    <li>
                        <a href="#" title="Blog Posts"><span class="menu-item-parent">Food Types</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/food/type/create')}}" title="Add Food"><span class="menu-item-parent">Add Food Types</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/food/type/all')}}" title="All Food"><span class="menu-item-parent">All Food Types</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" title="Spaces"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Spaces</span></a>
                <ul>
                    <li>
                        <a href="#" title="Spaces"> <span class="menu-item-parent">Spaces</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/spaces/create')}}" title="Add Category"><span class="menu-item-parent">Add Space</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/spaces/all')}}" title="All Categories"><span class="menu-item-parent">All Spaces</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="Spaces"> <span class="menu-item-parent">Space Type</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/space/spacetype/create')}}" title="Add Category"><span class="menu-item-parent">Add Space Type</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/space/spacetype/all')}}" title="All Categories"><span class="menu-item-parent">All Space Types</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="Spaces"> <span class="menu-item-parent">Sitting Plans</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/sitting-plan/create')}}" title="Add Category"><span class="menu-item-parent">Add Sitting Plan</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/sitting-plan/all')}}" title="All Categories"><span class="menu-item-parent">All Sitting Plans</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="Spaces"> <span class="menu-item-parent">Amenities</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/amenities/create')}}" title="Add Category"><span class="menu-item-parent">Add Amenities</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/amenities/all')}}" title="All Categories"><span class="menu-item-parent">All Amenities</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="Accessibility"> <span class="menu-item-parent">Accessibility</span></a>
                        <ul>
                            <li>
                                <a href="{{url('admin/accessibilities/create')}}" title="Add Accessibility"><span class="menu-item-parent">Add Accessibility</span></a>
                            </li>
                            <li>
                                <a href="{{url('admin/accessibilities/all')}}" title="All Accessibility"><span class="menu-item-parent">All Accessibilities</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" title="Reviews"><i class="fa fa-lg fa-fw fa-star"></i> <span class="menu-item-parent">Reviews</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/reviews')}}" title="Dashboard"><span class="menu-item-parent">All Reviews</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" title="Earn Points"><i class="fa fa-lg fa-fw fa-dollar"></i> <span class="menu-item-parent">Membership</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/earn-points')}}" title="Earn Points"><span class="menu-item-parent">Users Earn Points</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" title="Reports"><i class="fa fa-lg fa-fw fa-database"></i> <span class="menu-item-parent">Reports</span></a>
                <ul>
                    <li>
                        <a href="{{url('admin/hotel/report')}}" title="Hotel Report"><span class="menu-item-parent">Hotel</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/user/saving/report/get')}}" title="User Saving Report"><span class="menu-item-parent">Saving Reports</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/user/sale/report')}}" title="Earning Report"><span class="menu-item-parent">User Report</span></a>
                    </li>
                    <li>
                        <a href="{{url('admin/hotel/sale/report')}}" title="Earning Report"><span class="menu-item-parent">Hotel Sale Report</span></a>
                    </li>
                </ul>
            </li>
            {{--<li>--}}
                {{--<a href="#" title="Grades"><i class="fa fa-lg fa-fw fa-star"></i> <span class="menu-item-parent">Grades</span></a>--}}
                {{--<ul>--}}
                    {{--<li>--}}
                        {{--<a href="{{url('admin/grades')}}" title="Grades"><span class="menu-item-parent">All Grades</span></a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}

        </ul>
    </nav>


    <span class="minifyme" data-action="minifyMenu">
				<i class="fa fa-arrow-circle-left hit"></i>
			</span>

</aside>
<!-- END NAVIGATION -->