<?php

    session_start();
    include 'settings.php';
    include 'functions.php';

    if (isset($_POST['submit'])) {

        $provider = $_POST["provider"];
        $title = $_POST["title"];
        $message = $_POST["message"];

        if ($_POST["post_id"] == "") {
            $postId = "0";
        } else {
            $postId = $_POST["post_id"];
        }
		
		if ($_POST["link"] == "") {
            $link = "0";
        } else {
            $link = $_POST['link'];
        }

        $bigImage = $_POST["image"];
        $uniqueId = rand(1000, 9999);

        if ($provider == 'onesignal') {
            ONESIGNAL($uniqueId,  $title, $message, $bigImage, $link, $postId, $oneSignalAppId, $oneSignalRestApiKey);
        } else if ($provider == 'fcm') {
            FCM($uniqueId, $title, $message, $bigImage, $link, $postId, $fcmServerKey, $fcmNotificationTopic);
        }

    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Blogger Radio App - Notifications</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <?php include_once ('assets/css.min.php'); ?>
</head>

<body class="container-fluid login-page poppins">

    <div class="login-box">
        <div class="card corner-radius">
            <div class="body">
                <form id="form_validation" method="post">
                    <center>
                        <div style="margin-bottom: 14px;"><img src="assets/images/ic_launcher.png" width="72px" height="72px"></div>
                        <div class="custom-padding2 col-pink">
                            <?php if(isset($_SESSION['msg'])) { ?>
                            <div class='alert alert-info alert-dismissible corner-radius' role='alert'>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>&nbsp;&nbsp;</button>
                                <?php echo $_SESSION['msg']; ?>
                            </div>
                            <?php unset($_SESSION['msg']); } ?>  
                        </div>
                    </center>

                    <div class="form-group">
                        <br>
                        <div class="font-12">Provider</div>
                        <select class="form-control show-tick" name="provider">
                            <option value="fcm">Firebase Cloud Messaging (FCM)</option>
                            <option value="onesignal">OneSignal</option>
                        </select>
                    </div>

                    <div class="input-group form-group">
                        <div class="form-line">
                            <div class="font-12">Title</div>
                            <input type="text" class="form-control" name="title" placeholder="Title" required>
                        </div>
                    </div>

                    <div class="input-group form-group">
                        <div class="form-line">
                            <div class="font-12">Message</div>
                            <input type="text" class="form-control" name="message" placeholder="Message" required>
                        </div>
                    </div>

                    <div class="input-group form-group">
                        <div class="form-line">
                            <div class="font-12">Big Image Url (Optional)</div>
                            <input type="text" class="form-control" name="image" placeholder="Big Image Url (Optional)">
                        </div>
                    </div>
					
					<input type="hidden" name="post_id" placeholder="Post Id (Optional)">

                    <div class="input-group form-group">
                        <div class="form-line">
                            <div class="font-12">Link (Optional)</div>
                            <input type="text" class="form-control" name="link" placeholder="Launch Url (Optional)">
                        </div>
                    </div>

                    <div class="input-group form-group">
                        <button class="button button-rounded waves-effect waves-float pull-right" type="submit" name="submit">SEND NOTIFICATION</button>
                    </div>

                    <div align="center">
                        Copyright © 2023 <a href="https://codecanyon.net/user/solodroid/portfolio" target="_blank">Solodroid Developer</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php include_once ('assets/js.min.php'); ?>

</body>

</html>