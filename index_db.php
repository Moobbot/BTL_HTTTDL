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
$password = '181311';
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
// while ($row = pg_fetch_assoc($result)) {
//     // var_dump($row);
//     //tên trường
//     $name = $row['name'];
//     //Tọa độ
//     $toado = $row['st_astext'];
//     $toado = trim($toado, "MULTIPOINT()");
//     echo "<pre>";
//     print_r($name);
//     echo "<br>";
//     print_r($toado);
//     echo "</pre>";
// }
