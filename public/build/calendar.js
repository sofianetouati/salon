"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["calendar"],{

/***/ "./assets/calendar.js":
/*!****************************!*\
  !*** ./assets/calendar.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.find.js */ "./node_modules/core-js/modules/es.array.find.js");
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/web.timers.js */ "./node_modules/core-js/modules/web.timers.js");
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _fullcalendar_core__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fullcalendar/core */ "./node_modules/@fullcalendar/core/main.js");
/* harmony import */ var _fullcalendar_interaction__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @fullcalendar/interaction */ "./node_modules/@fullcalendar/interaction/main.js");
/* harmony import */ var _fullcalendar_list__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @fullcalendar/list */ "./node_modules/@fullcalendar/list/main.js");
/* harmony import */ var _fullcalendar_timegrid__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @fullcalendar/timegrid */ "./node_modules/@fullcalendar/timegrid/main.js");
/* harmony import */ var _fullcalendar_daygrid__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @fullcalendar/daygrid */ "./node_modules/@fullcalendar/daygrid/main.js");
/* harmony import */ var _fullcalendar_core_locales_all__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @fullcalendar/core/locales-all */ "./node_modules/@fullcalendar/core/locales-all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_12__);
/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");













document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar-holder");
  var eventsUrl = calendarEl.dataset.eventsUrl;
  var calendar = new _fullcalendar_core__WEBPACK_IMPORTED_MODULE_5__.Calendar(calendarEl, {
    headerToolbar: {
      start: "title",
      center: "prev,next",
      end: "today dayGridMonth,timeGridWeek,timeGridDay listWeek"
    },
    plugins: [_fullcalendar_interaction__WEBPACK_IMPORTED_MODULE_6__["default"], _fullcalendar_daygrid__WEBPACK_IMPORTED_MODULE_9__["default"], _fullcalendar_timegrid__WEBPACK_IMPORTED_MODULE_8__["default"], _fullcalendar_list__WEBPACK_IMPORTED_MODULE_7__["default"]],
    // https://fullcalendar.io/docs/plugin-index
    timeZone: "Europe/Paris",
    locale: "fr",
    buttonText: {
      today: "Aujourd'hui",
      month: "Mois",
      week: "Semaine",
      day: "Jour",
      list: "Liste"
    },
    businessHours: {
      daysOfWeek: [1, 2, 3, 4, 5, 6],
      startTime: "09:00",
      endTime: "19:30"
    },
    slotDuration: "00:30",
    slotLabelInterval: "01:00",
    views: {
      dayGridMonth: {
        dayMaxEventRows: 3
      }
    },
    moreLinkClassNames: "badge rounded-pill bg-primary text-light",
    moreLinkContent: function moreLinkContent(arg) {
      return "+" + arg.num + " autres";
    },
    allDayText: "Congés",
    noEventsContent: "Aucun rendez-vous à afficher",
    slotLabelFormat: {
      hour: "numeric",
      minute: "numeric",
      omitZeroMinute: false
    },
    slotMinTime: "08:30",
    slotMaxTime: "20:00",
    showNonCurrentDates: true,
    navLinks: true,
    firstDay: 1,
    initialView: "timeGridWeek",
    editable: false,
    nowIndicator: true,
    allDayMaintainDuration: true,
    dateClick: function dateClick(data) {
      var date = data.date.toUTCString();
      var inputNb = $("#salon input").length; // Sur clique du créneau, afficher et vider le formulaire

      $("#modal").modal("show");
      $("#phone_booking_coiffeur").find("option").each(function () {
        $(this).remove();
      });
      $("#phone_booking_coiffeur").append(new Option("-- Coiffeur --", "coiffeur"));
      $("#phone_booking_beginAt, #phone_booking_bookerFullname, #phone_booking_description, #phone_booking_productName").val("");
      $(".rdv").html(""); // Appel Ajax après le choix du salon

      $("#salon").on("click", "input", function () {
        if (inputNb === 1) {
          $("#salon").hide();
        }

        $(".js-salon").removeClass("btn-info").addClass("btn-outline-info");
        $(this).removeClass("btn-outline-info").addClass("btn-info");
        $.post({
          url: "ajax-phone-booking-admin",
          dataType: "json",
          async: false,
          data: {
            date: date,
            salonId: this.dataset.salon
          },
          beforeSend: function beforeSend() {
            Dashmix.layout("header_loader_on");
          },
          success: function success(result, request) {
            var coiffeur = result.dispo;
            var date = result.date;
            var dateFr = result.dateFr;
            $(".rdv").html(dateFr);
            $("#phone_booking_coiffeur").find("option").each(function () {
              $(this).remove();
            });
            $("#phone_booking_coiffeur").append(new Option("-- Coiffeur --", "coiffeur"));
            $("#phone_booking_beginAt").val("").val(date);
            coiffeur.forEach(function (e) {
              $("#phone_booking_coiffeur").append(new Option(e.coiffeurName, e.coiffeurId));
            }); // Nettoyage du formulaire après fermeture du modal

            $("#modal").on("hide.bs.modal", function (e) {
              $(".js-salon").removeClass("btn-info").addClass("btn-outline-info");
              $("#phone_booking_coiffeur").find("option").each(function () {
                $(this).remove();
              });
              $("#phone_booking_coiffeur").append(new Option("-- Coiffeur --", ""));
              $("#phone_booking_bookerFullname, #phone_booking_description, #phone_booking_beginAt").val("");
            });
          },
          complete: function complete() {
            Dashmix.layout("header_loader_off");
          }
        });
      });

      if (inputNb === 1) {
        $("#salon").find("input").trigger("click");
      } // Soumission du formulaire


      $("#btn_submit").on("click", function () {
        $(this).closest("form").submit();
      });
    },
    eventSources: [{
      url: eventsUrl,
      method: "POST",
      extraParams: {
        filters: JSON.stringify({})
      },
      failure: function failure() {// alert("There was an error while fetching FullCalendar!");
      }
    }]
  });
  calendar.render();
  setInterval(function () {
    calendar.refetchEvents();
  }, 5000);
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_export_js-node_modules_jquery_dist_jquery_js","vendors-node_modules_core-js_internals_array-method-is-strict_js-node_modules_core-js_interna-7c4060","vendors-node_modules_sweetalert2_dist_sweetalert2_all_js","vendors-node_modules_fullcalendar_core_locales-all_js-node_modules_fullcalendar_core_main_js--42e7dc"], () => (__webpack_exec__("./assets/calendar.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiY2FsZW5kYXIuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBUSxRQUFRLENBQUNDLGdCQUFULENBQTBCLGtCQUExQixFQUE4QyxZQUFNO0FBQ2xELE1BQUlDLFVBQVUsR0FBR0YsUUFBUSxDQUFDRyxjQUFULENBQXdCLGlCQUF4QixDQUFqQjtBQUVBLE1BQUlDLFNBQVMsR0FBR0YsVUFBVSxDQUFDRyxPQUFYLENBQW1CRCxTQUFuQztBQUVBLE1BQUlFLFFBQVEsR0FBRyxJQUFJZCx3REFBSixDQUFhVSxVQUFiLEVBQXlCO0FBQ3RDSyxJQUFBQSxhQUFhLEVBQUU7QUFDYkMsTUFBQUEsS0FBSyxFQUFFLE9BRE07QUFFYkMsTUFBQUEsTUFBTSxFQUFFLFdBRks7QUFHYkMsTUFBQUEsR0FBRyxFQUFFO0FBSFEsS0FEdUI7QUFPdENDLElBQUFBLE9BQU8sRUFBRSxDQUFDbEIsaUVBQUQsRUFBb0JJLDZEQUFwQixFQUFtQ0QsOERBQW5DLEVBQW1ERCwwREFBbkQsQ0FQNkI7QUFPbUM7QUFDekVpQixJQUFBQSxRQUFRLEVBQUUsY0FSNEI7QUFTdENDLElBQUFBLE1BQU0sRUFBRSxJQVQ4QjtBQVV0Q0MsSUFBQUEsVUFBVSxFQUFFO0FBQ1ZDLE1BQUFBLEtBQUssRUFBRSxhQURHO0FBRVZDLE1BQUFBLEtBQUssRUFBRSxNQUZHO0FBR1ZDLE1BQUFBLElBQUksRUFBRSxTQUhJO0FBSVZDLE1BQUFBLEdBQUcsRUFBRSxNQUpLO0FBS1ZDLE1BQUFBLElBQUksRUFBRTtBQUxJLEtBVjBCO0FBa0J0Q0MsSUFBQUEsYUFBYSxFQUFFO0FBQ2JDLE1BQUFBLFVBQVUsRUFBRSxDQUFDLENBQUQsRUFBSSxDQUFKLEVBQU8sQ0FBUCxFQUFVLENBQVYsRUFBYSxDQUFiLEVBQWdCLENBQWhCLENBREM7QUFFYkMsTUFBQUEsU0FBUyxFQUFFLE9BRkU7QUFHYkMsTUFBQUEsT0FBTyxFQUFFO0FBSEksS0FsQnVCO0FBdUJ0Q0MsSUFBQUEsWUFBWSxFQUFFLE9BdkJ3QjtBQXdCdENDLElBQUFBLGlCQUFpQixFQUFFLE9BeEJtQjtBQXlCdENDLElBQUFBLEtBQUssRUFBRTtBQUNMQyxNQUFBQSxZQUFZLEVBQUU7QUFDWkMsUUFBQUEsZUFBZSxFQUFFO0FBREw7QUFEVCxLQXpCK0I7QUE4QnRDQyxJQUFBQSxrQkFBa0IsRUFBRSwwQ0E5QmtCO0FBK0J0Q0MsSUFBQUEsZUFBZSxFQUFFLHlCQUFVQyxHQUFWLEVBQWU7QUFDOUIsYUFBTyxNQUFNQSxHQUFHLENBQUNDLEdBQVYsR0FBZ0IsU0FBdkI7QUFDRCxLQWpDcUM7QUFrQ3RDQyxJQUFBQSxVQUFVLEVBQUUsUUFsQzBCO0FBbUN0Q0MsSUFBQUEsZUFBZSxFQUFFLDhCQW5DcUI7QUFvQ3RDQyxJQUFBQSxlQUFlLEVBQUU7QUFDZkMsTUFBQUEsSUFBSSxFQUFFLFNBRFM7QUFFZkMsTUFBQUEsTUFBTSxFQUFFLFNBRk87QUFHZkMsTUFBQUEsY0FBYyxFQUFFO0FBSEQsS0FwQ3FCO0FBeUN0Q0MsSUFBQUEsV0FBVyxFQUFFLE9BekN5QjtBQTBDdENDLElBQUFBLFdBQVcsRUFBRSxPQTFDeUI7QUEyQ3RDQyxJQUFBQSxtQkFBbUIsRUFBRSxJQTNDaUI7QUE0Q3RDQyxJQUFBQSxRQUFRLEVBQUUsSUE1QzRCO0FBNkN0Q0MsSUFBQUEsUUFBUSxFQUFFLENBN0M0QjtBQThDdENDLElBQUFBLFdBQVcsRUFBRSxjQTlDeUI7QUErQ3RDQyxJQUFBQSxRQUFRLEVBQUUsS0EvQzRCO0FBZ0R0Q0MsSUFBQUEsWUFBWSxFQUFFLElBaER3QjtBQWlEdENDLElBQUFBLHNCQUFzQixFQUFFLElBakRjO0FBa0R0Q0MsSUFBQUEsU0FBUyxFQUFFLG1CQUFVQyxJQUFWLEVBQWdCO0FBQ3pCLFVBQUlDLElBQUksR0FBR0QsSUFBSSxDQUFDQyxJQUFMLENBQVVDLFdBQVYsRUFBWDtBQUNBLFVBQUlDLE9BQU8sR0FBR0MsQ0FBQyxDQUFDLGNBQUQsQ0FBRCxDQUFrQkMsTUFBaEMsQ0FGeUIsQ0FJekI7O0FBQ0FELE1BQUFBLENBQUMsQ0FBQyxRQUFELENBQUQsQ0FBWUUsS0FBWixDQUFrQixNQUFsQjtBQUVBRixNQUFBQSxDQUFDLENBQUMseUJBQUQsQ0FBRCxDQUNHRyxJQURILENBQ1EsUUFEUixFQUVHekQsSUFGSCxDQUVRLFlBQVk7QUFDaEJzRCxRQUFBQSxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLE1BQVI7QUFDRCxPQUpIO0FBS0FKLE1BQUFBLENBQUMsQ0FBQyx5QkFBRCxDQUFELENBQTZCSyxNQUE3QixDQUNFLElBQUlDLE1BQUosQ0FBVyxnQkFBWCxFQUE2QixVQUE3QixDQURGO0FBR0FOLE1BQUFBLENBQUMsQ0FDQywrR0FERCxDQUFELENBRUVPLEdBRkYsQ0FFTSxFQUZOO0FBR0FQLE1BQUFBLENBQUMsQ0FBQyxNQUFELENBQUQsQ0FBVVEsSUFBVixDQUFlLEVBQWYsRUFsQnlCLENBb0J6Qjs7QUFFQVIsTUFBQUEsQ0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZUyxFQUFaLENBQWUsT0FBZixFQUF3QixPQUF4QixFQUFpQyxZQUFZO0FBQzNDLFlBQUlWLE9BQU8sS0FBSyxDQUFoQixFQUFtQjtBQUNqQkMsVUFBQUEsQ0FBQyxDQUFDLFFBQUQsQ0FBRCxDQUFZVSxJQUFaO0FBQ0Q7O0FBQ0RWLFFBQUFBLENBQUMsQ0FBQyxXQUFELENBQUQsQ0FBZVcsV0FBZixDQUEyQixVQUEzQixFQUF1Q0MsUUFBdkMsQ0FBZ0Qsa0JBQWhEO0FBQ0FaLFFBQUFBLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUVcsV0FBUixDQUFvQixrQkFBcEIsRUFBd0NDLFFBQXhDLENBQWlELFVBQWpEO0FBQ0FaLFFBQUFBLENBQUMsQ0FBQ2EsSUFBRixDQUFPO0FBQ0xDLFVBQUFBLEdBQUcsRUFBRSwwQkFEQTtBQUVMQyxVQUFBQSxRQUFRLEVBQUUsTUFGTDtBQUdMQyxVQUFBQSxLQUFLLEVBQUUsS0FIRjtBQUlMcEIsVUFBQUEsSUFBSSxFQUFFO0FBQ0pDLFlBQUFBLElBQUksRUFBRUEsSUFERjtBQUVKb0IsWUFBQUEsT0FBTyxFQUFFLEtBQUtqRSxPQUFMLENBQWFrRTtBQUZsQixXQUpEO0FBUUxDLFVBQUFBLFVBQVUsRUFBRSxzQkFBWTtBQUN0QkMsWUFBQUEsT0FBTyxDQUFDQyxNQUFSLENBQWUsa0JBQWY7QUFDRCxXQVZJO0FBV0xDLFVBQUFBLE9BQU8sRUFBRSxpQkFBVUMsTUFBVixFQUFrQkMsT0FBbEIsRUFBMkI7QUFDbEMsZ0JBQUlDLFFBQVEsR0FBR0YsTUFBTSxDQUFDRyxLQUF0QjtBQUNBLGdCQUFJN0IsSUFBSSxHQUFHMEIsTUFBTSxDQUFDMUIsSUFBbEI7QUFDQSxnQkFBSThCLE1BQU0sR0FBR0osTUFBTSxDQUFDSSxNQUFwQjtBQUVBM0IsWUFBQUEsQ0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVUSxJQUFWLENBQWVtQixNQUFmO0FBQ0EzQixZQUFBQSxDQUFDLENBQUMseUJBQUQsQ0FBRCxDQUNHRyxJQURILENBQ1EsUUFEUixFQUVHekQsSUFGSCxDQUVRLFlBQVk7QUFDaEJzRCxjQUFBQSxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLE1BQVI7QUFDRCxhQUpIO0FBS0FKLFlBQUFBLENBQUMsQ0FBQyx5QkFBRCxDQUFELENBQTZCSyxNQUE3QixDQUNFLElBQUlDLE1BQUosQ0FBVyxnQkFBWCxFQUE2QixVQUE3QixDQURGO0FBR0FOLFlBQUFBLENBQUMsQ0FBQyx3QkFBRCxDQUFELENBQTRCTyxHQUE1QixDQUFnQyxFQUFoQyxFQUFvQ0EsR0FBcEMsQ0FBd0NWLElBQXhDO0FBQ0E0QixZQUFBQSxRQUFRLENBQUNHLE9BQVQsQ0FBaUIsVUFBQ0MsQ0FBRCxFQUFPO0FBQ3RCN0IsY0FBQUEsQ0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJLLE1BQTdCLENBQ0UsSUFBSUMsTUFBSixDQUFXdUIsQ0FBQyxDQUFDQyxZQUFiLEVBQTJCRCxDQUFDLENBQUNFLFVBQTdCLENBREY7QUFHRCxhQUpELEVBZmtDLENBb0JsQzs7QUFDQS9CLFlBQUFBLENBQUMsQ0FBQyxRQUFELENBQUQsQ0FBWVMsRUFBWixDQUFlLGVBQWYsRUFBZ0MsVUFBVW9CLENBQVYsRUFBYTtBQUMzQzdCLGNBQUFBLENBQUMsQ0FBQyxXQUFELENBQUQsQ0FDR1csV0FESCxDQUNlLFVBRGYsRUFFR0MsUUFGSCxDQUVZLGtCQUZaO0FBR0FaLGNBQUFBLENBQUMsQ0FBQyx5QkFBRCxDQUFELENBQ0dHLElBREgsQ0FDUSxRQURSLEVBRUd6RCxJQUZILENBRVEsWUFBWTtBQUNoQnNELGdCQUFBQSxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLE1BQVI7QUFDRCxlQUpIO0FBS0FKLGNBQUFBLENBQUMsQ0FBQyx5QkFBRCxDQUFELENBQTZCSyxNQUE3QixDQUNFLElBQUlDLE1BQUosQ0FBVyxnQkFBWCxFQUE2QixFQUE3QixDQURGO0FBR0FOLGNBQUFBLENBQUMsQ0FDQyxtRkFERCxDQUFELENBRUVPLEdBRkYsQ0FFTSxFQUZOO0FBR0QsYUFmRDtBQWdCRCxXQWhESTtBQWlETHlCLFVBQUFBLFFBQVEsRUFBRSxvQkFBWTtBQUNwQlosWUFBQUEsT0FBTyxDQUFDQyxNQUFSLENBQWUsbUJBQWY7QUFDRDtBQW5ESSxTQUFQO0FBcURELE9BM0REOztBQTREQSxVQUFJdEIsT0FBTyxLQUFLLENBQWhCLEVBQW1CO0FBQ2pCQyxRQUFBQSxDQUFDLENBQUMsUUFBRCxDQUFELENBQVlHLElBQVosQ0FBaUIsT0FBakIsRUFBMEI4QixPQUExQixDQUFrQyxPQUFsQztBQUNELE9BcEZ3QixDQXFGekI7OztBQUNBakMsTUFBQUEsQ0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQlMsRUFBakIsQ0FBb0IsT0FBcEIsRUFBNkIsWUFBWTtBQUN2Q1QsUUFBQUEsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRa0MsT0FBUixDQUFnQixNQUFoQixFQUF3QkMsTUFBeEI7QUFDRCxPQUZEO0FBR0QsS0EzSXFDO0FBNEl0Q0MsSUFBQUEsWUFBWSxFQUFFLENBQ1o7QUFDRXRCLE1BQUFBLEdBQUcsRUFBRS9ELFNBRFA7QUFFRXNGLE1BQUFBLE1BQU0sRUFBRSxNQUZWO0FBR0VDLE1BQUFBLFdBQVcsRUFBRTtBQUNYQyxRQUFBQSxPQUFPLEVBQUVDLElBQUksQ0FBQ0MsU0FBTCxDQUFlLEVBQWY7QUFERSxPQUhmO0FBTUVDLE1BQUFBLE9BQU8sRUFBRSxtQkFBTSxDQUNiO0FBQ0Q7QUFSSCxLQURZO0FBNUl3QixHQUF6QixDQUFmO0FBeUpBekYsRUFBQUEsUUFBUSxDQUFDMEYsTUFBVDtBQUNBQyxFQUFBQSxXQUFXLENBQUMsWUFBWTtBQUN0QjNGLElBQUFBLFFBQVEsQ0FBQzRGLGFBQVQ7QUFDRCxHQUZVLEVBRVIsSUFGUSxDQUFYO0FBR0QsQ0FsS0QiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY2FsZW5kYXIuanMiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IHsgQ2FsZW5kYXIgfSBmcm9tIFwiQGZ1bGxjYWxlbmRhci9jb3JlXCI7XG5pbXBvcnQgaW50ZXJhY3Rpb25QbHVnaW4sIHsgRHJhZ2dhYmxlIH0gZnJvbSBcIkBmdWxsY2FsZW5kYXIvaW50ZXJhY3Rpb25cIjtcbmltcG9ydCBsaXN0UGx1Z2luIGZyb20gXCJAZnVsbGNhbGVuZGFyL2xpc3RcIjtcbmltcG9ydCB0aW1lR3JpZFBsdWdpbiBmcm9tIFwiQGZ1bGxjYWxlbmRhci90aW1lZ3JpZFwiO1xuaW1wb3J0IGRheUdyaWRQbHVnaW4gZnJvbSBcIkBmdWxsY2FsZW5kYXIvZGF5Z3JpZFwiO1xuaW1wb3J0IFwiQGZ1bGxjYWxlbmRhci9jb3JlL2xvY2FsZXMtYWxsXCI7XG5pbXBvcnQgU3dhbCBmcm9tIFwic3dlZXRhbGVydDJcIjtcbmltcG9ydCB7IGVhY2ggfSBmcm9tIFwianF1ZXJ5XCI7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJET01Db250ZW50TG9hZGVkXCIsICgpID0+IHtcbiAgdmFyIGNhbGVuZGFyRWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImNhbGVuZGFyLWhvbGRlclwiKTtcblxuICB2YXIgZXZlbnRzVXJsID0gY2FsZW5kYXJFbC5kYXRhc2V0LmV2ZW50c1VybDtcblxuICB2YXIgY2FsZW5kYXIgPSBuZXcgQ2FsZW5kYXIoY2FsZW5kYXJFbCwge1xuICAgIGhlYWRlclRvb2xiYXI6IHtcbiAgICAgIHN0YXJ0OiBcInRpdGxlXCIsXG4gICAgICBjZW50ZXI6IFwicHJldixuZXh0XCIsXG4gICAgICBlbmQ6IFwidG9kYXkgZGF5R3JpZE1vbnRoLHRpbWVHcmlkV2Vlayx0aW1lR3JpZERheSBsaXN0V2Vla1wiLFxuICAgIH0sXG5cbiAgICBwbHVnaW5zOiBbaW50ZXJhY3Rpb25QbHVnaW4sIGRheUdyaWRQbHVnaW4sIHRpbWVHcmlkUGx1Z2luLCBsaXN0UGx1Z2luXSwgLy8gaHR0cHM6Ly9mdWxsY2FsZW5kYXIuaW8vZG9jcy9wbHVnaW4taW5kZXhcbiAgICB0aW1lWm9uZTogXCJFdXJvcGUvUGFyaXNcIixcbiAgICBsb2NhbGU6IFwiZnJcIixcbiAgICBidXR0b25UZXh0OiB7XG4gICAgICB0b2RheTogXCJBdWpvdXJkJ2h1aVwiLFxuICAgICAgbW9udGg6IFwiTW9pc1wiLFxuICAgICAgd2VlazogXCJTZW1haW5lXCIsXG4gICAgICBkYXk6IFwiSm91clwiLFxuICAgICAgbGlzdDogXCJMaXN0ZVwiLFxuICAgIH0sXG5cbiAgICBidXNpbmVzc0hvdXJzOiB7XG4gICAgICBkYXlzT2ZXZWVrOiBbMSwgMiwgMywgNCwgNSwgNl0sXG4gICAgICBzdGFydFRpbWU6IFwiMDk6MDBcIixcbiAgICAgIGVuZFRpbWU6IFwiMTk6MzBcIixcbiAgICB9LFxuICAgIHNsb3REdXJhdGlvbjogXCIwMDozMFwiLFxuICAgIHNsb3RMYWJlbEludGVydmFsOiBcIjAxOjAwXCIsXG4gICAgdmlld3M6IHtcbiAgICAgIGRheUdyaWRNb250aDoge1xuICAgICAgICBkYXlNYXhFdmVudFJvd3M6IDMsXG4gICAgICB9LFxuICAgIH0sXG4gICAgbW9yZUxpbmtDbGFzc05hbWVzOiBcImJhZGdlIHJvdW5kZWQtcGlsbCBiZy1wcmltYXJ5IHRleHQtbGlnaHRcIixcbiAgICBtb3JlTGlua0NvbnRlbnQ6IGZ1bmN0aW9uIChhcmcpIHtcbiAgICAgIHJldHVybiBcIitcIiArIGFyZy5udW0gKyBcIiBhdXRyZXNcIjtcbiAgICB9LFxuICAgIGFsbERheVRleHQ6IFwiQ29uZ8Opc1wiLFxuICAgIG5vRXZlbnRzQ29udGVudDogXCJBdWN1biByZW5kZXotdm91cyDDoCBhZmZpY2hlclwiLFxuICAgIHNsb3RMYWJlbEZvcm1hdDoge1xuICAgICAgaG91cjogXCJudW1lcmljXCIsXG4gICAgICBtaW51dGU6IFwibnVtZXJpY1wiLFxuICAgICAgb21pdFplcm9NaW51dGU6IGZhbHNlLFxuICAgIH0sXG4gICAgc2xvdE1pblRpbWU6IFwiMDg6MzBcIixcbiAgICBzbG90TWF4VGltZTogXCIyMDowMFwiLFxuICAgIHNob3dOb25DdXJyZW50RGF0ZXM6IHRydWUsXG4gICAgbmF2TGlua3M6IHRydWUsXG4gICAgZmlyc3REYXk6IDEsXG4gICAgaW5pdGlhbFZpZXc6IFwidGltZUdyaWRXZWVrXCIsXG4gICAgZWRpdGFibGU6IGZhbHNlLFxuICAgIG5vd0luZGljYXRvcjogdHJ1ZSxcbiAgICBhbGxEYXlNYWludGFpbkR1cmF0aW9uOiB0cnVlLFxuICAgIGRhdGVDbGljazogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgIGxldCBkYXRlID0gZGF0YS5kYXRlLnRvVVRDU3RyaW5nKCk7XG4gICAgICBsZXQgaW5wdXROYiA9ICQoXCIjc2Fsb24gaW5wdXRcIikubGVuZ3RoO1xuXG4gICAgICAvLyBTdXIgY2xpcXVlIGR1IGNyw6luZWF1LCBhZmZpY2hlciBldCB2aWRlciBsZSBmb3JtdWxhaXJlXG4gICAgICAkKFwiI21vZGFsXCIpLm1vZGFsKFwic2hvd1wiKTtcblxuICAgICAgJChcIiNwaG9uZV9ib29raW5nX2NvaWZmZXVyXCIpXG4gICAgICAgIC5maW5kKFwib3B0aW9uXCIpXG4gICAgICAgIC5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAkKHRoaXMpLnJlbW92ZSgpO1xuICAgICAgICB9KTtcbiAgICAgICQoXCIjcGhvbmVfYm9va2luZ19jb2lmZmV1clwiKS5hcHBlbmQoXG4gICAgICAgIG5ldyBPcHRpb24oXCItLSBDb2lmZmV1ciAtLVwiLCBcImNvaWZmZXVyXCIpXG4gICAgICApO1xuICAgICAgJChcbiAgICAgICAgXCIjcGhvbmVfYm9va2luZ19iZWdpbkF0LCAjcGhvbmVfYm9va2luZ19ib29rZXJGdWxsbmFtZSwgI3Bob25lX2Jvb2tpbmdfZGVzY3JpcHRpb24sICNwaG9uZV9ib29raW5nX3Byb2R1Y3ROYW1lXCJcbiAgICAgICkudmFsKFwiXCIpO1xuICAgICAgJChcIi5yZHZcIikuaHRtbChcIlwiKTtcblxuICAgICAgLy8gQXBwZWwgQWpheCBhcHLDqHMgbGUgY2hvaXggZHUgc2Fsb25cblxuICAgICAgJChcIiNzYWxvblwiKS5vbihcImNsaWNrXCIsIFwiaW5wdXRcIiwgZnVuY3Rpb24gKCkge1xuICAgICAgICBpZiAoaW5wdXROYiA9PT0gMSkge1xuICAgICAgICAgICQoXCIjc2Fsb25cIikuaGlkZSgpO1xuICAgICAgICB9XG4gICAgICAgICQoXCIuanMtc2Fsb25cIikucmVtb3ZlQ2xhc3MoXCJidG4taW5mb1wiKS5hZGRDbGFzcyhcImJ0bi1vdXRsaW5lLWluZm9cIik7XG4gICAgICAgICQodGhpcykucmVtb3ZlQ2xhc3MoXCJidG4tb3V0bGluZS1pbmZvXCIpLmFkZENsYXNzKFwiYnRuLWluZm9cIik7XG4gICAgICAgICQucG9zdCh7XG4gICAgICAgICAgdXJsOiBcImFqYXgtcGhvbmUtYm9va2luZy1hZG1pblwiLFxuICAgICAgICAgIGRhdGFUeXBlOiBcImpzb25cIixcbiAgICAgICAgICBhc3luYzogZmFsc2UsXG4gICAgICAgICAgZGF0YToge1xuICAgICAgICAgICAgZGF0ZTogZGF0ZSxcbiAgICAgICAgICAgIHNhbG9uSWQ6IHRoaXMuZGF0YXNldC5zYWxvbixcbiAgICAgICAgICB9LFxuICAgICAgICAgIGJlZm9yZVNlbmQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIERhc2htaXgubGF5b3V0KFwiaGVhZGVyX2xvYWRlcl9vblwiKTtcbiAgICAgICAgICB9LFxuICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uIChyZXN1bHQsIHJlcXVlc3QpIHtcbiAgICAgICAgICAgIGxldCBjb2lmZmV1ciA9IHJlc3VsdC5kaXNwbztcbiAgICAgICAgICAgIGxldCBkYXRlID0gcmVzdWx0LmRhdGU7XG4gICAgICAgICAgICBsZXQgZGF0ZUZyID0gcmVzdWx0LmRhdGVGcjtcblxuICAgICAgICAgICAgJChcIi5yZHZcIikuaHRtbChkYXRlRnIpO1xuICAgICAgICAgICAgJChcIiNwaG9uZV9ib29raW5nX2NvaWZmZXVyXCIpXG4gICAgICAgICAgICAgIC5maW5kKFwib3B0aW9uXCIpXG4gICAgICAgICAgICAgIC5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAkKHRoaXMpLnJlbW92ZSgpO1xuICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICQoXCIjcGhvbmVfYm9va2luZ19jb2lmZmV1clwiKS5hcHBlbmQoXG4gICAgICAgICAgICAgIG5ldyBPcHRpb24oXCItLSBDb2lmZmV1ciAtLVwiLCBcImNvaWZmZXVyXCIpXG4gICAgICAgICAgICApO1xuICAgICAgICAgICAgJChcIiNwaG9uZV9ib29raW5nX2JlZ2luQXRcIikudmFsKFwiXCIpLnZhbChkYXRlKTtcbiAgICAgICAgICAgIGNvaWZmZXVyLmZvckVhY2goKGUpID0+IHtcbiAgICAgICAgICAgICAgJChcIiNwaG9uZV9ib29raW5nX2NvaWZmZXVyXCIpLmFwcGVuZChcbiAgICAgICAgICAgICAgICBuZXcgT3B0aW9uKGUuY29pZmZldXJOYW1lLCBlLmNvaWZmZXVySWQpXG4gICAgICAgICAgICAgICk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIC8vIE5ldHRveWFnZSBkdSBmb3JtdWxhaXJlIGFwcsOocyBmZXJtZXR1cmUgZHUgbW9kYWxcbiAgICAgICAgICAgICQoXCIjbW9kYWxcIikub24oXCJoaWRlLmJzLm1vZGFsXCIsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICAgICQoXCIuanMtc2Fsb25cIilcbiAgICAgICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJidG4taW5mb1wiKVxuICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImJ0bi1vdXRsaW5lLWluZm9cIik7XG4gICAgICAgICAgICAgICQoXCIjcGhvbmVfYm9va2luZ19jb2lmZmV1clwiKVxuICAgICAgICAgICAgICAgIC5maW5kKFwib3B0aW9uXCIpXG4gICAgICAgICAgICAgICAgLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgJCh0aGlzKS5yZW1vdmUoKTtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgJChcIiNwaG9uZV9ib29raW5nX2NvaWZmZXVyXCIpLmFwcGVuZChcbiAgICAgICAgICAgICAgICBuZXcgT3B0aW9uKFwiLS0gQ29pZmZldXIgLS1cIiwgXCJcIilcbiAgICAgICAgICAgICAgKTtcbiAgICAgICAgICAgICAgJChcbiAgICAgICAgICAgICAgICBcIiNwaG9uZV9ib29raW5nX2Jvb2tlckZ1bGxuYW1lLCAjcGhvbmVfYm9va2luZ19kZXNjcmlwdGlvbiwgI3Bob25lX2Jvb2tpbmdfYmVnaW5BdFwiXG4gICAgICAgICAgICAgICkudmFsKFwiXCIpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgfSxcbiAgICAgICAgICBjb21wbGV0ZTogZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgRGFzaG1peC5sYXlvdXQoXCJoZWFkZXJfbG9hZGVyX29mZlwiKTtcbiAgICAgICAgICB9LFxuICAgICAgICB9KTtcbiAgICAgIH0pO1xuICAgICAgaWYgKGlucHV0TmIgPT09IDEpIHtcbiAgICAgICAgJChcIiNzYWxvblwiKS5maW5kKFwiaW5wdXRcIikudHJpZ2dlcihcImNsaWNrXCIpO1xuICAgICAgfVxuICAgICAgLy8gU291bWlzc2lvbiBkdSBmb3JtdWxhaXJlXG4gICAgICAkKFwiI2J0bl9zdWJtaXRcIikub24oXCJjbGlja1wiLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICQodGhpcykuY2xvc2VzdChcImZvcm1cIikuc3VibWl0KCk7XG4gICAgICB9KTtcbiAgICB9LFxuICAgIGV2ZW50U291cmNlczogW1xuICAgICAge1xuICAgICAgICB1cmw6IGV2ZW50c1VybCxcbiAgICAgICAgbWV0aG9kOiBcIlBPU1RcIixcbiAgICAgICAgZXh0cmFQYXJhbXM6IHtcbiAgICAgICAgICBmaWx0ZXJzOiBKU09OLnN0cmluZ2lmeSh7fSksXG4gICAgICAgIH0sXG4gICAgICAgIGZhaWx1cmU6ICgpID0+IHtcbiAgICAgICAgICAvLyBhbGVydChcIlRoZXJlIHdhcyBhbiBlcnJvciB3aGlsZSBmZXRjaGluZyBGdWxsQ2FsZW5kYXIhXCIpO1xuICAgICAgICB9LFxuICAgICAgfSxcbiAgICBdLFxuICB9KTtcbiAgY2FsZW5kYXIucmVuZGVyKCk7XG4gIHNldEludGVydmFsKGZ1bmN0aW9uICgpIHtcbiAgICBjYWxlbmRhci5yZWZldGNoRXZlbnRzKCk7XG4gIH0sIDUwMDApO1xufSk7XG4iXSwibmFtZXMiOlsiQ2FsZW5kYXIiLCJpbnRlcmFjdGlvblBsdWdpbiIsIkRyYWdnYWJsZSIsImxpc3RQbHVnaW4iLCJ0aW1lR3JpZFBsdWdpbiIsImRheUdyaWRQbHVnaW4iLCJTd2FsIiwiZWFjaCIsImRvY3VtZW50IiwiYWRkRXZlbnRMaXN0ZW5lciIsImNhbGVuZGFyRWwiLCJnZXRFbGVtZW50QnlJZCIsImV2ZW50c1VybCIsImRhdGFzZXQiLCJjYWxlbmRhciIsImhlYWRlclRvb2xiYXIiLCJzdGFydCIsImNlbnRlciIsImVuZCIsInBsdWdpbnMiLCJ0aW1lWm9uZSIsImxvY2FsZSIsImJ1dHRvblRleHQiLCJ0b2RheSIsIm1vbnRoIiwid2VlayIsImRheSIsImxpc3QiLCJidXNpbmVzc0hvdXJzIiwiZGF5c09mV2VlayIsInN0YXJ0VGltZSIsImVuZFRpbWUiLCJzbG90RHVyYXRpb24iLCJzbG90TGFiZWxJbnRlcnZhbCIsInZpZXdzIiwiZGF5R3JpZE1vbnRoIiwiZGF5TWF4RXZlbnRSb3dzIiwibW9yZUxpbmtDbGFzc05hbWVzIiwibW9yZUxpbmtDb250ZW50IiwiYXJnIiwibnVtIiwiYWxsRGF5VGV4dCIsIm5vRXZlbnRzQ29udGVudCIsInNsb3RMYWJlbEZvcm1hdCIsImhvdXIiLCJtaW51dGUiLCJvbWl0WmVyb01pbnV0ZSIsInNsb3RNaW5UaW1lIiwic2xvdE1heFRpbWUiLCJzaG93Tm9uQ3VycmVudERhdGVzIiwibmF2TGlua3MiLCJmaXJzdERheSIsImluaXRpYWxWaWV3IiwiZWRpdGFibGUiLCJub3dJbmRpY2F0b3IiLCJhbGxEYXlNYWludGFpbkR1cmF0aW9uIiwiZGF0ZUNsaWNrIiwiZGF0YSIsImRhdGUiLCJ0b1VUQ1N0cmluZyIsImlucHV0TmIiLCIkIiwibGVuZ3RoIiwibW9kYWwiLCJmaW5kIiwicmVtb3ZlIiwiYXBwZW5kIiwiT3B0aW9uIiwidmFsIiwiaHRtbCIsIm9uIiwiaGlkZSIsInJlbW92ZUNsYXNzIiwiYWRkQ2xhc3MiLCJwb3N0IiwidXJsIiwiZGF0YVR5cGUiLCJhc3luYyIsInNhbG9uSWQiLCJzYWxvbiIsImJlZm9yZVNlbmQiLCJEYXNobWl4IiwibGF5b3V0Iiwic3VjY2VzcyIsInJlc3VsdCIsInJlcXVlc3QiLCJjb2lmZmV1ciIsImRpc3BvIiwiZGF0ZUZyIiwiZm9yRWFjaCIsImUiLCJjb2lmZmV1ck5hbWUiLCJjb2lmZmV1cklkIiwiY29tcGxldGUiLCJ0cmlnZ2VyIiwiY2xvc2VzdCIsInN1Ym1pdCIsImV2ZW50U291cmNlcyIsIm1ldGhvZCIsImV4dHJhUGFyYW1zIiwiZmlsdGVycyIsIkpTT04iLCJzdHJpbmdpZnkiLCJmYWlsdXJlIiwicmVuZGVyIiwic2V0SW50ZXJ2YWwiLCJyZWZldGNoRXZlbnRzIl0sInNvdXJjZVJvb3QiOiIifQ==