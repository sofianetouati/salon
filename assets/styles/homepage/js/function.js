/* ----------------------------------------------------------------------------------------
 * Author        : Awaiken
 * Template Name : App Launch - App Landing Page HTML5 Template
 * File          : Custom JS
 * Version       : 1.0
 * ---------------------------------------------------------------------------------------- */
(function ($) {
  "use strict";

  var $window = $(window);

  /* Preloader Effect */
  $window.on("load", function () {
    $(".preloader").fadeOut(600);
  });

  /* Top Menu */
  $("#navigation ul li a").on("click", function () {
    var id = $(this).attr("href");
    var h = parseFloat($(id).offset().top);
    $("body,html")
      .stop()
      .animate(
        {
          scrollTop: h - 70,
        },
        800
      );

    $(".navbar-collapse").collapse("hide");

    return false;
  });

  // /* Sticky header */
  $window.on("scroll", function () {
    if ($window.scrollTop() > 200) {
      $(".navbar").addClass("sticky-header");
    } else {
      $(".navbar").removeClass("sticky-header");
    }
  });

  /* slick nav */
  $("#main-menu").slicknav({ prependTo: "#responsive-menu", label: "" });

  /*OwlCarousels Testimonial Start*/
  $window.on("load", function () {
    $("#pricing-slider").owlCarousel({
      autoplay: true,
      autoplaySpeed: 1000,
      navText: [
        '<i class="fa fa-chevron-left"></i>',
        '<i class="fa fa-chevron-right"></i>',
      ],
      loop: true,
      center: false,
      items: 3,
      margin: 40,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
        },

        768: {
          items: 2,
        },

        1024: {
          items: 3,
        },
      },
    });
  });
})(jQuery);
