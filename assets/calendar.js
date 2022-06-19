import { Calendar } from "@fullcalendar/core";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";
import dayGridPlugin from "@fullcalendar/daygrid";
import "@fullcalendar/core/locales-all";
import Swal from "sweetalert2";
import { each } from "jquery";

document.addEventListener("DOMContentLoaded", () => {
  var calendarEl = document.getElementById("calendar-holder");

  var eventsUrl = calendarEl.dataset.eventsUrl;

  var calendar = new Calendar(calendarEl, {
    headerToolbar: {
      start: "title",
      center: "prev,next",
      end: "today dayGridMonth,timeGridWeek,timeGridDay listWeek",
    },

    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin], // https://fullcalendar.io/docs/plugin-index
    timeZone: "Europe/Paris",
    locale: "fr",
    buttonText: {
      today: "Aujourd'hui",
      month: "Mois",
      week: "Semaine",
      day: "Jour",
      list: "Liste",
    },

    businessHours: {
      daysOfWeek: [1, 2, 3, 4, 5, 6],
      startTime: "09:00",
      endTime: "19:30",
    },
    slotDuration: "00:30",
    slotLabelInterval: "01:00",
    views: {
      dayGridMonth: {
        dayMaxEventRows: 3,
      },
    },
    moreLinkClassNames: "badge rounded-pill bg-primary text-light",
    moreLinkContent: function (arg) {
      return "+" + arg.num + " autres";
    },
    allDayText: "Congés",
    noEventsContent: "Aucun rendez-vous à afficher",
    slotLabelFormat: {
      hour: "numeric",
      minute: "numeric",
      omitZeroMinute: false,
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
    dateClick: function (data) {
      let date = data.date.toUTCString();
      let inputNb = $("#salon input").length;

      // Sur clique du créneau, afficher et vider le formulaire
      $("#modal").modal("show");

      $("#phone_booking_coiffeur")
        .find("option")
        .each(function () {
          $(this).remove();
        });
      $("#phone_booking_coiffeur").append(
        new Option("-- Coiffeur --", "coiffeur")
      );
      $(
        "#phone_booking_beginAt, #phone_booking_bookerFullname, #phone_booking_description, #phone_booking_productName"
      ).val("");
      $(".rdv").html("");

      // Appel Ajax après le choix du salon

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
            salonId: this.dataset.salon,
          },
          beforeSend: function () {
            Dashmix.layout("header_loader_on");
          },
          success: function (result, request) {
            let coiffeur = result.dispo;
            let date = result.date;
            let dateFr = result.dateFr;

            $(".rdv").html(dateFr);
            $("#phone_booking_coiffeur")
              .find("option")
              .each(function () {
                $(this).remove();
              });
            $("#phone_booking_coiffeur").append(
              new Option("-- Coiffeur --", "coiffeur")
            );
            $("#phone_booking_beginAt").val("").val(date);
            coiffeur.forEach((e) => {
              $("#phone_booking_coiffeur").append(
                new Option(e.coiffeurName, e.coiffeurId)
              );
            });
            // Nettoyage du formulaire après fermeture du modal
            $("#modal").on("hide.bs.modal", function (e) {
              $(".js-salon")
                .removeClass("btn-info")
                .addClass("btn-outline-info");
              $("#phone_booking_coiffeur")
                .find("option")
                .each(function () {
                  $(this).remove();
                });
              $("#phone_booking_coiffeur").append(
                new Option("-- Coiffeur --", "")
              );
              $(
                "#phone_booking_bookerFullname, #phone_booking_description, #phone_booking_beginAt"
              ).val("");
            });
          },
          complete: function () {
            Dashmix.layout("header_loader_off");
          },
        });
      });
      if (inputNb === 1) {
        $("#salon").find("input").trigger("click");
      }
      // Soumission du formulaire
      $("#btn_submit").on("click", function () {
        $(this).closest("form").submit();
      });
    },
    eventSources: [
      {
        url: eventsUrl,
        method: "POST",
        extraParams: {
          filters: JSON.stringify({}),
        },
        failure: () => {
          // alert("There was an error while fetching FullCalendar!");
        },
      },
    ],
  });
  calendar.render();
  setInterval(function () {
    calendar.refetchEvents();
  }, 5000);
});
