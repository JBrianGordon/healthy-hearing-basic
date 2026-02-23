import './admin_common';
import '../jquery/jquery.jeditable.mini';

import $ from 'jquery';

//***TODO: replace this old plugin with custom code that does the same thing. editable plugin is no longer maintained */

$(".inline_ajax").editable("/admin/utils/inlineajax", {
      indicator: "<img src=\'/img/ajax-loader.gif\'>",
      tooltip: "Click to edit...",
      style: "inherit"
});