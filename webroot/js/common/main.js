import 'jquery-ui/ui/widgets/autocomplete';

$(window).ready(function() {

	$('input.autocomplete').autocomplete({
		source: '/fapautocomplete',
		minLength: 2,
		response: function(event, ui){
			if (ui.content.length == 1) {
				$( 'input.autocomplete' ).autocomplete( "option", "autoFocus", true );
			} else {
				$( 'input.autocomplete' ).autocomplete( "option", "autoFocus", false );
			}
		},
		select: function(event, ui){
			if (ui.item.id) {
				$(this).siblings('.auto-id').val(ui.item.id);
			}

			$(this).parents('form').trigger("submit");
		}
	});
	

	//Custom jQuery to restore old menu functionality
	$(document).on("focus", "input.autocomplete", function(){
		var inputCheck = setInterval(function(){
			if($(".ui-menu-item .ui-state-active").length >= 1){
				$(".ui-menu-item.ui-state-focus").removeClass("ui-state-focus");
				$(".ui-menu-item .ui-state-active").removeClass("ui-state-active").parent().addClass("ui-state-focus");
			}
			//Add class if only 1 result
			if($(".ui-menu-item").length === 1){
				$(".ui-menu-item").addClass("ui-state-focus").children().removeClass("ui-state-active");
		    }
		    $("input.autocomplete").on("blur", function(){
			    $("ul.ui-autocomplete").empty();
			    clearInterval(inputCheck);
			});
		},10)
	});

    //Homepage dropdown and slider dropdown use same ul but need to have different styling. Changing id on pages with responsive slider to remedy this
    if($("#hh-sticky-panel").length > 0){
		//change the ID to use a letter to avoid messing up jQuery UI id's
	    $("#ui-id-3").attr("id","ui-id-A");
    }
    //hide FAC dropdown on keyboard hide on Android
    if(/(android)/i.test(navigator.userAgent)){
	    var threeFourthsHeight = $(window).height() * 0.75;
	    $(window).on("resize",function(){
		    if($(window).height() > threeFourthsHeight){
			    $(".ui-menu.ui-autocomplete").hide();
		    }
	    })
    }
    
    //Attach popovers to all elements that need it
    $('[data-toggle="popover"]').popover({html:true});

	//Add protocol to href value if missing
	document.querySelectorAll('.external-link').forEach(link => {
		let url = link.getAttribute('href');
		if (url && !url.startsWith('http://') && !url.startsWith('https://')) {
			link.setAttribute('href', 'https://' + url);
		}
	});

	//Set default scroll position for hash links to clear navbar
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			const hash = this.getAttribute('href');
			const target = document.querySelector(hash);
			if (target) {
				e.preventDefault();
				window.setTimeout(function() {
					const rect = target.getBoundingClientRect();
					window.scrollTo(rect.left, window.scrollY + rect.top - 70);
				}, 0);
			}
		});
	});


});