<?php
if (isset($_POST['functionname'])) {
    $paPDO = initDB();
    $paSRID = '4326';
    $paPoint = $_POST['paPoint'];
    $functionname = $_POST['functionname'];

    $aResult = "null";
    echo $aResult;

    closeDB($paPDO);
}

function initDB()
{
    $host = 'localhost';
    $db = 'dongda_univercity';
    $user = 'postgres';
    $password = '123456';
    $post = '5432';
    // Kết nối CSDL
    try {
        $dsn = "pgsql:host=$host;port=$post;dbname=$db;";
        $paPDO = new PDO($dsn, $user, $password);
        return $paPDO;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function query($paPDO, $paSQLStr)
{
    try {
        // Khai báo exception
        $paPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sử đụng Prepare 
        $stmt = $paPDO->prepare($paSQLStr);
        // Thực thi câu truy vấn
        $stmt->execute();

        // Khai báo fetch kiểu mảng kết hợp
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        // Lấy danh sách kết quả
        $paResult = $stmt->fetchAll();
        return $paResult;
    } catch (PDOException $e) {
        echo "Thất bại, Lỗi: " . $e->getMessage();
        return null;
    }
}
function closeDB($paPDO)
{
    // Ngắt kết nối
    $paPDO = null;
}
function getResult($paPDO, $paSRID, $paPoint)
{
    //echo $paPoint;
    //echo "<br>";
    $paPoint = str_replace(',', ' ', $paPoint);

    $mySQLStr = "SELECT name, ST_AsGeoJson(p.geom)
                FROM dongda_univercity_point as p
                join dongda_univercity as u
                on u.osm_id = p.osm_id";
    //echo $mySQLStr;
    //echo "<br><br>";
    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        // Lặp kết quả
        foreach ($result as $item) {
            return $item['geo'];
        }
    } else
        return "null";
}