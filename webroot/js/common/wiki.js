import './common';
import './responsive_slider';

$("table").each(function(index) {
	$(this).addClass("mobile_table");
	$("table.mobile_table span").removeAttr("style");
});

//Open social media links in small window
$(".btn-share").on("click",function(){
	window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");
	return false;
})

//Add noprint class to all wistia videos in help pages
var wistiaEmbed = $(".wistia_embed");
for(var i=0;i<wistiaEmbed.length;i++){
	wistiaEmbed.eq(i).addClass("noprint");
}
