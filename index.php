<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="public/css/admin/Main.css">
    <title>Bakery</title>
</head>

<body>

    <form id="form" enctype="multipart/form-data">
        <!-- <input type="text" name="maLoai">
        <input type="text" name="maNSX">
        <input type="text" name="tenSP">
        <input type="text" name="donGia">
        <input type="text" name="donViTinh">
        <input type="text" name="soLuong"> -->
        <!-- <input id="anhDaiDien" type="file" accept="image/*" name="anhDaiDien" /> -->
        <input type="text" name="anhDaiDien" value="C:\xampp\htdocs\Web2\common\..\public\images\SanPham\SP-1.png">
        <input type="checkbox" name="maSP" value="1"><input type="checkbox" name="maSP" value="2"><input type="checkbox" name="maSP" value="3"><input type="checkbox" name="maSP" value="4">
        <input class="btn btn-success" type="submit" value="Upload">
    </form>

    <div id="testing">
    </div>

    <script src="public/scripts/ajax.js"></script>
    <script>
        ajaxRequest("form", "delete", "POST", "#testing");
    </script>
</body>

</html>