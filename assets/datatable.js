/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import "./styles/admin/admin.scss";
// any CSS you import will output into a single css file (app.css in this case)

import "datatables.net";
import "datatables.net-bs5";
import "datatables.net-buttons";
import "datatables.net-buttons-bs5";
import jsZip from "jszip";
window.jsZip = jsZip;
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
//import "datatables.net-buttons/js/buttons.colVis";

import "datatables.net-buttons/js/buttons.print";
import "datatables.net-buttons/js/buttons.html5";
import "./styles/admin/js/datatables/datatable";
