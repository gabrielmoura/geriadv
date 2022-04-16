import * as $ from 'jquery';
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';

export default (function () {
    $.datetimepicker.setLocale('pt-BR');
    $('.start-date').datepicker({format: 'd/m/Y'});
    $('.end-date').datepicker({format: 'd/m/Y'});
}())
