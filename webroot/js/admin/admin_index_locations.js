import '../common/common';
import '../jquery/jquery.jeditable.mini';
import './search_toggle';

$(".inline_ajax").editable("/admin/utils/inlineajax", { 
      indicator : "<img src=\'/img/ajax-loader.gif\'>",
      tooltip   : "Click to edit...",
      style  : "inherit"
});