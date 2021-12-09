
 
 
$(document).ready(function(e) { 

$(".numbersOnly").keypress(function(e){
	var charCode = (e.which) ? e.which : e.keyCode;
	var value = $(this).val();
	var res = value.substr(-1,1);
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	{
		e.preventDefault();
	}
});



 $("body").on("click", ".db_tickets_addLink", function (e) {
        $(".add_link_popup .error_text").remove();
        $(".add_link_popup .formField input, .add_link_popup .formField textarea").removeClass("error_stroke");
        $(".add_link_popup").show();
        $("html, body").addClass("hidden");
    });
 
 
 $(".popup_close, .popup_overlay, .cancelBtn, .popup_mob_close").click(function() {
	$(".all_popup").hide();
	$("html, body").removeClass("popup_hidden");
});
 
 
 
 /***************************/
 
	   var menuIcon_status = 1 ;
	   $("body").on("click",".menuIcon",function(e){
			if(menuIcon_status == 1){
				$(".header_right").addClass("open_menu");
				$(".menuIcon").addClass("open");
				$("html, body").addClass("opne_mobile_menu");
				$(".menu ul li.hasDropdown, .hasDropdown_link").removeClass("active"); 
				menuIcon_status = 0;
			}else{
				$(".header_right").removeClass("open_menu");
				$(".menuIcon").removeClass("open");
				$("html, body").removeClass("opne_mobile_menu");
				menuIcon_status = 1; 
			}
			// e.stopPropagation();
		});
	
 
		
 $("body").click(function (e) {
        if (!$(e.target).is('.left_menu, .left_menu *, .menuIcon , .menuIcon *')) {
            $(".header_right").removeClass("open_menu");
				$(".menuIcon").removeClass("open");
				$("html, body").removeClass("opne_mobile_menu");
				menuIcon_status = 1; 
        }
    });
 
 
	$("body").on("click",".selectbox_span",function(e){
		 e.stopPropagation();
 		 $('.selectbox').removeClass("focus");
		 $(this).parent().addClass("focus");
		 $('.selectbox_dropdown').hide();
 		 $(this).parent().find('.selectbox_dropdown').show();
 	});
	
	
	$("body").on("click",".ce_dropdown_search_field",function(e){
		e.stopPropagation();
	});
		
		
  	$("body").on('click', function() {
 	  $('.selectbox_dropdown').hide();
	  $('.selectbox').removeClass("focus");
	});
	
	$("body").on("click",".selectbox_dropdown li",function(){
		if($(this).hasClass("not_click"))
		{
			return false;
		}
        var optionHtml = $(this).html();
		 $(this).closest(".selectbox").addClass("selected");
		$(this).closest(".selectbox").find(".active").removeClass("active");
		$(this).addClass("active");
 		$(this).closest(".selectbox").find("span").html(optionHtml);
		$('.selectbox').removeClass("focus");
 	});
	
	$(".selectbox select").change(function() {
		$('.selectbox').removeClass("focus");
         var slctVal = $(this).find(":selected").text();
		 $(this).parent().find("span").text(slctVal);
		 $(this).closest(".selectbox").addClass("selected");
     });
	
	$(".selectbox select").focusin(function() {
         $('.selectbox').removeClass("focus");
		 $(this).parent().addClass("focus");
     });
	$(".selectbox select").focusout(function() {
         $('.selectbox').removeClass("focus");
     });
	 
	 
	 
	 
	  
 $("body").on("click",".confirmField_show_pw",function(e){
	if($(this).hasClass("active")){
		 $(this).removeClass("active");
		 $(this).parent().find("input").prop("type", "password");
		 $(this).parent().find("input").prop("type", "password");
	}else{
		$(this).addClass("active");
		 $(this).parent().find("input").prop("type", "text");
		 $(this).parent().find("input").prop("type", "text");
	}
});

 
	$("body").on("keypress",".login_form_field input, .form_field input",function(e){
	 var $This = $(this);
	 setTimeout (function(){
		 var len = $($This).val().length;
		 if (e.keyCode == 8 || e.keyCode == 46) {
			 len = $($This).val().length;
		 }
		if($.trim(len) <= 0){
			$($This).parent().find(".confirmField_show_pw").hide();
		}else{
			$($This).parent().find(".confirmField_show_pw").show();
		}
	  },100);
});
   $("body").on("keyup",".login_form_field input, .form_field input",function(e){
	 var $This = $(this);
	   //console.log($($This).val().length);
	 setTimeout (function(){
		 var len = $($This).val().length;
		 if (e.keyCode == 8 || e.keyCode == 46) {
			 len = $($This).val().length;
			if($.trim(len) <= 0){
				$($This).parent().find(".confirmField_show_pw").hide();
			}else{
				$($This).parent().find(".confirmField_show_pw").show();
			}
		}
	  },100);
});

  
  $("body").on("change",".login_form_field input, .form_field input",function(e){
	  var $this = $(this);
	  setTimeout (function(){
		 $($this).parent().removeClass("isFocus");
		var fieldVal = $($this).val().length;
		if(fieldVal > 0){
			$($this).parent().addClass("isValue");
		}else{
			$($this).parent().removeClass("isValue");	
		}
	  },100);
	}); 
	
	
	$(".otp_field").keyup( function(e) {
		var otpVal = $(this).val().length;
	   if(otpVal >= 1){
		   $(this).parent().next("li").find("input").focus();
		   $(this).addClass("active");
		}else{
			$(this).parent().prev("li").find("input").focus();
			$(this).removeClass("active");
		}
		e.stopPropagation();
	});
 	
	
	
	/***********nav notification click*****/
   $("body").on("click", ".header_notify_bell", function (e) {
        if ($(this).parent().hasClass("active")) {
            $(this).parent().removeClass("active");
            //$("body, html").removeClass("hidden");
            $(".notify_popup_show").hide();
        } else {
            $(this).parent().addClass("active");
            // $("body, html").addClass("hidden");
            $(".notify_popup_show").show();
        }
    });


	$("body").click(function (e) {
		if (!$(e.target).is('.notify_popup, .header_notify *, .notify_popup *')) {
			$(".header_notify").removeClass("active");
			$(".notify_popup_show").hide();
		}
	});
	
	$("body").on("click", ".deal_sort_btn", function (e) {
		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$("body, html").removeClass("hidden");
			$(".side_sort_popup").removeClass("active");
		} else {
			$(this).addClass("active");
			$("body, html").addClass("hidden");
			$(".side_sort_popup").addClass("active");
		}
	}); 
	
	$("body").on("click", ".deal_filter_btn", function (e) {
		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$("body, html").removeClass("hidden");
			$(".side_filter_popup").removeClass("active");
		} else {
			$(this).addClass("active");
			$("body, html").addClass("hidden");
			$(".side_filter_popup").addClass("active");
		}
	}); 
	
	$("body").click(function (e) {
		if (!$(e.target).is('.deal_sort_btn, .deal_sort_btn *, .side_popup_whitebox *, .deal_filter_btn')) {
			$(".deal_sort_btn, .deal_filter_btn").removeClass("active");
			$(".side_popup").removeClass("active");
			$("body, html").removeClass("hidden");
		}
	});
	$("body").on("click", ".side_popup_back_arrow", function () { 
		$(".deal_sort_btn, .deal_filter_btn").removeClass("active");
		$(".side_popup").removeClass("active");
		$("body, html").removeClass("hidden");
	});
	$("body").on("click", ".pick_service_check", function () { 
	      $(this).closest("ul").find(".pick_service_box").removeClass("active");
		 $(this).closest(".pick_service_box").addClass("active");
	});
	
	
	$("body").on("click", ".itemPromo_enable_switch_check", function () { 
	    if($(this).prop("checked") === true){
		    $(this).closest(".itemPromo_enable_switch").addClass("active");
		}else{
		    $(this).closest(".itemPromo_enable_switch").removeClass("active");
	    }
	});
	
	$("body").on("click", ".header_settings", function () { 
		$(".settings_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
	$("body").on("click", ".lang_check", function () { 
	      $(this).closest("ul").find(".pick_service_box").removeClass("active");
		 $(this).closest(".pick_service_box").addClass("active");
	});
	
 
    $("body").on("click", ".settings_pop_changeLang", function () { 
		 $(".settings_popup").hide();
		$(".language_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
 
		$("body").on("click", ".settings_pop_deleteAc", function () { 
		 $(".settings_popup").hide();
		$(".delete_account_confirmation_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
 
	$("body").on("click", ".accountDeleteBtn", function () { 
		$(".delete_account_confirmation_popup").hide();
		$(".account_deleted_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
 
	$("body").on("click", ".profileInfo_blocked", function () { 
		$(".block_user_confirmation_popup").show();
		$("html, body").addClass("popup_hidden");
	});
 
	$("body").on("click", ".blockUserBtn", function () { 
		$(".block_user_confirmation_popup").hide();
		$(".user_blocked_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
	
 
	$("body").on("click", ".profileInfo_star", function () { 
		$(".rate_user_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
 
	$("body").on("click", ".rateUserPopupBtn", function () { 
		$(".rate_user_popup").hide();
		$(".reviewReceived_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
	$("body").on("click", ".product_specs_newBid_link", function () { 
		$(".createNew_bid_popup").show();
		$("html, body").addClass("popup_hidden");
		$(".bid_priceField input").val("");
		$(".bid_priceField input").removeClass("isValue");
		
	});
    $("body").on("click", ".product_share_link", function () { 
		$(".product_share_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
	
    $("body").on("click", ".cardSaved_check input", function () { 
	    if($(this).prop("checked") === true){
		    $(this).closest(".cardSaved_check").addClass("checked");
		}else{
		    $(this).closest(".cardSaved_check").removeClass("checked");
	    }
	});
	
	$("body").on("click", ".balance_add_btn", function () { 
		$(".balance_add_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	$("body").on("click", ".saved_creatNewCard_btn", function () { 
		$(".balance_add_popup").hide();
		$(".balance_newCard_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	$("body").on("click", ".cardAdd_btn", function () { 
		$(".balance_newCard_popup").hide();
		$(".balance_newCard_added_popup").show();
		$("html, body").addClass("popup_hidden");
	});
	
	
	    $("body").on("click", ".chat_emoji_link", function (e) {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(".chat_emoji_dropdown").hide();
        } else {
            $(this).addClass("active");
            $(".chat_emoji_dropdown").show();
        }
    });


    $("body").click(function (e) {
        if (!$(e.target).is('.chat_emoji_dropdown, .chat_emoji_dropdown *, .chat_emoji_link, .chat_emoji_link *')) {
            $(".chat_emoji_link").removeClass("active");
            $(".chat_emoji_dropdown").hide();
        }
    });
	
	
	
	$("body").on("click", ".header_searchMob_icon", function (e) {
		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(".header_search").removeClass("active");
		} else {
			$(this).addClass("active");
			$(".header_search").addClass("active");
		}
	}); 
	
	$("body").click(function (e) {
		if (!$(e.target).is('.header_searchMob_icon, .header_searchMob_icon *, .header_search *, .header_search')) {
			$(".header_search").removeClass("active");
			$(".header_searchMob_icon").removeClass("active");
		}
	});
	
	
	 $("body").on("click",".chat_menu_icon",function(e){
		if(menuIcon_status == 1){
			$(".chat_left").addClass("open_chat");
			menuIcon_status = 0;
		}else{
			$(".chat_left").removeClass("open_chat");
			menuIcon_status = 1;
		}
		e.stopPropagation();
	});

	$("body").on("click",".chat_menu_close",function(e){
		$(".chat_left").removeClass("open_chat");
		menuIcon_status = 1;
	});
 
	
 

 //end ready
 });
 
 
 
 
 $(window).scroll(function(){
	//var sticky = $('.header, .wrapper')
	//scroll = $(window).scrollTop();
	//if (scroll >= 42){
		//sticky.addClass('fixed');
			//setTimeout(function(){
			//sticky.addClass('animate'); 			   
		//},100)
	//}else {
		//sticky.removeClass('fixed animate');
//	}
	
 	
 });

 

 
 
 

 