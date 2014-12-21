<?php

//Conect to the database
try {
    $db = new PDO('sqlite:db.sqlite');
} catch (PDOException $e) {
    die("Can't Establish Database Connections");
}

/*
 * Using the ternary operator, we define the $url.
 *
 * If the GET 'url' param is set, $url will be equal to this param. If not, $url
 * will be set null.
 */
$url = isset($_GET['url']) ? $_GET['url'] : null;

//Remove every slash from the end of the URL.
$url = rtrim($url, '/');

// If the $url is empty, we define it with 1 because it's the first page.
if (empty($url)) {
    $url = 1;
}

/*
 * So,we define the $n variable (current page number) equal to intval($url) because
 * the page should be a number and the 'url' param is set as a string.
 */
$n = intval($url);

?>

<html lang='en'>

<head>
    <meta charset='utf-8'>
    <title>Paginated Database Listing</title>

    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>

    <div class="list">
    <h1>Paginated Database Listing</h1>

    <?php

    /*
     * This query is used to get the number of rows of the table 'mytable'. You
     * should change the table name to correspond with your database.
     */
    $query = $db->query("SELECT count(*) FROM mytable");
    $lineNumber = $query->fetchColumn();

    //Set the max number of itens per page
    $itensPerPage = 15;

    /*
     * Create a new variable $maxPages and set it equal to the max pages number.
     * To get this number we divide the number os rows (or lines) by the max
     * number of itens per page.
     *
     * The result of this division is within a function called ceil() that rounds
     * up the value.
     */
    $maxPages = ceil($lineNumber / $itensPerPage);

    if ($n > $maxPages || $n < 1) {

        /*
         * If the current page is bigger than the max pages number or the page number
         * is set to 0 or a negative number, it shows a not found error.
         */
        echo 'Page not found.';

    } else {

        /*
         * Else, we define the offset to be used in a query. With this value we
         * can select only the itens corresponding to current page.
         *
         * The $offset is equal to an algebraic expression that is equal to $n minus
         * 1 multiplied by $itensPerPage.
         */
        $offset = ($n - 1) * $itensPerPage;

        /*
         * Get all rows from the table 'mytable', limiting the number of rows obtained
         * by $itensPorPag and setting the offset.
         */
        $query = "SELECT * FROM mytable LIMIT ". $itensPerPage . " OFFSET " . $offset;
        $items = $db->query($query);

        /*
         * We just create a loop to show the itens.
         */
        foreach($items as $item) { ?>

            <h2>Id: <?php echo $item['id'];?></h2>
            <p><?php echo $item['content'];?></p>
        <?php }

        if ($n > 1) {

            /*
             * If the current page number is more than one, we obtain the previous page
             * number and show the button to go to the previous page.
             */
            $previous = $n - 1; ?>

            <button><a href="<?php echo $previous;?>">Previous</a></button>

        <?php }

        if ($n < $maxPages) {

            /*
             * If the current page number is less than $maxPages, we obtain the next page
             * number and show the button.
             */
            $next = $n + 1; ?>

            <button><a href="<? echo $next;?>">Next</a></button>

        <?php }

    }

    ?>

    </div>

</body>

</html>
