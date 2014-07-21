$(document).on({
    ajaxStart: function() { 
        $("body").addClass("loading"); 
    },
    ajaxStop: function() { 
        $("body").removeClass("loading");  
    }    
});

function page(name) {
    window.scrollTo(0, 0);

    var stateObject = {};
    var title = "MathPocket";
    var newUrl = "/" + name;

    history.pushState(stateObject,title,newUrl);
    $("#wrap").load("/router.php?url=" + name);
}

function actionFavLater(id, thing, action) {
    failM = 'Não conseguimos concluir o seu pedido!';

    data = 'id=' + id + '&user=' +  user.user;

    if (thing == 'fav' || thing == 'later') { 

        if (thing == 'fav') {
            url = '/router.php?url=action/' + action + 'Fav';
            list = 'Favoritos';
        } else if (thing == 'later') {
            url = '/router.php?url=action/' + action + 'Later';
            list = 'Ler Mais Tarde';
        } 

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json'
        }).done(function(response) {
            if(response.status == 0) {

               switch (thing) {

                    case 'later':
                        if (action == 'rem') {

                            $('#later-' + id).html("<button class='user_actions' id='addLater' onclick=" + 'javascript:actionFavLater(' + id + ',' + "'later'" + ',' + "'add'" + ");" + "><img src='/imgs/icons/plus.svg'></button>");

                        } else if (action == 'add') {

                            $('#later-' + id).html("<button class='user_actions' id='remLater' onclick=" + 'javascript:actionFavLater(' + id + ',' + "'later'" + ',' + "'rem'" + ");" + "><img src='/imgs/icons/minus.svg'></button>");
                        }

                        break;

                    case 'fav':
                        if (action == 'rem') {

                            $('#fav-' + id).html("<button class='user_actions' id='addFav' onclick=" + 'javascript:actionFavLater(' + id + ',' + "'fav'" + ',' + "'add'" + ");" + "><img src='/imgs/icons/star.svg'></button>");

                        } else if (action == 'add') {

                            $('#fav-' + id).html("<button class='user_actions' id='remFav' onclick=" + 'javascript:actionFavLater(' + id + ',' + "'fav'" + ',' + "'rem'" + ");" + "><img src='/imgs/icons/unstar.svg'></button>");
                        }
                        break;

                    default:
                        break;

               }


            } else if (response.status == 2) {
                alert('Já tem esse item na lista!');
                list = null;
            } else {
                alert(failM);
                list = null;
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

        //Melhorar isto utilizando códigos numéricos
        if(response.status == 'needData') {
            $('#advice').html("<p class='advice'>Não inseriu todos os dados!</p>").effect( "shake");
        } else if (response.status == 'wrong') {
            $('#advice').html("<p class='advice'>Utilizador ou password errados!</p>").effect( "shake");
        } else if (response.status == 'correct') {
            $('#sidebar').load('/router.php?url=sidebar');
            page('');
        }  else {
            $('#advice').html("<p class='advice'>" + failM + "</p>").effect( "shake");
            console.log('Error code given by PHP: ' + response.status);
        }
    }).fail(function(xhr, desc, err) {
        alert(failM);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;

}

function registration() {
    failM = 'Não conseguimos concluir o seu pedido!';

    data = $('#register_form').serialize();

    $.ajax({
        type: 'POST',
        url: '/router.php?url=action/register',
        data: data,
        dataType: 'json'
    }).done(function(response) {

        switch (response.status) {
            case 0:
                $('#advice').html("<p class='advice back_green'>Inscrito com sucesso!</p>").effect("slide");
                setTimeout(function() {
                    page('user/login');
                }, 2000);
                break;

            case 1:
                $('#advice').html("<p class='advice'>Nome de utilizador já existente!</p>").effect("shake");
                break;

            case 2:
                $('#advice').html("<p class='advice'>Não inseriu todos os dados!</p>").effect("shake");
                break;

            default:
                break;
        }

    }).fail(function(xhr, desc, err) {
        alert(failM);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;

}

function logout() {

    $.ajax({
        url: '/router.php?url=action/logout',
        dataType: 'json'
    }).done(function(response) {
        if(response.status == 0) {
            $('#sidebar').load('/router.php?url=sidebar');
            page('');
        }
    }).fail(function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

}

function updateConfig() {

    data = $('#config_form').serialize();

    failM = 'Não conseguimos concluir o seu pedido!';

    $.ajax({
        type: 'POST',
        url: '/router.php?url=action/update_conf',
        data: data,
        dataType: 'json'
    }).done(function(response) {

        switch (response.status) {
            case 0:
                $('#sidebar').load('/router.php?url=sidebar');
                page('profile/' + user.user);
                break;

            default:
                break;
        }

    }).fail(function(xhr, desc, err) {
        alert(failM);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;
}