(self["webpackChunk"] = self["webpackChunk"] || []).push([["datatable"],{

/***/ "./assets/datatable.js":
/*!*****************************!*\
  !*** ./assets/datatable.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_admin_admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/admin/admin.scss */ "./assets/styles/admin/admin.scss");
/* harmony import */ var datatables_net__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! datatables.net */ "./node_modules/datatables.net/js/jquery.dataTables.js");
/* harmony import */ var datatables_net__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(datatables_net__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var datatables_net_bs5__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! datatables.net-bs5 */ "./node_modules/datatables.net-bs5/js/dataTables.bootstrap5.js");
/* harmony import */ var datatables_net_bs5__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(datatables_net_bs5__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var datatables_net_buttons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! datatables.net-buttons */ "./node_modules/datatables.net-buttons/js/dataTables.buttons.js");
/* harmony import */ var datatables_net_buttons__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(datatables_net_buttons__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var datatables_net_buttons_bs5__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! datatables.net-buttons-bs5 */ "./node_modules/datatables.net-buttons-bs5/js/buttons.bootstrap5.js");
/* harmony import */ var datatables_net_buttons_bs5__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(datatables_net_buttons_bs5__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var jszip__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! jszip */ "./node_modules/jszip/dist/jszip.min.js");
/* harmony import */ var jszip__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(jszip__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var pdfmake_build_pdfmake__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! pdfmake/build/pdfmake */ "./node_modules/pdfmake/build/pdfmake.js");
/* harmony import */ var pdfmake_build_pdfmake__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(pdfmake_build_pdfmake__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var pdfmake_build_vfs_fonts__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! pdfmake/build/vfs_fonts */ "./node_modules/pdfmake/build/vfs_fonts.js");
/* harmony import */ var datatables_net_buttons_js_buttons_print__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! datatables.net-buttons/js/buttons.print */ "./node_modules/datatables.net-buttons/js/buttons.print.js");
/* harmony import */ var datatables_net_buttons_js_buttons_print__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(datatables_net_buttons_js_buttons_print__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var datatables_net_buttons_js_buttons_html5__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! datatables.net-buttons/js/buttons.html5 */ "./node_modules/datatables.net-buttons/js/buttons.html5.js");
/* harmony import */ var datatables_net_buttons_js_buttons_html5__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(datatables_net_buttons_js_buttons_html5__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _styles_admin_js_datatables_datatable__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./styles/admin/js/datatables/datatable */ "./assets/styles/admin/js/datatables/datatable.js");
/* harmony import */ var _styles_admin_js_datatables_datatable__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_styles_admin_js_datatables_datatable__WEBPACK_IMPORTED_MODULE_10__);
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
 // any CSS you import will output into a single css file (app.css in this case)






window.jsZip = (jszip__WEBPACK_IMPORTED_MODULE_5___default());


(pdfmake_build_pdfmake__WEBPACK_IMPORTED_MODULE_6___default().vfs) = pdfmake_build_vfs_fonts__WEBPACK_IMPORTED_MODULE_7__.pdfMake.vfs; //import "datatables.net-buttons/js/buttons.colVis";





/***/ }),

/***/ "./assets/styles/admin/js/datatables/datatable.js":
/*!********************************************************!*\
  !*** ./assets/styles/admin/js/datatables/datatable.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
__webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

/*
 *  Document   : be_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in DataTables Page
 */
// DataTables, for more examples you can check out https://www.datatables.net/
var pageTablesDatatables = /*#__PURE__*/function () {
  "use strict";

  function pageTablesDatatables() {
    _classCallCheck(this, pageTablesDatatables);
  }

  _createClass(pageTablesDatatables, null, [{
    key: "initDataTables",
    value:
    /*
     * Init DataTables functionality
     *
     */
    function initDataTables() {
      // Override a few default classes
      jQuery.extend(jQuery.fn.dataTable.ext.classes, {
        sWrapper: "dataTables_wrapper dt-bootstrap5",
        sFilterInput: "form-control",
        sLengthSelect: "form-select"
      }); // Override a few defaults

      jQuery.extend(true, jQuery.fn.dataTable.defaults, {
        order: false,
        language: {
          /* buttons: {
            copySuccess: {
              1: "1 ligne copiée dans le presse-papier",
              _: "%d lignes copiées dans le presse-papier",
            },
            copyTitle: "Copier dans le presse-papier",
          }, */
          zeroRecords: "Aucun résultat trouvé",
          thousands: " ",
          infoEmpty: "Aucun résultat trouvé",
          infoFiltered: " sur _MAX_ entrées",
          lengthMenu: "_MENU_",
          search: "_INPUT_",
          searchPlaceholder: "Rechercher...",
          info: "Page <strong>_PAGE_</strong> sur <strong>_PAGES_</strong>",
          paginate: {
            first: '<i class="fa fa-angle-double-left"></i>',
            previous: '<i class="fa fa-angle-left"></i>',
            next: '<i class="fa fa-angle-right"></i>',
            last: '<i class="fa fa-angle-double-right"></i>'
          }
        }
      }); // Override buttons default classes

      jQuery.extend(true, jQuery.fn.DataTable.Buttons.defaults, {
        dom: {
          button: {
            className: "btn btn-sm btn-primary text-light"
          },
          span: {
            className: "text-light"
          }
        }
      }); // Init full DataTable

      jQuery(".js-dataTable-full").DataTable({
        pageLength: 20,
        lengthMenu: [[20, 50, 100], [20, 50, 100]],
        autoWidth: false
      }); // Init DataTable with Buttons

      jQuery(".js-dataTable-buttons").DataTable({
        pageLength: 20,
        lengthMenu: [[20, 50, 100], [20, 50, 100]],
        autoWidth: false,
        buttons: [{
          extend: "csv",
          text: "Excel"
        }, {
          extend: "pdf",
          text: "Pdf",
          pdfOrientation: "landscape"
        }, {
          extend: "print",
          text: "Imprimer"
        }],
        dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>>" + "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
      }); // Init full extra DataTable

      jQuery(".js-dataTable-full-pagination").DataTable({
        pagingType: "full_numbers",
        pageLength: 20,
        lengthMenu: [[20, 50, 100], [20, 50, 100]],
        autoWidth: false
      }); // Init simple DataTable

      jQuery(".js-dataTable-simple").DataTable({
        pageLength: 5,
        lengthMenu: false,
        searching: false,
        autoWidth: false,
        dom: "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-6'i><'col-sm-6'p>>"
      });
    }
    /*
     * Init functionality
     *
     */

  }, {
    key: "init",
    value: function init() {
      this.initDataTables();
    }
  }]);

  return pageTablesDatatables;
}(); // Initialize when page loads


Dashmix.onLoad(pageTablesDatatables.init());

/***/ }),

/***/ "./assets/styles/admin/admin.scss":
/*!****************************************!*\
  !*** ./assets/styles/admin/admin.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_export_js-node_modules_jquery_dist_jquery_js","vendors-node_modules_fullcalendar_common_main_css-node_modules_fullcalendar_daygrid_main_css--e76eee","vendors-node_modules_core-js_modules_es_object_define-property_js-node_modules_datatables_net-0bd90c","assets_styles_admin_css_themes_xmodern_css-assets_styles_admin_js_plugins_bootstrap-colorpick-3abcf3"], () => (__webpack_exec__("./assets/datatable.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Q0FBQ0MsTUFBUixDQUFlekMsb0JBQW9CLENBQUMwQyxJQUFyQixFQUFmOzs7Ozs7Ozs7Ozs7QUNqSUEiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvZGF0YXRhYmxlLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYWRtaW4vanMvZGF0YXRhYmxlcy9kYXRhdGFibGUuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3N0eWxlcy9hZG1pbi9hZG1pbi5zY3NzIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogV2UgcmVjb21tZW5kIGluY2x1ZGluZyB0aGUgYnVpbHQgdmVyc2lvbiBvZiB0aGlzIEphdmFTY3JpcHQgZmlsZVxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cbiAqL1xuXG5pbXBvcnQgXCIuL3N0eWxlcy9hZG1pbi9hZG1pbi5zY3NzXCI7XG4vLyBhbnkgQ1NTIHlvdSBpbXBvcnQgd2lsbCBvdXRwdXQgaW50byBhIHNpbmdsZSBjc3MgZmlsZSAoYXBwLmNzcyBpbiB0aGlzIGNhc2UpXG5cbmltcG9ydCBcImRhdGF0YWJsZXMubmV0XCI7XG5pbXBvcnQgXCJkYXRhdGFibGVzLm5ldC1iczVcIjtcbmltcG9ydCBcImRhdGF0YWJsZXMubmV0LWJ1dHRvbnNcIjtcbmltcG9ydCBcImRhdGF0YWJsZXMubmV0LWJ1dHRvbnMtYnM1XCI7XG5pbXBvcnQganNaaXAgZnJvbSBcImpzemlwXCI7XG53aW5kb3cuanNaaXAgPSBqc1ppcDtcbmltcG9ydCBwZGZNYWtlIGZyb20gXCJwZGZtYWtlL2J1aWxkL3BkZm1ha2VcIjtcbmltcG9ydCBwZGZGb250cyBmcm9tIFwicGRmbWFrZS9idWlsZC92ZnNfZm9udHNcIjtcbnBkZk1ha2UudmZzID0gcGRmRm9udHMucGRmTWFrZS52ZnM7XG4vL2ltcG9ydCBcImRhdGF0YWJsZXMubmV0LWJ1dHRvbnMvanMvYnV0dG9ucy5jb2xWaXNcIjtcblxuaW1wb3J0IFwiZGF0YXRhYmxlcy5uZXQtYnV0dG9ucy9qcy9idXR0b25zLnByaW50XCI7XG5pbXBvcnQgXCJkYXRhdGFibGVzLm5ldC1idXR0b25zL2pzL2J1dHRvbnMuaHRtbDVcIjtcbmltcG9ydCBcIi4vc3R5bGVzL2FkbWluL2pzL2RhdGF0YWJsZXMvZGF0YXRhYmxlXCI7XG4iLCIvKlxuICogIERvY3VtZW50ICAgOiBiZV90YWJsZXNfZGF0YXRhYmxlcy5qc1xuICogIEF1dGhvciAgICAgOiBwaXhlbGNhdmVcbiAqICBEZXNjcmlwdGlvbjogQ3VzdG9tIEpTIGNvZGUgdXNlZCBpbiBEYXRhVGFibGVzIFBhZ2VcbiAqL1xuXG4vLyBEYXRhVGFibGVzLCBmb3IgbW9yZSBleGFtcGxlcyB5b3UgY2FuIGNoZWNrIG91dCBodHRwczovL3d3dy5kYXRhdGFibGVzLm5ldC9cbmNsYXNzIHBhZ2VUYWJsZXNEYXRhdGFibGVzIHtcbiAgLypcbiAgICogSW5pdCBEYXRhVGFibGVzIGZ1bmN0aW9uYWxpdHlcbiAgICpcbiAgICovXG4gIHN0YXRpYyBpbml0RGF0YVRhYmxlcygpIHtcbiAgICAvLyBPdmVycmlkZSBhIGZldyBkZWZhdWx0IGNsYXNzZXNcbiAgICBqUXVlcnkuZXh0ZW5kKGpRdWVyeS5mbi5kYXRhVGFibGUuZXh0LmNsYXNzZXMsIHtcbiAgICAgIHNXcmFwcGVyOiBcImRhdGFUYWJsZXNfd3JhcHBlciBkdC1ib290c3RyYXA1XCIsXG4gICAgICBzRmlsdGVySW5wdXQ6IFwiZm9ybS1jb250cm9sXCIsXG4gICAgICBzTGVuZ3RoU2VsZWN0OiBcImZvcm0tc2VsZWN0XCIsXG4gICAgfSk7XG5cbiAgICAvLyBPdmVycmlkZSBhIGZldyBkZWZhdWx0c1xuICAgIGpRdWVyeS5leHRlbmQodHJ1ZSwgalF1ZXJ5LmZuLmRhdGFUYWJsZS5kZWZhdWx0cywge1xuICAgICAgb3JkZXI6IGZhbHNlLFxuICAgICAgbGFuZ3VhZ2U6IHtcbiAgICAgICAgLyogYnV0dG9uczoge1xuICAgICAgICAgIGNvcHlTdWNjZXNzOiB7XG4gICAgICAgICAgICAxOiBcIjEgbGlnbmUgY29wacOpZSBkYW5zIGxlIHByZXNzZS1wYXBpZXJcIixcbiAgICAgICAgICAgIF86IFwiJWQgbGlnbmVzIGNvcGnDqWVzIGRhbnMgbGUgcHJlc3NlLXBhcGllclwiLFxuICAgICAgICAgIH0sXG4gICAgICAgICAgY29weVRpdGxlOiBcIkNvcGllciBkYW5zIGxlIHByZXNzZS1wYXBpZXJcIixcbiAgICAgICAgfSwgKi9cbiAgICAgICAgemVyb1JlY29yZHM6IFwiQXVjdW4gcsOpc3VsdGF0IHRyb3V2w6lcIixcbiAgICAgICAgdGhvdXNhbmRzOiBcIiBcIixcbiAgICAgICAgaW5mb0VtcHR5OiBcIkF1Y3VuIHLDqXN1bHRhdCB0cm91dsOpXCIsXG4gICAgICAgIGluZm9GaWx0ZXJlZDogXCIgc3VyIF9NQVhfIGVudHLDqWVzXCIsXG4gICAgICAgIGxlbmd0aE1lbnU6IFwiX01FTlVfXCIsXG4gICAgICAgIHNlYXJjaDogXCJfSU5QVVRfXCIsXG4gICAgICAgIHNlYXJjaFBsYWNlaG9sZGVyOiBcIlJlY2hlcmNoZXIuLi5cIixcbiAgICAgICAgaW5mbzogXCJQYWdlIDxzdHJvbmc+X1BBR0VfPC9zdHJvbmc+IHN1ciA8c3Ryb25nPl9QQUdFU188L3N0cm9uZz5cIixcbiAgICAgICAgcGFnaW5hdGU6IHtcbiAgICAgICAgICBmaXJzdDogJzxpIGNsYXNzPVwiZmEgZmEtYW5nbGUtZG91YmxlLWxlZnRcIj48L2k+JyxcbiAgICAgICAgICBwcmV2aW91czogJzxpIGNsYXNzPVwiZmEgZmEtYW5nbGUtbGVmdFwiPjwvaT4nLFxuICAgICAgICAgIG5leHQ6ICc8aSBjbGFzcz1cImZhIGZhLWFuZ2xlLXJpZ2h0XCI+PC9pPicsXG4gICAgICAgICAgbGFzdDogJzxpIGNsYXNzPVwiZmEgZmEtYW5nbGUtZG91YmxlLXJpZ2h0XCI+PC9pPicsXG4gICAgICAgIH0sXG4gICAgICB9LFxuICAgIH0pO1xuXG4gICAgLy8gT3ZlcnJpZGUgYnV0dG9ucyBkZWZhdWx0IGNsYXNzZXNcbiAgICBqUXVlcnkuZXh0ZW5kKHRydWUsIGpRdWVyeS5mbi5EYXRhVGFibGUuQnV0dG9ucy5kZWZhdWx0cywge1xuICAgICAgZG9tOiB7XG4gICAgICAgIGJ1dHRvbjoge1xuICAgICAgICAgIGNsYXNzTmFtZTogXCJidG4gYnRuLXNtIGJ0bi1wcmltYXJ5IHRleHQtbGlnaHRcIixcbiAgICAgICAgfSxcbiAgICAgICAgc3Bhbjoge1xuICAgICAgICAgIGNsYXNzTmFtZTogXCJ0ZXh0LWxpZ2h0XCIsXG4gICAgICAgIH0sXG4gICAgICB9LFxuICAgIH0pO1xuXG4gICAgLy8gSW5pdCBmdWxsIERhdGFUYWJsZVxuICAgIGpRdWVyeShcIi5qcy1kYXRhVGFibGUtZnVsbFwiKS5EYXRhVGFibGUoe1xuICAgICAgcGFnZUxlbmd0aDogMjAsXG4gICAgICBsZW5ndGhNZW51OiBbXG4gICAgICAgIFsyMCwgNTAsIDEwMF0sXG4gICAgICAgIFsyMCwgNTAsIDEwMF0sXG4gICAgICBdLFxuICAgICAgYXV0b1dpZHRoOiBmYWxzZSxcbiAgICB9KTtcblxuICAgIC8vIEluaXQgRGF0YVRhYmxlIHdpdGggQnV0dG9uc1xuICAgIGpRdWVyeShcIi5qcy1kYXRhVGFibGUtYnV0dG9uc1wiKS5EYXRhVGFibGUoe1xuICAgICAgcGFnZUxlbmd0aDogMjAsXG4gICAgICBsZW5ndGhNZW51OiBbXG4gICAgICAgIFsyMCwgNTAsIDEwMF0sXG4gICAgICAgIFsyMCwgNTAsIDEwMF0sXG4gICAgICBdLFxuICAgICAgYXV0b1dpZHRoOiBmYWxzZSxcbiAgICAgIGJ1dHRvbnM6IFtcbiAgICAgICAge1xuICAgICAgICAgIGV4dGVuZDogXCJjc3ZcIixcbiAgICAgICAgICB0ZXh0OiBcIkV4Y2VsXCIsXG4gICAgICAgIH0sXG4gICAgICAgIHtcbiAgICAgICAgICBleHRlbmQ6IFwicGRmXCIsXG4gICAgICAgICAgdGV4dDogXCJQZGZcIixcbiAgICAgICAgICBwZGZPcmllbnRhdGlvbjogXCJsYW5kc2NhcGVcIixcbiAgICAgICAgfSxcbiAgICAgICAge1xuICAgICAgICAgIGV4dGVuZDogXCJwcmludFwiLFxuICAgICAgICAgIHRleHQ6IFwiSW1wcmltZXJcIixcbiAgICAgICAgfSxcbiAgICAgIF0sXG4gICAgICBkb206XG4gICAgICAgIFwiPCdyb3cnPCdjb2wtc20tMTInPCd0ZXh0LWNlbnRlciBiZy1ib2R5LWxpZ2h0IHB5LTIgbWItMidCPj4+XCIgK1xuICAgICAgICBcIjwncm93JzwnY29sLXNtLTEyIGNvbC1tZC02J2w+PCdjb2wtc20tMTIgY29sLW1kLTYnZj4+PCdyb3cnPCdjb2wtc20tMTIndHI+Pjwncm93JzwnY29sLXNtLTEyIGNvbC1tZC01J2k+PCdjb2wtc20tMTIgY29sLW1kLTcncD4+XCIsXG4gICAgfSk7XG5cbiAgICAvLyBJbml0IGZ1bGwgZXh0cmEgRGF0YVRhYmxlXG4gICAgalF1ZXJ5KFwiLmpzLWRhdGFUYWJsZS1mdWxsLXBhZ2luYXRpb25cIikuRGF0YVRhYmxlKHtcbiAgICAgIHBhZ2luZ1R5cGU6IFwiZnVsbF9udW1iZXJzXCIsXG4gICAgICBwYWdlTGVuZ3RoOiAyMCxcbiAgICAgIGxlbmd0aE1lbnU6IFtcbiAgICAgICAgWzIwLCA1MCwgMTAwXSxcbiAgICAgICAgWzIwLCA1MCwgMTAwXSxcbiAgICAgIF0sXG4gICAgICBhdXRvV2lkdGg6IGZhbHNlLFxuICAgIH0pO1xuXG4gICAgLy8gSW5pdCBzaW1wbGUgRGF0YVRhYmxlXG4gICAgalF1ZXJ5KFwiLmpzLWRhdGFUYWJsZS1zaW1wbGVcIikuRGF0YVRhYmxlKHtcbiAgICAgIHBhZ2VMZW5ndGg6IDUsXG4gICAgICBsZW5ndGhNZW51OiBmYWxzZSxcbiAgICAgIHNlYXJjaGluZzogZmFsc2UsXG4gICAgICBhdXRvV2lkdGg6IGZhbHNlLFxuICAgICAgZG9tOiBcIjwncm93JzwnY29sLXNtLTEyJ3RyPj5cIiArIFwiPCdyb3cnPCdjb2wtc20tNidpPjwnY29sLXNtLTYncD4+XCIsXG4gICAgfSk7XG4gIH1cblxuICAvKlxuICAgKiBJbml0IGZ1bmN0aW9uYWxpdHlcbiAgICpcbiAgICovXG4gIHN0YXRpYyBpbml0KCkge1xuICAgIHRoaXMuaW5pdERhdGFUYWJsZXMoKTtcbiAgfVxufVxuXG4vLyBJbml0aWFsaXplIHdoZW4gcGFnZSBsb2Fkc1xuRGFzaG1peC5vbkxvYWQocGFnZVRhYmxlc0RhdGF0YWJsZXMuaW5pdCgpKTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJqc1ppcCIsIndpbmRvdyIsInBkZk1ha2UiLCJwZGZGb250cyIsInZmcyIsInBhZ2VUYWJsZXNEYXRhdGFibGVzIiwialF1ZXJ5IiwiZXh0ZW5kIiwiZm4iLCJkYXRhVGFibGUiLCJleHQiLCJjbGFzc2VzIiwic1dyYXBwZXIiLCJzRmlsdGVySW5wdXQiLCJzTGVuZ3RoU2VsZWN0IiwiZGVmYXVsdHMiLCJvcmRlciIsImxhbmd1YWdlIiwiemVyb1JlY29yZHMiLCJ0aG91c2FuZHMiLCJpbmZvRW1wdHkiLCJpbmZvRmlsdGVyZWQiLCJsZW5ndGhNZW51Iiwic2VhcmNoIiwic2VhcmNoUGxhY2Vob2xkZXIiLCJpbmZvIiwicGFnaW5hdGUiLCJmaXJzdCIsInByZXZpb3VzIiwibmV4dCIsImxhc3QiLCJEYXRhVGFibGUiLCJCdXR0b25zIiwiZG9tIiwiYnV0dG9uIiwiY2xhc3NOYW1lIiwic3BhbiIsInBhZ2VMZW5ndGgiLCJhdXRvV2lkdGgiLCJidXR0b25zIiwidGV4dCIsInBkZk9yaWVudGF0aW9uIiwicGFnaW5nVHlwZSIsInNlYXJjaGluZyIsImluaXREYXRhVGFibGVzIiwiRGFzaG1peCIsIm9uTG9hZCIsImluaXQiXSwic291cmNlUm9vdCI6IiJ9