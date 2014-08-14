<div class='main blue'>
    <div class='content'>

        <?php foreach ($this->info['items'] as $item) : ?>

        <article class="items" id="item-<?php echo $item['id']; ?>">

            <header>
                <h2><a onclick="page('dictionary/item/<?php echo $item['u_title']; ?>');">
                        <?php echo $item['title']; ?>
                </a></h2>
            </header>

            <div class="description">
                <?php echo $item['description']; ?>
            </div>

            <footer>
                <img src="/public/imgs/icons/category.png">
                <a onclick="page('dictionary/cat/<?php echo $item['u_category']; ?>');"><?php echo $item['category']; ?></a>

                <?php

                global $person;

                if ($person->loggedIn()) : ?>


                    <?php if(!\Model\Dictionary::isInList($item['id'], $_SESSION['user_user'], 'favs')) : ?>

                    <span id="fav-<?php echo $item['id']; ?>">
                        <button class="user_actions addFav" onclick="actionFavLater(<?php echo $item['id']; ?>, 'fav', 'add');"><span></span></button>
                    </span>

                    <?php else: ?>

                    <span id="fav-<?php echo $item['id']; ?>">
                        <button class="user_actions remFav" onclick="actionFavLater(<?php echo $item['id']; ?>, 'fav', 'rem');"><span></span></button>
                    </span>

                    <?php endif; ?>
                    <?php if(!\Model\Dictionary::isInList($item['id'], $_SESSION['user_user'], 'later')) : ?>

                    <span id="later-<?php echo $item['id']; ?>">
                        <button class="user_actions addLater" onclick="actionFavLater(<?php echo $item['id']; ?>, 'later', 'add');"><span></span></button>
                    </span>

                    <?php else: ?>

                    <span id="later-<?php echo $item['id']; ?>">
                        <button class="user_actions remLater" onclick="actionFavLater(<?php echo $item['id']; ?>, 'later', 'rem');"><span></span></button>
                    </span>

                    <?php endif; ?>


                <?php endif;  ?>

            </footer>

        </article>

        <?php endforeach; ?>

        <?php if ($this->info['page'] > 1) : ?>
            <button onclick="page('<?php echo $this->info['url'] . ($this->info['page'] - 1); ?>');">Anterior</button>
        <?php endif; ?>

        <?php  if ($this->info['page'] < $this->info['max_pages'] && $this->info['page'] != 0) : ?>
            <button onclick="page('<?php echo $this->info['url'] . ($this->info['page'] + 1); ?>');">Próxima</button>
        <?php endif; ?>

    </div>
</div>