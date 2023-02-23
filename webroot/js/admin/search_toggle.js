import '../jquery/jquery.class.min';
import './datepicker';

var SearchToggle = jQuery.Class.create({
    
  initialize: function(options){
    var defaults = {
      toggle_on_focus: false,
      elem_id: false,
      toggle_id: false,
      toggle_text_id: false,
    };
    this.options = jQuery.extend(true, defaults, options);
    
    this.toggle_on_focus = this.options.toggle_on_focus;
    this.advanced_search = jQuery(this.options.elem_id);
    this.search_toggle = jQuery(this.options.toggle_id);
    if(this.options.toggle_text_id){
      this.search_text = jQuery(this.options.toggle_text_id);
    }
    else {
      this.search_text = jQuery(this.options.toggle_id);
    }
    
    this.search_toggle.on('click', jQuery.proxy(this.toggleSearch, this));
  },
  
  toggleSearch: function(event){
    if(this.advanced_search.is(':visible')){
      this.search_text.html('+');
      jQuery(this.options.elem_id).slideUp();
    } else {
      this.search_text.html('-');
      jQuery(this.options.elem_id).slideDown();
    }
  }

});

//Check for search toggle element on page
if($('#admin_search_toggle').length > 0){
	new SearchToggle({toggle_id: "#admin_search_toggle", elem_id: "#admin_search", toggle_text_id: "#admin_search_text"});
}
if($('#advanced_search_toggle').length > 0){
	new SearchToggle({toggle_id: "#advanced_search_toggle", elem_id: "#advanced_search", toggle_text_id: "#advanced_search_text"});
}
//Reorganize search options and change booleans into a toggle
if($("form").attr("action").match("/admin/locations") || $("form").attr("action").match("/admin/crm-searches")){
	var generalInputs = document.createElement("div"),
		reviewInputs = document.createElement("div"),
		managementInputs = document.createElement("div"),
		upgrades = document.createElement("div"),
		genInputsHeadline = "<div><h3 class='crm-group-header'>General demographics</h3><span class='group-toggle btn btn-primary btn-sm'> Collapse section</span></div>",
		reviewsHeadline = "<div><h3 class='crm-group-header'>Reviews</h3><span class='group-toggle btn btn-primary btn-sm'> Expand section</span></div>",
		changeManagementHeadline = "<div><h3 class='crm-group-header'>Change management</h3><span class='group-toggle btn btn-primary btn-sm'> Expand section</span></div>",
		upgradeHeadline = "<div><h3 class='crm-group-header'>Upgrade Features</h3><span class='group-toggle btn btn-primary btn-sm'> Expand section</span></div>";
		generalInputs.classList.add("filter-group");
		reviewInputs.classList.add("filter-group", "hidden");
		managementInputs.classList.add("filter-group", "hidden");
		upgrades.classList.add("filter-group", "hidden");
		
	//send form groups to proper parent divs
	var arrangeInputs = function(modalToggleField, inputGroup){
		modalToggleField.forEach(function(field){field.closest(".form-group").appendTo(inputGroup)});
	},
	generalFields = [$("#SearchId"), $("#SearchOticonId"), $("#SearchParentId"), $("#SearchSfId"), $("#SearchYhnLocationId"), $("#SearchCqpPracticeId"), $("#SearchCqpOfficeId"), $("#SearchTitle"), $("#SearchSubtitle"), $("#SearchAddress"), $("#SearchAddress2"), $("#SearchCity"), $("#SearchState"), $("#SearchZip"), $("#SearchIsMobile"), $("#SearchPhone"), $("#SearchEmail"), $("#SearchListingType"), $("#SearchPriority"), $("#SearchIsActive"), $("#SearchIsShow"), $("#SearchIsListingTypeFrozen"), $("#SearchOticonTier"), $("#SearchYhnTier"), $("#SearchCqpTier"), $("#SearchListingType"), $("#SearchIsOticon"), $("#SearchIsRetail"), $("#SearchIsYhn"), $("#SearchIsCqp"), $("#SearchIsHh"), $("#SearchIsCqPremier"), $("#SearchIsIrisPlus"), $("#SearchNotes"), $("#SearchFullName"), $("#SearchIsBypassed"), $("#SearchFilterHasPhoto"), $("#SearchFilterInsurance"), $("#SearchIsCallAssist"), $("#SearchTimezone"), $("#SearchHasUrl"), $("#SearchNpiNumber"), $("#SearchLocationSegment"), $("#SearchEntitySegment"), $("#SearchDirectBookType"), $("#SearchFrozenExpirationStart"), $("#SearchIsIdaVerified"), $("#SearchIsServiceAgreementSigned"), $("#SearchCovid19Statement"), $("#SearchIsJunk"), $("#SearchIsEmailAllowed")],
	reviewFields = [$("#SearchReviewsApproved"), $("#SearchReviewStatus"), $("#SearchAverageRating"), $("#SearchLastReviewDateStart")],
	managementFields = [$("#SearchModifiedStart"), $("#SearchLastContactDate"), $("#SearchIsLastEditByOwner"), $("#SearchLastEditByOwnerDate"), $("#SearchCompleteness"), $("#SearchLastNoteStatus"), $("#SearchLastImportStatus"), $("#SearchIsGracePeriod"), $("#SearchGracePeriodEnd"), $("#SearchReviewNeeded"), $("#SearchEmailStatus"), $("#SearchPhoneStatus"), $("#SearchAddressStatus"), $("#SearchTitleStatus"), $("#SearchIsTitleIgnore"), $("#SearchIsAddressIgnore"), $("#SearchIsPhoneIgnore"), $("#SearchIsEmailIgnore")],
	upgradeFields = [$("#SearchFeatureContentLibrary"), $("#SearchFeatureSpecialAnnouncement"), $("#SearchLogoUrl"), $("#SearchBadgeCoffee"), $("#SearchBadgeWifi"), $("#SearchBadgeParking"), $("#SearchBadgeCurbside"), $("#SearchBadgeWheelchair"), $("#SearchBadgeServicePets"), $("#SearchBadgeCochlearImplants"), $("#SearchBadgeAld"), $("#SearchBadgePediatrics"), $("#SearchBadgeMobileClinic"), $("#SearchBadgeFinancing"), $("#SearchBadgeTelehearing"), $("#SearchBadgeAsl"), $("#SearchBadgeTinnitus"), $("#SearchBadgeBalance"), $("#SearchBadgeHome"), $("#SearchBadgeRemote"), $("#SearchBadgeMask"), $("#SearchBadgeSpanish"), $("#SearchBadgeFrench"), $("#SearchBadgeRussian"), $("#SearchBadgeChinese"), $("#SearchUsingLogo"), $("#SearchUsingPhotos"), $("#SearchUsingVideos"), $("#SearchUsingBadges"), $("#SearchUsingFlexSpace"), $("#SearchUsingLinkedLocations")];
		
	arrangeInputs(generalFields, generalInputs);
	arrangeInputs(reviewFields, reviewInputs);
	arrangeInputs(managementFields, managementInputs);
	arrangeInputs(upgradeFields, upgrades);
	$("#admin-search").prepend(generalInputs, reviewInputs, managementInputs, upgrades);
	
	//Remove empty filter groups
	$.each($(".filter-group"), function(){
		if($(this).is(":empty")){
			$(this).remove();	
		}
	})

	// Custom labels
	$("label[for=SearchIsEmailAllowed]").text('Is profile update email allowed');
		
	//Change boolean inputs into switches
	//#SearchIsOticon is a dropdown element, so it needs to be targeted separately from the other text inputs that are getting turned into toggles
	$("#SearchIsOticon").replaceWith("<label class='switch'><input name='data[Search][is_oticon]' class='form-control' id='SearchIsOticon' type='text'><span class='slider'><span class='switch-negative'></span><span class='switch-off'></span><span class='switch-positive'></span></span></label>");
	$(".filter-group input[placeholder='0 [or] 1']").wrap("<label class='switch'></label>").after("<span class='slider'><span class='switch-negative'></span><span class='switch-off'></span><span class='switch-positive'></span></span>");
	//Add value to hidden inputs when sliders are interacted with
	$("label .slider span").on("mouseup",function(){
		var slideClass = $(this).attr("class");
		if(slideClass == "switch-positive"){
			$(this).parentsUntil("label").siblings("input").removeClass("switch-negative").addClass("switch-positive").attr("value", 1);
		} else if(slideClass == "switch-negative"){
			$(this).parentsUntil("label").siblings("input").removeClass("switch-positive").addClass("switch-negative").attr("value", 0);
		} else {
			$(this).parentsUntil("label").siblings("input").removeClass("switch-negative").removeClass("switch-positive").removeAttr("value");
		}
	})
	
	//Load styles when sliders have been used in a previous search
	//TODO: check that this is working. Currently previous search value does not persist on page but in url
	var switchInput = $("label.switch input");
	for(var i=0;i<switchInput.length;i++){
		if(switchInput.eq(i).val() == 1){
			switchInput.eq(i).addClass("switch-positive");
		} else if (switchInput.eq(i).val() != "") {
			switchInput.eq(i).addClass("switch-negative");
		}
	}
	
	//Add headlines to groups
	$(generalInputs).before(genInputsHeadline);
	$(reviewInputs).before(reviewsHeadline);
	$(managementInputs).before(changeManagementHeadline);
	$(upgrades).before(upgradeHeadline);
	
	//Expand/collapse button functionality
	$(".group-toggle").on("click",function(){
		if ($(this).closest("div").next(".filter-group").hasClass("hidden")) {
			$(this).html("<span class='bi-dash-lg'> Collapse section</span>").closest("div").next(".filter-group").removeClass("hidden");
		} else {
			$(this).html("<span class='bi-plus-lg'> Expand section</span>").closest("div").next(".filter-group").addClass("hidden");
		}
	})

}

//export button modal and functionality
$("#exportButton").on("click",function(e) {
	e.preventDefault();
	$("#exportModal").show().addClass("in");
})

$("#exportClose").on("click",function() {
	$("#exportModal").hide().removeClass("in");
})

//Toggle values for switches
$("#exportModal .form-control").on("click", function() {
	if($(this).val(0)) {
		$(this).val(1);
	} else {
		$(this).val(0);
	}
});

//Toggle classes and values for all switches, based on #allFieldsInput active class
$("#allFieldsInput").on("click",function() {
	setTimeout(function(){
		if ($("#allFieldsInput").hasClass("switch-positive")) {
			$(".export-label input").removeClass("switch-negative").addClass("switch-positive").attr("value",1);
		} else if ($("#allFieldsInput").hasClass("switch-negative")) {
			$(".export-label input").removeClass("switch-positive").addClass("switch-negative").attr("value",0);
		}
	}, 200);
})

$("#exportModal #exportSubmit").on("click", function() {
	var searchAndExcludedFieldArray = $("#exportButton").attr("href").split("/admin/locations/crm").pop();
	
	//Construct params for csv. The "field" params represent fields disabled in the export modal
	
	for (var i = 0;i < $("#exportModal .form-control").length; i++) {
		if ($("#exportModal .form-control").eq(i).attr("value") == 0) {
			var excludedFieldName = $("#exportModal .form-control").eq(i).attr("name");
			
			searchAndExcludedFieldArray += ("/field%5B" + excludedFieldName + "%5D:" + excludedFieldName);
		}
	}

	window.location.pathname = "admin/locations/export" + searchAndExcludedFieldArray + ".csv";
})

var minDate = '';
var maxDate = '';
if ($('.datepicker').attr('minDate')) {
	minDate = $('.datepicker').attr('minDate');
}
if ($('.datepicker').attr('maxDate')) {
	maxDate = $('.datepicker').attr('maxDate');
}
$('.datepicker').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: minDate,
	maxDate: maxDate
});
