import './admin_common';
import '../jquery/jquery.jeditable.mini';

$(".inline_ajax").editable("/admin/utils/inlineajax", { 
      indicator : "<img src=\'/img/ajax-loader.gif\'>",
      tooltip   : "Click to edit...",
      style  : "inherit"
});