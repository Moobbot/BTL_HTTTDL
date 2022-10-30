<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VNTALKING - Location Test</title>
    <script src="./assets/js/jquery-3.6.1.js"></script>
    <style>
    body {
        margin: 0;
        padding: 15px;
        color: #222;
        font: normal normal normal 1rem/1.6 Nunito Sans, Helvetica, Arial, sans-serif;
    }

    div {
        margin-bottom: 10px;
    }

    button {
        background-color: #3da4ab;
        border: none;
        color: #fff;
        padding: 10px;
        font-size: 1.05rem;
        border-radius: 2px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0e9aa7;
    }
    </style>
</head>

<body>
    <!--
        Lấy vị trí người dùng sử dụng ipinfo.io API
        Ý tưởng của phương pháp này là: khi người dùng sử dụng ứng dụng web,
        ứng dụng sẽ gửi một request lên server ipinfo.io.
        Server sẽ sử dụng request này để lấy ra thông tin địa chỉ IP của nơi cung cấp dịch vụ mạng, từ đó, suy ra vị trí của người dùng.
        Với cách này bạn luôn có thể lấy được thông tin vị trí người dùng. Ngoài ra, cách này còn cho phép bạn test trên localhost.
    -->
    <div>Latitude: <span id="lat"></span></div>
    <div>Longitude: <span id="lon"></span></div>
    <div>
        <button id="currPos" onclick='locate();'>Get Current Position</button>
    </div>
    <div id="error"></div>
    <script>
    function locate() {
        $.getJSON("https://ipinfo.io/", onLocationGot);

        function onLocationGot(info) {
            let position = info.loc.split(",");
            $("#lat").text(position[0]);
            $("#lon").text(position[1]);
        }
    }
    </script>
</body>
<script src="./assets/js/jquery-3.6.1.js"></script>