/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import "./customer.scss";
import Swal from "sweetalert2";
// any CSS you import will output into a single css file (app.css in this case)

Dashmix.onLoad(
  class {
    static sweetAlert2() {
      let e = Swal.mixin({
        buttonsStyling: !1,
        target: "#page-container",
        customClass: {
          confirmButton: "btn btn-success m-1",
          cancelButton: "btn btn-danger m-1",
          input: "form-control",
        },
      });
      $(".js-swal-simple").on("click", (t) => {
        e.fire("Hi, this is just a simple message!");
      }),
        $(".js-swal-success").on("click", (t) => {
          e.fire("Success", "Everything was updated perfectly!", "success");
        }),
        $(".js-swal-info").on("click", (t) => {
          e.fire("Info", "Just an informational message!", "info");
        }),
        $(".js-swal-warning").on("click", (t) => {
          e.fire("Warning", "Something needs your attention!", "warning");
        }),
        $(".js-swal-error").on("click", (t) => {
          e.fire("Oops...", "Something went wrong!", "error");
        }),
        $(".js-swal-question").on("click", (t) => {
          e.fire("Question", "Are you sure about that?", "question");
        }),
        $(".js-swal-confirm").on("click", function (t) {
          e.fire({
            title: "On prépare nos ciseaux?",
            text: "Réservez votre créneaux en cliquant sur confirmer.",
            icon: "warning",
            showDenyButton: !0,
            customClass: {
              confirmButton: "btn btn-primary m-1 text-light",
              cancelButton: "btn btn-secondary m-1",
              denyButton: "btn btn-secondary m-1",
            },
            confirmButtonText: "Confimer",
            denyButtonText: "Annuler",
            showLoaderOnConfirm: true,
            html: !1,
            preConfirm: (e) =>
              new Promise((e) => {
                setTimeout(() => {
                  e();
                }, 3000);
              }),
          }).then((t) => {
            if (t.value) {
              e.fire({
                title: "C'est tout bon !",
                text: "Vous recevrez un email de confirmation.",
                icon: "success",
              }).then((t) => {
                $(this).closest("form").submit();
              });
            } else if (t.dismiss === Swal.DismissReason.cancel) {
              e.fire(
                "Annulé",
                "Cette réservation ne sera pas enregistré.",
                "error"
              );
            }
          });
        }),
        $(".js-swal-custom-position").on("click", (t) => {
          e.fire({
            position: "top-end",
            title: "Perfect!",
            text: "Nice Position!",
            icon: "success",
          });
        });
    }
    static init() {
      this.sweetAlert2();
    }
  }.init()
);
