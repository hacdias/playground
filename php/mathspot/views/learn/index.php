<link rel='stylesheet' href='<?php echo URL; ?>public/css/learn.css' type='text/css' media='all' />
<script src="<?php echo URL; ?>public/js/learn.js?v=<?php echo $this->_jsHash; ?>"></script>

<style>
    #header {position: relative;}
</style>

<div id="classroom"  class="full-size">

    <div id="wall">

        <div class="ghost"></div>

        <div class="container">

            <img class="pi" src="/public/imgs/learn/teacher.svg"/>

            <div class="fifteen-height">

                <ul id="clock">
                    <li id="sec"></li>
                    <li id="hour"></li>
                    <li id="min"></li>
                </ul>

            </div>

            <div class="sixty-height text-center">

                <div class="ghost"></div>
                <div class="blackboard">

                    <p id="talkNo"  class="talk-no">Ok! Então até á próxima!</p>
                    <p id="talk-0">Olá o meu nome é Professor Pi!</p>
                    <p id="talk-1">Estamos aqui para aprender um pouco de matemática!</p>
                    <p id="talk-2" class="talk-choice">Estás pronto?</p>

                    <!-- MATH INTRO -->
                    <p id="talk-3">Ok! Antes de mais, o que é Matemática?</p>
                    <p id="talk-4">Matemática é a ciência que estuda a lógica do universo, e de todos os seus
                        componentes.</p>

                    <p id="talk-5">A Matemática sempre teve presente na vida do Homem, desde as tradicionais contas de de
                        somar ou subtrair...</p>
                    <p id="talk-6">...até à atualidade! Onde a Matemática está em todo o lado!</p>
                    <p id="talk-7">Se quiseres aprender mais sobre o que é matemática consulta a <strong>Wikipédia!</strong></p>



                    <div class="choice-no">
                        Não
                    </div>

                    <div class="choice-yes">
                        Estou!
                    </div>

                </div>

            </div>

            <div class="twenty-five-height text-center design-material">

                <img src="/public/imgs/learn/set-square.svg" height="65%">
                <img src="/public/imgs/learn/set-square.svg" height="65%">
                <img src="/public/imgs/learn/set-square.svg" height="65%">

            </div>

        </div>

    </div>


    <div class="bottom">
        <canvas class="footer"></canvas>
        <canvas class="floor"></canvas>
    </div>


</div>