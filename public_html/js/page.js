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

function addFav(id) {
    data = 'url=action/addFav&id=' + id + '&user=' +  session.user_user;

    $.ajax({
        type: 'GET',
        url: '/router.php',
        data: data,
        success: function() {
            alert('Favorito Adicionado!');
        }
    });

    data = null;

    return false;
}