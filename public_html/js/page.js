function page(name) {
    window.scrollTo(0, 0);

    var stateObject = {};
    var title = "MathPocket";
    var newUrl = "/" + name;

    history.pushState(stateObject,title,newUrl);
    $('#wrap').effect( "slide" );
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
    }    
});

function addFavLater(id, thing) {
    data = 'id=' + id + '&user=' +  session.user_user;

    if (thing == 'fav' || thing == 'later') { 

        if (thing == 'fav') {
            url = '/router.php?url=action/addFav';
            list = 'Favoritos';
        } else if (thing == 'later') {
            url = '/router.php?url=action/addLater';
            list = 'Ler Mais Tarde';
        } 

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json'
        }).done(function(response) {
            if(response.status == 0) {
                alert('Item adicionado à lista ' + list);
            } else if (response.status == 2) {
                alert('Já tem esse item na lista!');
            } else {
                alert('Não conseguimos concluir o seu pedido!');
                console.log('Error code given by PHP: ' + response.status);
            }
        }).fail(function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        });

    } else {

        alert('Não conseguimos concluir o seu pedido!');
        console.log('Error 1.');
    }
    

    data = null;
    return false;
}

/*


function addFavLater(id, thing) {
    data = 'id=' + id + '&user=' +  session.user_user;

    if (thing == 'fav' || thing == 'later') { 

        if (thing == 'fav') {
            url = '/router.php?url=action/addFav';
            list = 'Favoritos';
        } else if (thing == 'later') {
            url = '/router.php?url=action/addLater';
            list = 'Ler Mais Tarde';
        } 

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function(response) {

                if(response.status == 0) {
                    alert('Item adicionado à lista ' + list);
                } else if (response.status == 2) {
                    alert('Já tem esse item na lista!');
                } else {
                    alert('Não conseguimos concluir o seu pedido!');
                    console.log('Error code given by PHP: ' + response.status);
                }
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });

    } else {

        alert('Não conseguimos concluir o seu pedido!');
        console.log('Error 1.');
    }
    

    data = null;
    return false;
}

*/