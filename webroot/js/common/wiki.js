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

$(".accordion-handle").click(function(){
	let accordion_id = "#" + $(this).attr("rel");
	if($(accordion_id).hasClass("hidden")){
		$("#accordion ul:visible").slideUp("normal").addClass("hidden");
		$(accordion_id).slideDown().removeClass("hidden");
		$(accordion_id + "-icon").removeClass("icon-chevron-right").addClass("icon-chevron-down");
	} else {
		$(accordion_id).slideUp().addClass("hidden");
		$(accordion_id + "-icon").removeClass("icon-chevron-down").addClass("icon-chevron-right");
	}
	return false;
});