import * as $ from 'jquery';
//import 'datatables'; //Para não Bootstrap
import 'datatables.net-bs4';
//import 'datatables.net'; //Para não Bootstrap
import 'datatables.net-buttons-bs4';
import 'datatables.net-buttons/js/buttons.colVis.js';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-colreorder-bs4';
import 'datatables.net-responsive-bs4';


export default (function () {
    $('#dataTable').DataTable({
        language: {
            'url': 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
            // More languages : http://www.datatables.net/plug-ins/i18n/
        },
        aaSorting: []
    });
}());
import './buttons.server-side';

