<?php

if (isset($_POST['gid'])) {
    $paPDO = initDB();
    $paSRID = '4326';
    $gid = $_POST['gid'];
    $aResult = "null";
    $aResult = getUnivercity($paPDO, $gid);
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

//! Lấy thông tin trường địa học
function getUnivercity($paPDO, $gid)
{
    $mySQLStr = "SELECT * FROM dongda_univercity AS u WHERE u.gid = " . $gid . ";";
    $result = query($paPDO, $mySQLStr);
    if ($result != null) {
        // Kết quả
        $resFin = '';
        foreach ($result as $key => $row) {
            $resFin = $row['name'] . '<br>';
            // $resFin = $resFin . 'Thành lập: ' . $row['start_date'] . '<br>';
            $resFin = $resFin . 'Địa chỉ: Số ' . $row['addr_house'] . ', ';
            $resFin = $resFin . $row['addr_stree'] . ', ';
            $resFin = $resFin . $row['addr_subdi'] . ', ';
            $resFin = $resFin . $row['addr_distr'] . ', ';
            $resFin = $resFin . $row['addr_city'] . '<br>';
            $resFin = $resFin . 'Hotline: ' . $row['phone'] . '<br>';
            $resFin = $resFin . 'Website: ' . $row['website'];
        }
        return $resFin;
    } else
        return "null";
}