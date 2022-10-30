<?php
if ($connect_check = true) {
    $paPDO = initDB();
    $paSRID = '4326';
    $aResult = "null";

    $aResult = getUnivercity($paPDO, $paSRID);

    echo $aResult;

    closeDB($paPDO);
}

function initDB()
{
    $host = 'localhost';
    $db = 'btl';
    $user = 'postgres';
    $password = '123456';
    $post = '5432';
    // Kết nối CSDL

    // $paPDO = new PDO('pgsql:host=localhost;dbname=KTGK_NgoDucTam;port=5432', 'postgres', 'geoserver');
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
    $paPoint = str_replace(',', ' ', $paPoint);
    $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from \"gadm41_svk_2\" where ST_Within('SRID=" . $paSRID . ";" . $paPoint . "'::geometry,geom)";
    $result = query($paPDO, $mySQLStr);
    if ($result != null) {
        // Lặp kết quả
        foreach ($result as $item) {
            return $item['geo'];
        }
    } else
        return "null";
}
//! Lấy tên và tọa độ trường địa học
function getUnivercity($paPDO, $paSRID)
{
    $mySQLStr = "SELECT name, ST_AsText(p.geom) FROM dongda_univercity_point AS p JOIN dongda_univercity AS u ON u.osm_id = p.osm_id";
    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        $resFin = '<select name="uni" id="uni">';
        // Lặp kết quả
        foreach ($result as $key => $item) {
            $name = $item['name'];
            $toado = $item['st_astext'];
            $toado = $item['st_astext'];
            $toado = trim($toado, "MULTIPOINT()");
            $toado = explode(' ', $toado);
            $resFin = $resFin . '<option value="' . $toado[0] . ' ' . $toado[1] . '">' . $item['name'] .
                '</option>';
            break;
        }
        $resFin = $resFin . '</select>';
        return $resFin;
    } else
        return "null";
}