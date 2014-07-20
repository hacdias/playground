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
    failM = 'Não conseguimos concluir o seu pedido!';

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
                alert(failM);
                console.log('Error code given by PHP: ' + response.status);
            }
        }).fail(function(xhr, desc, err) {
            alert(failM);
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        });

    } else {
        alert(failM);
        console.log('Error 1.');
    }
    

    data = null;
    url = null;
    return false;
}

function login() {
    failM = 'Não conseguimos concluir o seu pedido!';

    data = $('#login_form').serialize();

    $.ajax({
        type: 'POST',
        url: '/router.php?url=action/login',
        data: data,
        dataType: 'json'
    }).done(function(response) {
        if(response.status == 'needData') {
            $('#advice').html("<p class='advice'>Não inseriu todos os dados!</p>");
            $('.advice').effect( "shake");
        } else if (response.status == 'wrong') {
            $('#advice').html("<p class='advice'>Utilizador ou password errados!</p>");
            $('.advice').effect( "shake");
        } else if (response.status == 'correct') {
            $('#sidebar').load('/router.php?url=sidebar');
            page('');

        }  else {
            alert(failM);
            console.log('Error code given by PHP: ' + response.status);
        }
    }).fail(function(xhr, desc, err) {
        alert(failM);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;

}