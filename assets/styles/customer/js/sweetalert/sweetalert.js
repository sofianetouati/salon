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
        $(".js-swal-confirmation").on("click", (t) => {
          e.fire({
            title: "On prépare nos ciseaux?",
            text: "Réservez votre créneaux en cliquant sur confirmer.",
            icon: "warning",
            showCancelButton: !0,
            customClass: {
              confirmButton: "btn btn-primary m-1",
              cancelButton: "btn btn-secondary m-1",
            },
            confirmButtonText: "Confimer",
            html: !1,
            preConfirm: (e) =>
              new Promise((e) => {
                setTimeout(() => {
                  e();
                }, 50);
              }),
          }).then((t) => {
            t.value
              ? e.fire(
                  "C'est tout bon !",
                  "Votre place est réservé.",
                  "success"
                )
              : "Annuler" === t.dismiss &&
                e.fire(
                  "Annulé",
                  "Vous avez annulé votre réservation.",
                  "error"
                );
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
