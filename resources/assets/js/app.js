
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


var notifications = [];

const NOTIFICATION_TYPES = {
    new_booking: 'App\\Notifications\\NewBooking',
    new_hotel_booking: 'App\\Notifications\\NewHotelOwnerBooking',
    approve_booking: 'App\\Notifications\\ApproveBooking',
    disapprove_booking: 'App\\Notifications\\CancelBooking',
    reminder_booking: 'App\\Notifications\\ReminderBooking',
};

$(document).ready(function() {
    // check if there's a logged in user
    if(Laravel.userId) {
        $.get(base_url + '/notifications', function (data) {
            addNotifications(data, "#notification_li");
        });
    }
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    // show only last 5 notifications
    // notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    var count = notifications.length;

    var htmlElements = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="'+base_url+'/images/bell.png"'+'><img class="res-bell" src="'+base_url+'/images/bell-res.png"'+'>' +
        '<span class="badge">'+count+'</span>' +
        '</a>' +
        '<ul class="dropdown-menu scroll-bar">';

    if(notifications.length) {
        htmlElements += notifications.map(function (notification) {
            return makeNotification(notification);
        }).join('');
        // $(target).html(htmlElements.join(''));
    } else {
        htmlElements += '<li class="active"><a href="#">No Notifications</a></li>';
        // $(target).removeClass('has-notifications');

    }
    htmlElements += '<li class="active"><a href="'+base_url+'/notifications/all" style="text-align: center;">View all Notification</a></li>';
    htmlElements += '</ul>';
    $(target).html(htmlElements);

}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = '?read=' + notification.id;

    if(Laravel.userType == 'individual')
    {
        var userType = 'user';
    } else {
        var userType = 'company';
    }


    // if(notification.type === NOTIFICATION_TYPES.new_booking) {
    //     var id = notification.data.booking.id;
    //     to = base_url+'/'+userType+'/dashboard/bookings-detail/' + id + to;
    // }

    if(notification.type === NOTIFICATION_TYPES.new_hotel_booking) {
        var id = notification.data.booking.id;
        to = base_url+'/'+userType+'/dashboard/bookings-detail/' + id + to;
    }

    if(notification.type === NOTIFICATION_TYPES.approve_booking) {
        var id = notification.data.booking.id;
        to = base_url+'/'+userType+'/dashboard/bookings-detail/' + id + to;
    }

    if(notification.type === NOTIFICATION_TYPES.disapprove_booking) {
        var id = notification.data.booking.id;
        to = base_url+'/'+userType+'/dashboard/bookings-detail/' + id + to;
    }

    if(notification.type === NOTIFICATION_TYPES.reminder_booking) {
        var id = notification.data.booking.id;
        to = base_url+'/'+userType+'/dashboard/bookings-detail/' + id + to;
    }

    return to;
}

// Make a single notification string
function makeNotification(notification) {
    var text = '';
    // if(notification.type === NOTIFICATION_TYPES.new_booking) {
    //     // const name = notification.data.booking;
    //     const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    //
    //     var start_data = new Date(notification.data.booking.start_date);
    //     var end_date = new Date(notification.data.booking.end_date);
    //     var start_month = monthNames[start_data.getMonth()];
    //     var end_month =  monthNames[end_date.getMonth()];
    //     var start_day = start_data.getDate();
    //     var end_day = end_date.getDate();
    //
    //     var to = routeNotification(notification);
    //     text += '<li class="">' +
    //         '<a href="'+to+'">' +
    //         '<div class="noti-img">' +
    //         '<img src="'+base_url+'/storage/images/spaces/'+notification.data.booking.space.image+'">'+
    //         '</div>'+
    //         '<div class="noti-info">' +
    //         '<div class="noti-info-left">' +
    //         '<h3>You have booked </h3>' +
    //         '<h4>'+notification.data.booking.space.title+'<span>'+notification.data.booking.space.venue.city+'</span></h4>'+
    //         '</div>' +
    //         '<div class="noti-info-right">' +
    //         '<span<i class="star"></i></span>' +
    //         '<h4></h4>' +
    //         '<div class="date">'+ start_day + ' ' + start_month +' to '+ end_day+' ' + end_month +'</div>' +
    //         '</div>' +
    //         '</div>' +
    //         '</a>' +
    //         '</li>';
    //
    // }
    if(notification.type === NOTIFICATION_TYPES.new_hotel_booking) {
        // const name = notification.data.booking;
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        var start_data = new Date(notification.data.booking.start_date);
        var end_date = new Date(notification.data.booking.end_date);
        var start_month = monthNames[start_data.getMonth()];
        var end_month =  monthNames[end_date.getMonth()];
        var start_day = start_data.getDate();
        var end_day = end_date.getDate();

        var to = routeNotification(notification);
        text += '<li class="">' +
            '<a href="'+to+'">' +
            '<div class="noti-img">' +
            '<img src="'+base_url+'/storage/images/spaces/'+notification.data.booking.space.image+'">'+
            '</div>'+
            '<div class="noti-info">' +
            '<div class="noti-info-left">' +
            '<h3>You got a new Booking</h3>' +
            '<h4>'+notification.data.booking.space.title+'<span>'+notification.data.booking.space.venue.city+'</span></h4>'+
            '</div>' +
            '<div class="noti-info-right">' +
            '<span<i class="star"></i></span>' +
            '<h4></h4>' +
            '<div class="date">'+ start_day + ' ' + start_month +' to '+ end_day+' ' + end_month +'</div>' +
            '</div>' +
            '</div>' +
            '</a>' +
            '</li>';

    }
    if(notification.type === NOTIFICATION_TYPES.approve_booking) {
        // const name = notification.data.booking;
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        var start_data = new Date(notification.data.booking.start_date);
        var end_date = new Date(notification.data.booking.end_date);
        var start_month = monthNames[start_data.getMonth()];
        var end_month =  monthNames[end_date.getMonth()];
        var start_day = start_data.getDate();
        var end_day = end_date.getDate();

        var to = routeNotification(notification);
        text += '<li class="">' +
            '<a href="'+to+'">' +
            '<div class="noti-img">' +
            '<img src="'+base_url+'/storage/images/spaces/'+notification.data.booking.space.image+'">'+
            '</div>'+
            '<div class="noti-info">' +
            '<div class="noti-info-left">' +
            '<h3>Your Booking is Approve</h3>' +
            '<h4>'+notification.data.booking.space.title+'<span>'+notification.data.booking.space.venue.city+'</span></h4>'+
            '</div>' +
            '<div class="noti-info-right">' +
            '<span<i class="star"></i></span>' +
            '<h4></h4>' +
            '<div class="date">'+ start_day + ' ' + start_month +' to '+ end_day+' ' + end_month +'</div>' +
            '</div>' +
            '</div>' +
            '</a>' +
            '</li>';

    }
    if(notification.type === NOTIFICATION_TYPES.disapprove_booking) {
        // const name = notification.data.booking;
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        var start_data = new Date(notification.data.booking.start_date);
        var end_date = new Date(notification.data.booking.end_date);
        var start_month = monthNames[start_data.getMonth()];
        var end_month =  monthNames[end_date.getMonth()];
        var start_day = start_data.getDate();
        var end_day = end_date.getDate();

        var to = routeNotification(notification);
        text += '<li class="">' +
            '<a href="'+to+'">' +
            '<div class="noti-img">' +
            '<img src="'+base_url+'/storage/images/spaces/'+notification.data.booking.space.image+'">'+
            '</div>'+
            '<div class="noti-info">' +
            '<div class="noti-info-left">' +
            '<h3>Your Booking is Cancelled</h3>' +
            '<h4>'+notification.data.booking.space.title+'<span>'+notification.data.booking.space.venue.city+'</span></h4>'+
            '</div>' +
            '<div class="noti-info-right">' +
            '<span<i class="star"></i></span>' +
            '<h4></h4>' +
            '<div class="date">'+ start_day + ' ' + start_month +' to '+ end_day+' ' + end_month +'</div>' +
            '</div>' +
            '</div>' +
            '</a>' +
            '</li>';

    }
    if(notification.type === NOTIFICATION_TYPES.reminder_booking) {
        // const name = notification.data.booking;
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        var start_data = new Date(notification.data.booking.start_date);
        var end_date = new Date(notification.data.booking.end_date);
        var start_month = monthNames[start_data.getMonth()];
        var end_month =  monthNames[end_date.getMonth()];
        var start_day = start_data.getDate();
        var end_day = end_date.getDate();

        var to = routeNotification(notification);
        text += '<li class="">' +
            '<a href="'+to+'">' +
            '<div class="noti-img">' +
            '<img src="'+base_url+'/storage/images/spaces/'+notification.data.booking.space.image+'">'+
            '</div>'+
            '<div class="noti-info">' +
            '<div class="noti-info-left">' +
            '<h3>This Reminder of Booking</h3>' +
            '<h4>'+notification.data.booking.space.title+'<span>'+notification.data.booking.space.venue.city+'</span></h4>'+
            '</div>' +
            '<div class="noti-info-right">' +
            '<span<i class="star"></i></span>' +
            '<h4></h4>' +
            '<div class="date">'+ start_day + ' ' + start_month +' to '+ end_day+' ' + end_month +'</div>' +
            '</div>' +
            '</div>' +
            '</a>' +
            '</li>';

    }
    return text;
}

$(document).ready(function() {
    window.Echo.private(`App.Models.Site.User.${Laravel.userId}`)
        .notification((notification) => {
            addNotifications([notification], '#notification_li');
        });

});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('notification', require('./components/Notification.vue'));

// const app = new Vue({
//     el: '#app',
// });
