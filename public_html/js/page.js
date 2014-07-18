function page(name) {
    window.scrollTo(0, 0);

    var stateObject = {};
    var title = "MathPocket";
    var newUrl = "/" + name;

    history.pushState(stateObject,title,newUrl);

    $("#wrap").load("/router.php?url=" + name +'&?_ajax=1');
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