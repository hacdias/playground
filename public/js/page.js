var url = '335cb4f6.ngrok.io';

if (window.location.host != url) {
  window.location.replace('http://' + url + window.location.pathname);
}

var failMessage = 'Não conseguimos concluir o seu pedido!';;

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

    var url = "/" + name;

    history.pushState({ path: url },'',url);

    $("#wrap").load("/index.php?load=main&url=" + name);

    return false;
}

$(window).bind('popstate', function(event) {
    var state = event.originalEvent.state;

    var remove = window.location.protocol + '//' + window.location.host + '/';
    var path = state.path.replace(remove, '');

    if (path[0] == '/') {
        path = path.substring(1);
    }

    if (state) {
        $('#wrap').load("/index.php?load=main&url=" + path);
    }
});

history.replaceState({ path: window.location.href }, '');

function actionFavLater(id, thing, action) {

    data = 'id=' + id + '&user=' +  user.user;

    if (thing == 'fav' || thing == 'later') {

        if (thing == 'fav') {
            url = '/index.php?load=main&url=action/' + action + 'Fav';
            list = 'Favoritos';
        } else if (thing == 'later') {
            url = '/index.php?load=main&url=action/' + action + 'Later';
            list = 'Ler Mais Tarde';
        }

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json'
        }).done(function(response) {

            if(response.status == 0) {

                var animRight = "-moz-animation: rotateRight 1s ease;-webkit-animation: rotateRight 1s ease;-ms-animation: rotateRight 1s ease;-o-animation: rotateRight 1s ease; animation: rotateRight 1s ease;";

                var animLeft = "-moz-animation: rotateLeft 1s ease;-webkit-animation: rotateLeft 1s ease;-ms-animation: rotateLeft 1s ease;-o-animation: rotateLeft  1s ease;animation: rotateLeft 1s ease;";

                if (action == 'rem') {

                    if (thing == 'later') {

                        $('#later-' + id + ' button').attr({'class': 'user_actions addLater',
                                            'onclick': 'javascript:actionFavLater(' + id + ',' + "'later'" + ',' + "'add'" + ");",
                                            'style' : animLeft});

                    } else if (thing == 'fav') {

                        $('#fav-' + id + ' button').attr({'class': 'user_actions addFav',
                                            'onclick': 'javascript:actionFavLater(' + id + ',' + "'fav'" + ',' + "'add'" + ");",
                                            'style' : animLeft});
                    }

                    removeAnimation(id);

                } else if (action == 'add') {

                    if (thing == 'later') {

                        $('#later-' + id + ' button').attr({'class': 'user_actions remLater',
                                            'onclick': 'javascript:actionFavLater(' + id + ',' + "'later'" + ',' + "'rem'" + ");",
                                            'style' : animRight});

                    } else if (thing == 'fav') {

                        $('#fav-' + id + ' button').attr({'class': 'user_actions remFav',
                                            'onclick': 'javascript:actionFavLater(' + id + ',' + "'fav'" + ',' + "'rem'" + ");",
                                            'style' : animRight});
                    }

                }

                id = null;
                thing = null;
                action = null;

            } else if (response.status == 2) {

                alert('Já tem esse item na lista!');
                list = null;

            } else {

                alert(failMessage);
                list = null;
                console.log('Error code given by PHP: ' + response.status);

            }

        }).fail(function(xhr, desc, err) {
            alert(failMessage);

            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);

        });

    } else {

        alert(failMessage);
        console.log('Error 1.');

    }

    data = null;
    url = null;
    return false;
}

function removeAnimation(id) {
    var path = window.location.pathname;

    if (path.indexOf('favorites') > -1 || path.indexOf('readlater') > -1) {

        $('#item-' + id).fadeTo('fast', 0);
        setTimeout(function() {
            $('#item-' + id).hide(400, function() {
                this.remove();
            });
        }, 600);
    }

    path = null;
}

function login() {
    data = $('#login_form').serialize();

    $.ajax({
        type: 'POST',
        url: '/index.php?load=main&url=action/login',
        data: data,
        dataType: 'json'
    }).done(function(response) {

        switch (response.status) {

            case 0:
                $('#sidebar').load('/index.php?load=main&url=sidebar');
                page('');
                break;

            case 7:
                $('#advice').html("<p class='advice'>Não inseriu todos os dados!</p>").effect( "shake");
                break;

            case 8:
                $('#advice').html("<p class='advice'>Utilizador ou password errados!</p>").effect( "shake");
                break;

            default:
                $('#advice').html("<p class='advice'>" + failMessage + "</p>").effect( "shake");
                console.log('Error code given by PHP: ' + response.status);
                break;
        }

    }).fail(function(xhr, desc, err) {
        alert(failMessage);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;

}

function logout() {

    $.ajax({
        url: '/index.php?load=main&url=action/logout',
        dataType: 'json'
    }).done(function(response) {

        if(response.status == 0) {
            $('#sidebar').load('/index.php?load=main&url=sidebar');
            page('');
        }

    }).fail(function(xhr, desc, err) {
        alert(failMessage);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

}

function registration() {
    data = $('#register_form').serialize();

    $.ajax({
        type: 'POST',
        url: '/index.php?load=main&url=action/register',
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

            case 2:
                $('#advice').html("<p class='advice'>Nome de utilizador já existente!</p>").effect("shake");
                break;

            case 7:
                $('#advice').html("<p class='advice'>Não inseriu todos os dados!</p>").effect("shake");
                break;

            default:
                break;
        }

    }).fail(function(xhr, desc, err) {
        alert(failMessage);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;

}

function updateConfig() {
    data = $('#config_form').serialize();

    $.ajax({
        type: 'POST',
        url: '/index.php?load=main&url=action/update_conf',
        data: data,
        dataType: 'json'
    }).done(function(response) {

        switch (response.status) {

            case 0:
                $('#sidebar').load('/index.php?load=main&url=sidebar');
                page('user/profile/' + user.user);
                break;

            default:
                alert(failMessage);
                console.log('Error:' + response.status);
                break;

        }

    }).fail(function(xhr, desc, err) {
        alert(failMessage);

        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
    });

    data = null;
}
