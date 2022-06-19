/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = require("jquery");
global.$ = global.jQuery = $;

//import "./bootstrap";
//import "./styles/customer/_js/main/app";
import "./styles/customer/customer.scss";
// any CSS you import will output into a single css file (app.css in this case)
import "./styles/customer/js/dashmix.app.min.js";
//import "./styles/customer/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker";
//import "./styles/customer/js/plugins/flatpickr/flatpickr";
//import fr from "./styles/customer/js/plugins/flatpickr/l10n/fr";
import "./styles/customer/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js";
import "./styles/customer/js/plugins/bootstrap-notify/bootstrap-notify";
//import "./styles/customer/js/plugins/chart.js/chart";
import "./styles/customer/js/plugins/jquery-validation/jquery.validate";
//import "./styles/customer/js/plugins/select2/js/select2.full";
import "./styles/customer/js/plugins/bootstrap-maxlength/bootstrap-maxlength";
import "./styles/customer/js/plugins/slick-carousel/slick";
import "./styles/customer/js/pages/op_auth_reminder.min";
import "./styles/customer/_js/pages/op_auth_signin";

Dashmix.helpersOnLoad([
  "jq-datepicker",
  "js-flatpickr",
  "jq-maxlength",
  "jq-masked-inputs",
  "jq-pw-strength",
  "jq-notify",
  "jq-select2",
  "js-slick",
]);

jQuery(".js-masked-phone").mask("9999999999");
