<div class="main blue">
    <section class='session_form'>
        <div class='content'>
            <h1>Login</h1>
            <span class="logo"></span>

            <div id="advice">
                <!-- AVISO -->
            </div>

            <form method='post' id="login_form" class='session' action='javascript:login();'>
                <p>Utilizador</p>
                <input class='text' type='text' name='user' maxlength='50' />

                <p>Password</p>
                <input class='text' type='password' name='pass' maxlength='50' />
                <p><input type="checkbox" name="remember" value="yes">Lembrar-me</p>

                <input id='submit' type='submit' value='Entrar' />

                <p>Ainda não te inscreveste? Inscreve-te <a onclick="page('user/register');">aqui</a>!</p>

            </form>
        </div>
    </section>
</div>

<script>

    if (typeof options != 'undefined' && options.needLogin == true) {
        $('#advice').html("<p class='advice back_orange'>Inicia sessão primeiro :)</p>").effect('shake');
    }

</script>