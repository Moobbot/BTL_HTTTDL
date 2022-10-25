<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập lớn nhóm 3</title>
    <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/alter.css">
    <link rel="stylesheet" href="assets/css/template.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header id="header" class="header">
        <div class="header-container container">
            <div class="header-inner">
                <nav class="navbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt=""
                                    class="img-fluid"></a>
                        </div>
                        <ul class="nav navbar-nav">
                            <li><a href="#search-map">Tìm đường</a></li>
                            <li><a href="#info-school">Thông tin trường đại học</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <div class="main-content">
        <div class="main-content-container">
            <div class="main-content-inner">
                <div id="search-map">
                    <div class="search-map-container container">
                        <div class="search-map-title">
                            <h2>Tìm kiếm</h2>
                        </div>
                        <div class="row search-map-inner">
                            <div class="search-map-left col-lg-8">
                                <div class="search-map-left-inner">
                                    <div id="map" class="map"></div>
                                </div>
                            </div>
                            <div class="search-map-right col-lg-4">
                                <div class="search-map-right-inner">
                                    <div class="option-wrap">
                                        <form action="/action_page.php" class="search-form">
                                            <div class="form-group">
                                                <label for="cars">Chọn trường đại học muốn đến:</label>
                                                <select name="cars" id="cars">
                                                    <option value="TLU">Đại học Thủy Lợi</option>
                                                    <option value="LDA">Đại học Công Đoàn</option>
                                                    <option value="VWA">Học viện Phụ nữ Việt Nam</option>
                                                    <option value="FBU">Đại học Ngân Hàng</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="user-manual">
                                        <ul>
                                            <li>Bước 1: Chọn trường đại học mong muốn</li>
                                            <li>Bước 2: Chọn điểm xuất phát trên bản đồ</li>
                                            <li>Bước 3: Nhấn nút tìm kiếm</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="info-school">
                    <div class="info-school-container container">
                        <div class="info-school-inner">
                            <div class="info-school-title">
                                <h2>Thông tin</h2>
                            </div>
                            <div class="info-school-content">
                                <span>Thông tin trường Đại Học được chọn xuất hiện ở đây.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer" class="footer">

    </footer>
</body>
<script src="assets/js/jquery-3.6.1.js"></script>
<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script src="assets/js/javascript.js"></script>

</html>