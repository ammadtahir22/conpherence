//menu

jQuery(".ani-btn a").click(function() {
    jQuery(this).toggleClass("active") ;
    jQuery('.filter-main').toggleClass("open");
});
jQuery(".btn-toggle").click(function() {
    jQuery(this).toggleClass("grid") ;
    jQuery('.gride').toggleClass("open");
});
// jQuery(window).scroll(function()
//  {
//         if (jQuery(this).scrollTop() > 0)
//   {
//             jQuery('.header').addClass("fixed-header");
//         } else{
//             jQuery('.header').removeClass("fixed-header");
//         }
// });
jQuery(document).ready(function(){

    var navOffset=jQuery(".header").offset().top;
    jQuery(".header").wrap('<div class="placeholder" ></div>');
    jQuery("div.placeholder").height(jQuery(".header").outerHeight());


    jQuery(window).scroll(function(){

        var scrollPos=jQuery(window).scrollTop();

        if(scrollPos >= navOffset){

            jQuery(".fixed-header").addClass("fixed-header");

        }else{
            jQuery(".fixed-header").removeClass("fixed-header");
        }

    });

});
(function($){
  var ico = $('<i class="fa fa-angle-down"></i>');
  $('#menu li:has(ul) > a').before(ico);
  
  $('#menu li:has(ul) > i').on('click',function(){
    $(this).parent('li').toggleClass('open');
  });
  
  
  
  $('a#toggle').on('click',function(e){
    $('html').toggleClass('open-menu');
  $('body').toggleClass('noscroll');
    return false;
  });
  
  
  $('div#overlay').on('click',function(){
    $('html').removeClass('open-menu');
  $('body').removeClass('noscroll');
  })
  
})(jQuery);

//menu end
jQuery(document).ready(function() {
  jQuery('.fade-up-ani').addClass("ani-hidden").viewportChecker({
      classToAdd: 'visible animated fadeInUp', // Class to add to the elements when they are visible
      offset: 100 ,  
     });   
});
jQuery(document).ready(function() {
  jQuery('.fade-down-ani').addClass("ani-hidden").viewportChecker({
      classToAdd: 'visible animated fadeInDown', // Class to add to the elements when they are visible
      offset: 100 ,  
     });   
});
 jQuery(document).ready(function() {
  jQuery('.fade-right-ani').addClass("ani-hidden").viewportChecker({
      classToAdd: 'visible animated fadeInRight', // Class to add to the elements when they are visible
      offset: 100 ,  
     });   
});
 jQuery(document).ready(function() {
  jQuery('.fade-left-ani').addClass("ani-hidden").viewportChecker({
      classToAdd: 'visible animated fadeInLeft', // Class to add to the elements when they are visible
      offset: 100 ,  
     });   
});

//auto stop slide of bootstrap
// $('.carousel').carousel({
//     interval: false;
// }); 

 //tabz
 $(function() {
  var $tabButtonItem = $('#tab-button li'),
      $tabSelect = $('#tab-select'),
      $tabContents = $('.tab-contents'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(':first').hide();

  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $tabContents.removeClass(activeClass);
    $(target).show();
    $(target).addClass(activeClass);
    e.preventDefault();
  });

  $tabSelect.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();

    $(target).show();
  });
});
 //Mehran spaces tabs
// $(function() {
//     var $tabButtonItem = $('#inner-tab-button li'),
//         $tabSelect = $('#inner-tab-select'),
//         $tabContents = $('.inner-tab-contents'),
//         activeClass = 'is-active';
//
//     $tabButtonItem.first().addClass(activeClass);
//     $tabContents.not(':first').hide();
//
//     $tabButtonItem.find('a').on('click', function(e) {
//         var target = $(this).attr('href');
//
//         $tabButtonItem.removeClass(activeClass);
//         $(this).parent().addClass(activeClass);
//         $tabSelect.val;
//         $tabContents.hide();
//         $(target).show();
//         e.preventDefault();
//     });
//
//     $tabSelect.on('change', function() {
//         var target = $(this).val(),
//             targetSelectNum = $(this).prop('selectedIndex');
//
//         $tabButtonItem.removeClass(activeClass);
//         $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
//         $tabContents.hide();
//         $(target).show();
//     });
// });

//Mehran spaces tabs

 (function() {
  window.inputNumber = function(el) {

    var min = el.attr('min') || false;
    var max = el.attr('max') || false;

    var els = {};

    els.dec = el.prev();
    els.inc = el.next();

    el.each(function() {
      init($(this));
    });

    function init(el) {

      els.dec.on('click', decrement);
      els.inc.on('click', increment);

      function decrement() {
        var value = el[0].value;
        value--;
        if(!min || value >= min) {
          el[0].value = value;
        }
      }

      function increment() {
        var value = el[0].value;
        value++;
        if(!max || value <= max) {
          el[0].value = value++;
        }
      }
    }
  }
})();
inputNumber($('.input-number'));
//cutom file job upload
$('#file-upload').change(function() {
    var filepath = this.value;
    var m = filepath.match(/([^\/\\]+)$/);
    var filename = m[1];
    $('#filename').html(filename);

});
//smooth scroll
$(".smooth-scroll").click(function() {
  var href = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(href).offset().top
        }, 800);
    });
//price range
//-----JS for Price Range slider-----
$(function() {
  $( "#slider-range" ).slider({
    range: true,
    min: 100,
    max: 1000,
    values: [ 100, 350 ],
    slide: function( event, ui ) {
    $( "#amount" ).val( "AED " + ui.values[ 0 ] + " - AED " + ui.values[ 1 ] );
    $( "#minimum_price" ).val(ui.values[ 0 ]);
    $( "#minimum_price_span" ).html(ui.values[ 0 ]);
    $( "#maximum_price" ).val(ui.values[ 1 ]);
    $( "#maximum_price_span" ).html(ui.values[ 1 ]);
        $("#filer_venue_form").submit();
    }
  });
  $( "#amount" ).val( "AED " + $( "#slider-range" ).slider( "values", 0 ) +
    " - AED " + $( "#slider-range" ).slider( "values", 1 ) );

    $( "#minimum_price" ).val($( "#slider-range" ).slider( "values", 0 ));
    $( "#maximum_price" ).val($( "#slider-range" ).slider( "values", 1 ));
    $( "#minimum_price_span" ).html($( "#slider-range" ).slider( "values", 0 ));
    $( "#maximum_price_span" ).html($( "#slider-range" ).slider( "values", 1 ));
});
//upload photo
function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
  });
  $('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
//open and close arrow
$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
});

 //telephone
// $(".telephone").intlTelInput({
//   nationalMode: false,
//   utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
// });
//add multiple gallary start
var abc = 0; // Declaring and defining global increement variable.
$(document).ready(function() {
// To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
$('#add_more').click(function() {
$(this).before($("<div/>", {
id: 'filediv'
}).fadeIn('slow').append($("<input/>", {
name: 'file[]',
type: 'file',
id: 'file'
}), $("<br/><br/>")));
});
// Following function will executes on change event of file input to select different file.
$('body').on('change', '#file', function() {
if (this.files && this.files[0]) {
abc += 1; // Incrementing global variable by 1.
var z = abc - 1;
var x = $(this).parent().find('#previewimg' + z).remove();
$(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
$(this).hide();
$("#abcd" + abc).append($("<img/>", {
id: 'img',
src: 'cross.png',
alt: 'delete'
}).click(function() {
$(this).parent().parent().remove();
}));
}
});
// To preview image
function imageIsLoaded(e) {
$('#previewimg' + abc).attr('src', e.target.result);
};
$('#upload').click(function(e) {
var name = $(":file").val();
if (!name) {
alert("First Image Must Be Selected");
e.preventDefault();
}
});
});
//add multiple gallary end

//datepicker
// $('#calendar').datepicker({
//   format: "yyyy-mm-dd",
//   todayHighlight: true,
//   language: "en"
// })

// $(document).ready(function(){
//   $(".scroll-bar").mCustomScrollbar({
//     theme     : "dark",
//     scrollButtons : { scrollType: "stepped" },
//     live      : "on"
//   });
// });
  //responsive toggle side bar
// var aside = document.querySelector('.dashboard-sidebar');
// var button = document.querySelector('.sidebar-toggle');
// button.onclick = function () {
//     aside.classList.toggle('flatside-bar');
// };
/*global console*/
//calender
//month
//prev
//next
//weeks
//days

//punblic variables
// var calender = document.querySelector(".calender"),//container of calender
//     topDiv = document.querySelector('.month'),
//     monthDiv = calender.querySelector("h1"),//h1 of monthes
//     yearDiv = calender.querySelector('h2'),//h2 for years
//     weekDiv = calender.querySelector(".weeks"),//week container
//     dayNames = weekDiv.querySelectorAll("li"),//dayes name
//     dayItems = calender.querySelector(".days"),//date of day container
//     prev = calender.querySelector(".prev"),
//     next = calender.querySelector(".next"),
//
//     // date variables
//     years = new Date().getFullYear(),
//     monthes = new Date(new Date().setFullYear(years)).getMonth(),
//     lastDayOfMonth = new Date(new Date(new Date().setMonth(monthes + 1)).setDate(0)).getDate(),
//     dayOfFirstDateOfMonth = new Date(new Date(new Date().setMonth(monthes)).setDate(1)).getDay(),
//
//     // array to define name of monthes
//     monthNames = ["January", "February", "March", "April", "May", "June",
//                   "July", "August", "September", "October", "November", "December"],
//     //colors = ['#FFA549', '#ABABAB', '#1DABB8', '#953163', '#E7DF86', '#E01931', '#92F22A', '#FEC606', '#563D28', '#9E58DC', '#48AD01', '#0EBB9F'],
//     i,//counter for day before month first day in week
//     x,//counter for prev , next
//     counter;//counter for day of month  days;
//
//
// //display dayes of month in items
// function days(x) {
//   'use strict';
//   dayItems.innerHTML = "";
//   monthes = monthes + x;
//
//   /////////////////////////////////////////////////
//   //test for last month useful while prev ,max prevent go over array
//   if (monthes > 11) {
//     years = years + 1;
//     monthes = new Date(new Date(new Date().setFullYear(years)).setMonth(0)).getMonth();//ترجع الشهر لاول شهر فى السنه الجديده
//   }
//   if (monthes < 0) {
//     years = years - 1;
//     monthes = new Date(new Date(new Date().setFullYear(years)).setMonth(11)).getMonth();//ترجع الشهر لاخر شهر فى السنه اللى فاتت
//   }
//   //next,prev
//   lastDayOfMonth = new Date(new Date(new Date(new Date().setFullYear(years)).setMonth(monthes + 1)).setDate(0)).getDate();//اخر يوم فى الشهر
//   dayOfFirstDateOfMonth = new Date(new Date(new Date(new Date().setFullYear(years)).setMonth(monthes)).setDate(1)).getDay();//بداية الشهر فى اى يوم من ايام الاسبوع؟
//   /////////////////////////////////////////////////
//   yearDiv.innerHTML = years;
//   monthDiv.innerHTML = monthNames[monthes];
//   for (i = 0; i <= dayOfFirstDateOfMonth; i = i + 1) {
//     if (dayOfFirstDateOfMonth === 6) { break; }
//     dayItems.innerHTML += "<li>  </li>";
//   }
//   for (counter = 1; counter <= lastDayOfMonth; counter = counter + 1) {
//     // dayItems.innerHTML += "<li>" + "<span>" + (counter) + "</span>" + "</li>";
//
//     if(counter == 15)
//     {
//       dayItems.innerHTML += "<li>" + "<div>" + (counter) + "</div>" + "</li>";
//     } else {
//       dayItems.innerHTML += "<li>" + "<span>" + (counter) + "</span>" + "</li>";
//     }
//
//   }
//   topDiv.style.background = colors[monthes];
//   dayItems.style.background = colors[monthes];
//
//   if (monthes === new Date().getMonth() && years === new Date().getFullYear()) {
//     dayItems.children[new Date().getDate() + dayOfFirstDateOfMonth].style.background = "#2ecc71";
//   }
// }
// prev.onclick = function () {
//   'use strict';
//   days(-1);//decrement monthes
// };
// next.onclick = function () {
//   'use strict';
//   days(1);//increment monthes
// };
// days(0);

//end


// When the window has finished loading create our google map below
//             google.maps.event.addDomListener(window, 'load', init);
//
//             function init() {
//                 // Basic options for a simple Google Map
//                 // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
//                 var mapOptions = {
//                     // How zoomed in you want the map to start at (always required)
//                     zoom: 15,
//
//                     // The latitude and longitude to center the map (always required)
//                     center: new google.maps.LatLng(25.099448, 55.161948), // New York
//
//                     // How you would like to style the map.
//                     // This is where you would paste any style found on Snazzy Maps.
//
//                 };
//
//                 // Get the HTML DOM element that will contain your map
//                 // We are using a div with id="map" seen below in the <body>
//                 var mapElement = document.getElementById('map');
//
//                 // Create the Google Map using our element and options defined above
//                 var map = new google.maps.Map(mapElement, mapOptions);
//
//                 // Let's also add a marker while we're at it
//
//                 var marker = new google.maps.Marker({
//                     position: new google.maps.LatLng(25.099448, 55.161948),
//                     map: map,
//                     title: 'Snazzy!',
//                     icon: 'images/locator.png'
//                 });
//
//             }
