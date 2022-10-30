<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bài tập lớn nhóm 3</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/css/alter.css">
    <link rel="stylesheet" href="assets/css/template.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php
    // PDO Options
    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $host = 'localhost';
    $db = 'btl';
    $user = 'postgres';
    $password = '123456';
    $post = '5432';

    // connect to a database 
    $dbConn = pg_connect("host=$host port=$post dbname=$db user=$user password=$password");
    if (!$dbConn) {
        echo "An error occurred.\n";
        exit;
    }
    // Query data
    $result = pg_query($dbConn, "SELECT name, ST_AsText(p.geom) FROM dongda_univercity_point AS p JOIN dongda_univercity AS u ON u.osm_id = p.osm_id");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }

    // Show value
    while ($row = pg_fetch_assoc($result)) {
        // var_dump($row);
        //tên trường
        $name = $row['name'];
        //Tọa độ
        $toado = $row['st_astext'];
        $toado = trim($toado, "MULTIPOINT(");
        $toado = trim($toado, ")");
        $toado = explode(' ', $toado);
        echo "<pre>";
        print_r($name);
        echo "<br>";
        print_r($toado);
        echo "</pre>";
    }
    ?></body>
<script src="assets/js/jquery-3.6.1.js"></script>
<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script src="assets/js/javascript.js"></script>

</html>