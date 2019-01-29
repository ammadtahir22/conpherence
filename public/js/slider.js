$(document).ready(function() {
            $('.testimoial-carousel').owlCarousel({
                loop: true,
                margin: 0,
                dots:false,
                nav:true,
        navText: ["<img src='"+base_url+"/images/left.png'>","<img src='"+base_url+"/images/right.png'>"],
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 2,
                    nav: true
                  },
                  600: {
                    items: 4,
                    nav: false
                  },
                  1000: {
                    items: 6,
                    nav: true,
                    loop: false,
                    margin: 0
                  }
                }
              });
            });
  $(document).ready(function() {
    $('.feature-slide').owlCarousel({
                loop: true,
                margin: 0,
                nav:true,
                dots:false,
        navText: ["<img src='"+base_url+"/images/left.png'>","<img src='"+base_url+"/images/right.png'>"],
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 2,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 0
                  }
                }
              });
        });
  $(document).ready(function() {
    $('.client-slide').owlCarousel({
                loop: true,
                margin: 10,
                dots:true,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1,
                  },
                  600: {
                    items: 1,
                  },
                  1000: {
                    items: 1,
                    loop: false,
                    margin: 20
                  }
                }
              });
  });
  $(document).ready(function() {
    $('.relat-slide').owlCarousel({
                loop: true,
                margin: 0,
                dots:true,
                nav:false,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1,
                  },
                  600: {
                    items: 1,
                  },
                  1000: {
                    items: 1,
                    loop: false,
                    margin: 0
                  }
                }
              });
  });
$(document).ready(function() {
    $('.dash-s-review').owlCarousel({
                loop: true,
                margin: 0,
                nav:true,
                dots:false,
        navText: ["<img src='"+base_url+"/images/left.png'>","<img src='"+base_url+"/images/right.png'>"],
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1,
                  },
                  600: {
                    items: 1,
                  },
                  1000: {
                    items: 1,
                    loop: false,
                    margin: 0
                  }
                }
              });
  });