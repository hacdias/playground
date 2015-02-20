<?php

/* Declaração de algumas constantes:
 *      ROOT -> O caminho onde está o ficheiro atual.
 *      LIBS -> O caminho onde estão os ficheiros de terceiros.
 *      POSTS -> A pasta onde estão guardados os ficheiros dos POSTS
 *      URL -> O Url principal da aplicação
 *
 *      POSTS_POR_PAG -> O número de POSTS por Página
 */
define('ROOT', dirname(__file__) . '/');
define('LIBS', ROOT . 'libs/');
define('POSTS', ROOT . 'posts/');
define('URL', 'http://postssys.dev/');

define('POSTS_POR_PAG', 10);

require LIBS . 'Parsedown.php';

/**
 * Nesta função são obtidos os parâmetros passados pelo o URL,
 * sendo estes também tratados e transformados num array.
 *
 * @return array Array com todos os elementos do URL.
 */
function obterUrl()
{
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    if (empty($url[0]))
        $url[0] = 'index';

    return $url;
}

/**
 * Uma pequena função que arranjei no StackOverflow para
 * "limpar" frases, ou seja, torná-las nalgo mais fácil para
 * usar em URLS.
 *
 * Ex: "O meu primeiro post" -> "o-meu-primeiro-post"
 *
 * @param string $text O texto a ser "slugify"
 * @return string O texto já "slugify"
 */
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  // trim
  $text = trim($text, '-');
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // lowercase
  $text = strtolower($text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
    return 'n-a';

  return $text;
}

/**
 * Nesta função é obtido o conteúdo de um post.
 *
 * @param string $nomeDoPost O nome do Post previamente passado pelo
 * processo de "slugify"
 *
 * @return string | bool
 */
function obterPostCru($nomeDoPost)
{
    $localizacao = POSTS . $nomeDoPost . '.md';

    if (!file_exists($localizacao)) {
        /* Confirma se o ficheiro existe. Caso não exista
         * retorna "false" e a função não continua. */
        return false;
    }

    /* Se o ficheiro existir, então recebe o conteúdo desse
     * ficheiro e retorna-o. */
    return file_get_contents($localizacao);
}

/**
 * Através desta função é possível obter todas as informações
 * de um post através do seu conteúdo "cru".
 *
 * @param string $conteudo O conteúdo «cru» de um post
 * @return array Toda a informação de um POST (incluindo conteúdo)
 */
function obterInfo($conteudo)
{
    //Código Regex para encontrar todo o conteúdo entre {INFO} e {/INFO}
    $regex = "#\\{INFO\\}(.+)\\{/INFO\\}#s";

    //Pesquisa Regex na variável $conteudo
    preg_match($regex, $conteudo, $matches);

    //Se o tamanho da array $matches for igual a 0 ou 1 retorna false
    if (count($matches) === 0 || count($matches) === 1)
        return false;

    //Substitui, na variável do conteúdo, a INFO do POST por '' (nada)
    $conteudo = preg_replace($regex, '', $conteudo);

    //Transforma o markdown em html utilizando a classe Parsedown
    $Parsedown = new Parsedown();
    $conteudo = $Parsedown->text($conteudo);

    $infoFinal = array(
        'POST'  =>  $conteudo
    );

    $info = explode("\n", $matches[1]);

    for ($i = 0; $i < count($info); $i++) {

        if (strlen($info[$i]) === 0)
            continue;

        $infoCrua = tratarInfo($info[$i]);
        $infoFinal[$infoCrua[0]] = $infoCrua[1];
    }

    return $infoFinal;
}

/**
 * Esta função é utilizada para tratar a info.
 * Simplesmente retira espaços em branco do início
 * e finais das frases de forma a que não hajam problemas.
 *
 * @param array $info
 * @return array
 */
function tratarInfo($info)
{
    $info = explode('=>', $info);

    for ($i = 0; $i < count($info); $i++) {

        $info[$i] = ltrim($info[$i]);
        $info[$i] = rtrim($info[$i]);

    }

    return $info;
}

/**
 * Esta função, que encontrei na Internet,
 * lista os ficheiros de um diretório por ordem
 * de criação dos mesmos.
 */
function listarFicheirosPorDataCriacao($path)
{
    $dir = opendir($path);
    $list = array();

    while($file = readdir($dir)){
        if ($file != '.' and $file != '..'){
            // add the filename, to be sure not to
            // overwrite a array key
            $ctime = filectime($path . $file) . ',' . $file;
            $list[$ctime] = $file;
        }
    }

    closedir($dir);
    krsort($list);
    return $list;
}

function obterConteudoPagInicial($pag = 0)
{
    $ficheiros = listarFicheirosPorDataCriacao(POSTS);
    $ficheirosIndexes = array_keys($ficheiros);

    $html = '';

    for ($i = ($pag * POSTS_POR_PAG); $i < count($ficheirosIndexes); $i++) {

        if ($i === (($pag + 1) * POSTS_POR_PAG) )
            break;

        $nomeDoFicheiro = $ficheiros[$ficheirosIndexes[$i]];
        $nomeDoFicheiro = str_replace('.md', '', $nomeDoFicheiro);

        $postCru = obterPostCru($nomeDoFicheiro);
        $post = obterInfo($postCru);
        $post = tratarPostPagInicial($post['TITLE'], $post['POST'], $nomeDoFicheiro);

        $html .= $post;
    }

    return $html;
}

function tratarPostPagInicial($titulo = 'Unknown', $conteudo = 'Unknown', $link = URL)
{
    $conteudo = substr($conteudo, 0, 100);

    $html = "<article class='post'>
                <header><a href='" . URL . $link . "'><h1>{$titulo}</h1></a></header>

                {$conteudo}
            </article>";

    return $html;
}

function mostrarPagina($titulo, $conteudo)
{
    include 'modelo.php';
}
