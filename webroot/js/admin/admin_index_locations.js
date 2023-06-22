import './admin_common';
import '../jquery/jquery.jeditable.mini';
import {locations_crm_searches} from './search_toggle';

locations_crm_searches();

$(".inline_ajax").editable("/admin/utils/inlineajax", { 
      indicator : "<img src=\'/img/ajax-loader.gif\'>",
      tooltip   : "Click to edit...",
      style  : "inherit"
});