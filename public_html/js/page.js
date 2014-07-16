function page(name) {
    window.scrollTo(0, 0);
	$("#wrap").load("/router.php?url=" + name);

   	var stateObject = {};
	var title = "Owl of Code";
	var newUrl = "/" + name;

	history.pushState(stateObject,title,newUrl);
}

function reloadToHome() {
	var url = document.location.origin;
	window.location.href=url; 
}

$(document).on({
    ajaxStart: function() { 
    	$("body").addClass("loading"); 
    },
    ajaxStop: function() { 
    	$("body").removeClass("loading"); 
        $('#wrap').effect( "slide" ); 
    }    
});