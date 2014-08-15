<div class='main'>

    <section>
        <div class='content'>
            <form class="config" id="config_form" action='javascript:updateConfig();' method='post'>

                <p>Nome de Utilizador</p>
                <label>
                    <input type='text' name='user' value='<?php echo $this->info['cfg_user']; ?>' readonly>
                </label>

                <p>Cor do Perfil</p>

                <input type="radio" name="color" <?php echo ($this->info['color'] === 'blue') ? 'checked="checked"' : '' ; ?> value="1">Azul<br>

                <input type="radio" name="color" <?php echo ($this->info['color'] === 'orange') ? 'checked="checked"' : '' ; ?> value="4">Cor de Laranja<br>

                <input type="radio" name="color" <?php echo ($this->info['color'] === 'green') ? 'checked="checked"' : '' ; ?> value="2">Verde<br>

                <input type="radio" name="color" <?php echo ($this->info['color'] === 'red') ? 'checked="checked"' : '' ; ?> value="3">Vermelho

                <p>Sobre mim</p>
                <label>
                    <textarea name="bio"><?php echo $this->info['cfg_bio']; ?></textarea>
                </label>

                <input class='submit' type='submit'>

            </form>

        </div>
    </section>

</div>