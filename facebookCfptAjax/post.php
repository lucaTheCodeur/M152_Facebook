<?php
session_start();

// mode edit
$edit = filter_input(INPUT_GET, 'edit', FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_GET, 'name');

$_SESSION["prevName"] = $name;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Facebook Theme Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="assets/css/facebook.css" rel="stylesheet">
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle=offcanvas]').click(function() {
                $(this).toggleClass('visible-xs text-center');
                $(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
                $('.row-offcanvas').toggleClass('active');
                $('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
                $('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
                $('#btnShow').toggle();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('#upload').on('click', function() {

                var form_data = new FormData();
                var countFiles = document.getElementById('multiFiles').files.length;

                for (var index = 0; index < countFiles; index++) {
                    form_data.append("files[]", document.getElementById('multiFiles').files[index]);
                }
                $.ajax({
                    url: 'ajaxUpload.php',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(response) {
                        console.log(response);

                        for (var index = 0; index < response.length; index++) {
                            var src = response[index];

                            $('#preview').append('<img src="' + src + '" width="400px;" height="400px">');
                        }

                    },
                    error: function(response) {
                        console.log(response[0]);
                        $('#preview').append('<img src="' + response[0] + '" width="400px;" height="400px">');
                    }
                });
            });
        });
    </script>
</head>

<body>

    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">

                <!-- main right col -->
                <div class="column col-sm-10 col-xs-11" id="main">

                    <!-- top nav -->
                    <div class="navbar navbar-blue navbar-static-top">
                        <div class="navbar-header">
                            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="http://usebootstrap.com/theme/facebook" class="navbar-brand logo">b</a>
                        </div>
                        <nav class="collapse navbar-collapse" role="navigation">
                            <form class="navbar-form navbar-left">
                                <div class="input-group input-group-sm" style="max-width:360px;">
                                    <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="facebook.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                                </li>
                                <li>
                                    <a href="post.php" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="">More</a></li>
                                        <li><a href="">More</a></li>
                                        <li><a href="">More</a></li>
                                        <li><a href="">More</a></li>
                                        <li><a href="">More</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /top nav -->

                    <div class="padding">
                        <div class="full col-sm-9">

                            <!-- content -->
                            <div class="row">

                                <!-- main col left -->
                                <div class="col-sm-5">

                                    <div class="well">

                                        <h4><?= $edit == null ? "What's New" : "Update it !" ?></h4>

                                        <!-- <form action="facebook.php" method="POST" enctype="multipart/form-data"> -->
                                            <div class="form-group" style="padding:14px;">
                                                <textarea class="form-control" name="postEcrit" placeholder="<?= $edit == null ? "Update your status" : "Update your post" ?>"></textarea>
                                            </div>
                                            <input type="submit" id="upload" name="submit" value="<?= $edit == null ? "Post" : "Update" ?>" class="btn btn-primary pull-right" />
                                            <ul class="list-inline">
                                                <input type="file" id="multiFiles" name="image[]" class="form-control-file" id="img" accept=".jpg, .jpeg, .png, .mp4, .mp3, .wav" multiple />
                                            </ul>
                                            <input type="hidden" name="editOuNon" value="<?= $edit == null ? "" : $edit ?>" />
                                        <!-- </form> -->

                                    </div>

                                </div>
                                <!-- main col right -->
                                <div class="col-sm-7">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4><?= $edit == null ? "Write something here" : "Update your post" ?></h4>
                                        </div>
                                    </div>
                                </div>

                                <div id="preview">
                                    
                                </div>
                            </div>
                            <!--/row-->




                        </div><!-- /padding -->
                    </div>
                    <!-- /main -->

                </div>
            </div>
        </div>
</body>

</html>