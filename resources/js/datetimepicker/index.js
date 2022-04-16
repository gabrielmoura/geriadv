import * as $ from 'jquery';
import 'jquery-datetimepicker/build/jquery.datetimepicker.full.min.js';
import 'jquery-datetimepicker/build/jquery.datetimepicker.min.css';

export default (function () {

    $.datetimepicker.setLocale('pt-BR');

  $('.date').datetimepicker({
    timepicker:false,
    format:'d/m/Y'
  }).attr('autocomplete', "off");

  $('.date-time').datetimepicker({
    format:'d/m/Y H:i:s'
  }).attr('autocomplete', "off");
}())
