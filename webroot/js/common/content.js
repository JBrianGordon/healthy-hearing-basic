import './common';
import './responsive_slider';

jQuery ('#content_body img').each(function() {
	var index;
	var src = $(this).attr('src');
	var index = src.indexOf('/files');
	if(index != -1){
		$(this).attr('src', src.substr(index, src.length));
	}
});

//Open social media links in small window
$(".btn-share").on("click",function(){
	window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");
	return false;
})

//Add noprint class to all wistia videos in report pages
var wistiaEmbed = $(".wistia_embed");
for(var i=0;i<wistiaEmbed.length;i++){
	wistiaEmbed.eq(i).addClass("noprint");
}