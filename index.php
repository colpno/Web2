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
    <!-- <form id="form" enctype="multipart/form-data"> -->
    <!-- <input type="text" name="maLoai">
        <input type="text" name="maNSX">
        <input type="text" name="tenSP">
        <input type="text" name="donGia">
        <input type="text" name="donViTinh">
        <input type="text" name="soLuong"> -->
    <!-- <input type="file" name="anhDaiDien" id="anhDaiDien">
        <input type="submit" value="Submit" name="submit">
    </form> -->
    <!-- <form method="POST" enctype="multipart/form-data">
        <input type="file" name="img" id="img">
        <button class="submit">OK</button>
    </form> -->
    <div id="testing">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form id="form" action="ajaxupload.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="tenSP">
                    <input id="uploadImage" type="file" accept="image/*" name="image" />
                    <div id="preview"><img src="filed.png" /></div><br>
                    <input class="btn btn-success" type="submit" value="Upload">
                </form>
                <div id="err"></div>
                <hr>
            </div>
        </div>
    </div>

    <script src="public/scripts/ajax.js"></script>
    <script>
        ajaxRequest("form", "add", "POST", "#testing");

        // $(document).ready(function(e) {
        //     $("#form").on('submit', (function(e) {
        //         e.preventDefault();

        //         $.ajax({
        //             url: "app/index.php",
        //             type: "POST",
        //             data: new FormData(this),
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             beforeSend: function() {
        //                 //$("#preview").fadeOut();
        //                 $("#err").fadeOut();
        //             },
        //             success: function(data) {
        //                 if (data == 'invalid') {
        //                     // invalid file format.
        //                     $("#err").html("Invalid File !").fadeIn();
        //                 } else {
        //                     // view uploaded file.
        //                     $("#preview").html(data).fadeIn();
        //                     $("#form")[0].reset();
        //                 }
        //             },
        //             error: function(e) {
        //                 $("#err").html(e).fadeIn();
        //             }
        //         });
        //     }));
        // });
    </script>
</body>

</html>