/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = require("jquery");
global.$ = global.jQuery = $;

import "./bootstrap";
import "./styles/admin/admin.scss";
// any CSS you import will output into a single css file (app.css in this case)
import "./styles/admin/js/dashmix.app.min.js";
//import "./styles/admin/_js/main/app";
import "./styles/admin/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js";
import "./styles/admin/js/plugins/flatpickr/flatpickr";
import fr from "./styles/customer/js/plugins/flatpickr/l10n/fr";
import "./styles/admin/js/plugins/bootstrap-notify/bootstrap-notify";
//import "./styles/admin/js/plugins/chart.js/chart";
import "./styles/admin/js/plugins/jquery-validation/jquery.validate";
//import "./styles/admin/js/plugins/select2/js/select2.full.min";
import "./styles/admin/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker";
import "./styles/admin/js/pages/op_auth_reminder.min";
import "./styles/admin/_js/pages/op_auth_signin";

Dashmix.helpersOnLoad([
  "jq-colorpicker",
  "jq-masked-inputs",
  "jq-validation",
  "jq-notify",
  "js-flatpickr",
]);

jQuery(".js-masked-phone").mask("9999999999");
