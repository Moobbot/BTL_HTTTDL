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
                                        <div class="righ-panel">
                                            <button id="btnSolve">Tìm đường</button>
                                            <button id="btnReset">Xóa đường</button>
                                        </div>
                                        <div class="option-wrap">
                                            <div class="option-inner">
                                                <label for="uni">Chọn trường đại học muốn đến:</label>
                                                <select name="uni" id="uni">
                                                    <option value="105.8057326 21.0232956">Trường Đại học Ngoại thương
                                                    </option>
                                                    <option value="105.8285333 21.0085184">Học viện Ngân Hàng</option>
                                                    <option value="105.8318835 21.0020876">Trường Đại học Y Hà Nội
                                                    </option>
                                                    <option value="105.8062413 21.0225812">Học viện Ngoại giao</option>
                                                    <option value="105.8095684 21.0226107">Học viện Thanh Thiếu Niên
                                                        Việt Nam</option>
                                                    <option value="105.8246023 21.0074168">Đại học Thủy Lợi</option>
                                                    <option value="105.8254411 21.0098983">Đại học Công Đoàn</option>
                                                    <option value="105.8026748 21.0278713">Trường Đại học Giao thông Vận
                                                        tải</option>
                                                    <option value="105.8319286 21.0265126">Trường Cao đẳng Y tế Hà Nội
                                                    </option>
                                                    <option value="105.8236938 21.023013">Trường Đại học Mỹ thuật Công
                                                        nghiệp</option>
                                                    <option value="105.8262804 21.0226245">Học viện Âm nhạc Quốc gia
                                                        Việt Nam</option>
                                                    <option value="105.8103481 21.0213527">Trường Đại học Luật Hà Nội
                                                    </option>
                                                    <option value="105.8227424 21.023293">Trường Đại học Văn hoá Hà Nội
                                                    </option>
                                                    <option value="105.8107746 21.0230226">Học viện Hành chính Quốc gia
                                                    </option>
                                                    <option value="105.8156106 21.0131127">Trường Cao đẳng nghề Công
                                                        nghiệp Hà Nội</option>
                                                    <option value="105.8074549 21.0175412">Trường Đại học Văn hóa Nghệ
                                                        thuật Quân đội</option>
                                                    <option value="105.8078565 21.0194347">Học viện Phụ nữ Việt Nam
                                                    </option>

                                                </select>
                                                <?php include 'CMR_pgsqlAPI.php' ?>
                                            </div>
                                        </div>
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
</body>
<script src="assets/js/jquery-3.6.1.js"></script>
<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script src="assets/js/javascript.js"></script>

</html>