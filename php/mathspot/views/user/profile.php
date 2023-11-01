<?php global $person; ?>

<div class='main profile <?php echo $this->info['color']; ?>'>
    <section class='color_section'>
        <div class='content'>
            <div class="username">

                <?php if ($person->loggedIn() && $_SESSION['user_user'] === $this->info['user']) :?>

                    <a onclick="page('user/config');"><img src="/public/imgs/icons/config.png" class="config"></a>

                <?php endif; ?>

                <p><?php echo $this->info['name']; ?></p>
            </div>

            <div class="photo"><img src="/public/imgs/users/<?php echo $this->info['img']; ?>_big.png"></div>
        </div>
    </section>

    <section>
        <div class="content">
            <h2>Sobre Mim</h2>

            <p><?php echo $this->info['bio']; ?></p>

        </div>
    </section>

</div>