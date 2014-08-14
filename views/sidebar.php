<?php if (LOAD === 'all') : ?>

<div id="sidebar">

<?php endif; ?>

    <?php
    global $person;

    if ($person->loggedIn() === false ) {

        $userPhoto = 'default';
        $userColor = '';

    } else {

        $userPhoto = Person::getPhoto($_SESSION['user_user']);
        $userUser = $_SESSION['user_user'];
        $userColor = Person::getColor($_SESSION['user_user'], true);
        $userName =  $_SESSION['user_name'];
    }

    ?>

    <input id='menu-checkbox' type='checkbox'>

    <nav id='menu'>

        <div class='user' style="background: <?php echo $userColor; ?>;" >
            <div class='user_photo' style="background-image: url(/public/imgs/users/<?php echo $userPhoto; ?>_small.png);"></div>

            <div class='user_name'>

                <?php if ($person->loggedIn() === false ) : ?>
                <p>Inicie Sessão</p>
                <?php else: ?>
                <p><?php echo $userName; ?></p>
                <?php endif; ?>

            </div>

        </div>



        <label for='menu-checkbox'>

            <ul class="menu_items">

                <?php if (!$person->loggedIn() === false ) : ?>

                <a onClick="page('user/profile/<?php echo $_SESSION['user_user']; ?>')"><li><img src='/public/imgs/icons/profile.png'><p>Perfil</p></li></a>
                <a onClick="page('dictionary/favorites')"><li><img src='/public/imgs/icons/fav.png'><p>Favoritos</p></li></a>
                <a onClick="page('dictionary/readlater')"><li><img src='/public/imgs/icons/later.png'><p>Ler +Tarde</p></li></a>

                <div class='separator'></div>

                <?php endif; ?>

                <a onClick="page('')"><li><img src='/public/imgs/icons/home.png'><p>Home</p></li></a>
                <a onClick="page('dictionary')"><li><img src='/public/imgs/icons/info.png'><p>Dicionário</p></li></a>
                <a onClick="page('questions')"><li><img src='/public/imgs/icons/qa.png'><p>Perguntas e Respostas</p></li></a>

            </ul>

        </label>

        <?php if ($person->loggedIn() === false ) : ?>
        <label for='menu-checkbox'>

            <ul class="menu_items">
                <a onClick="page('user/login');"><li class="login_button"><img src='/public/imgs/icons/login.png'><p>Login</p></li></a>
            </ul>

        </label>

        <?php else: ?>

        <label for='menu-checkbox'>

            <ul class="menu_items">
                <a onClick="logout();"><li class="login_button"><img src='/public/imgs/icons/exit.png'><p>Logout</p></li></a>
            </ul>

        </label>

        <?php endif; ?>

    </nav>

    <label for='menu-checkbox' id='overlay'></label>

<?php if (LOAD === 'all') : ?>

</div>
</body>
</html>

<?php endif; ?>