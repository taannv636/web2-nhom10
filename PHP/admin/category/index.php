<?php
require_once('../database/dbhelper.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Danh Mục</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Thống kê</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="../category/">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">Quản lý đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../user">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
                    <a class="nav-link" href="../../index.php" style="font-weight: bold; color: red">Đăng xuất</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Quản lý danh mục</h2>
            </div>
            <div class="panel-body"></div>
            <a href="add.php">
                <button class=" btn btn-success" style="margin-bottom:20px">Thêm Danh Mục</button>
            </a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td width="70px">STT</td>
                        <td width="150px">Mã danh mục</td>
                        <td >Tên danh mục</td>
                        <td width="50px"></td>
                        <td width="50px"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Lấy danh sách danh mục
                    $sql = 'select * from category';
                    $categoryList = executeResult($sql);
                    $index = 1;
                    foreach ($categoryList as $item) {
                        echo '  <tr>
                    <td>' . ($index++) . '</td>
                    <td>' . $item['id'] . '</td>
                    <td>' . $item['name'] . '</td>
                    <td>
                        <a href="add.php?id=' . $item['id'] . '">
                            <button class=" btn btn-warning">Sửa</button> 
                        </a> 
                    </td>
                    <td>            
                    <button class="btn btn-danger" onclick="deleteCategory(\'' . $item['id'] . '\')">Xoá</button>
                    </td>
                </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script type="text/javascript">
    function deleteCategory(id) {
        var option = confirm('Bạn có chắc chắn muốn xoá danh mục này không?');
        if (!option) {
            return;
        }
        // Sử dụng Ajax để kiểm tra xem có sản phẩm nào liên kết với danh mục này không
        $.ajax({
            url: 'ajax.php',
            method: 'POST',
            data: {
                'id': id,
                'action': 'checkExistence'
            },
            success: function(data) {
                if (data === 'true') {
                    var option1 = confirm('Đã có sản phẩm được tạo với danh mục này. \n Không được xóa.');
                    console.log(option1);
                    if (!option1) {
                        return;
                    }
                } else {
                    console.log(id);
                    // Tiến hành xóa danh mục nếu không có sản phẩm nào liên kết
                    $.post('ajax.php', {
                        'id': id,
                        'action': 'delete'
                    }, function(data) {
                        location.reload();
                    });
                }
            }
        });
    }
</script>


</body>

</html>