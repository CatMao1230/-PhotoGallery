<!DOCTYPE html>
<html>
<head>
<title>CatMao</title>
<meta charset="UTF-8">
    <style>
    body{
        text-align: center;
        background-color: aliceblue;
    }
    .myButton {
        -moz-box-shadow:inset 0px 1px 0px 0px #7a8eb9;
        -webkit-box-shadow:inset 0px 1px 0px 0px #7a8eb9;
        box-shadow:inset 0px 1px 0px 0px #7a8eb9;
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #637aad), color-stop(1, #5972a7));
        background:-moz-linear-gradient(top, #637aad 5%, #5972a7 100%);
        background:-webkit-linear-gradient(top, #637aad 5%, #5972a7 100%);
        background:-o-linear-gradient(top, #637aad 5%, #5972a7 100%);
        background:-ms-linear-gradient(top, #637aad 5%, #5972a7 100%);
        background:linear-gradient(to bottom, #637aad 5%, #5972a7 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#637aad', endColorstr='#5972a7',GradientType=0);
        background-color:#637aad;
        border:1px solid #314179;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:13px;
        font-weight:bold;
        padding:6px 12px;
        text-decoration:none;
    }
    .myButton:hover {
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #5972a7), color-stop(1, #637aad));
        background:-moz-linear-gradient(top, #5972a7 5%, #637aad 100%);
        background:-webkit-linear-gradient(top, #5972a7 5%, #637aad 100%);
        background:-o-linear-gradient(top, #5972a7 5%, #637aad 100%);
        background:-ms-linear-gradient(top, #5972a7 5%, #637aad 100%);
        background:linear-gradient(to bottom, #5972a7 5%, #637aad 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5972a7', endColorstr='#637aad',GradientType=0);
        background-color:#5972a7;
    }
    .myButton:active {
        position:relative;
        top:1px;
    }
    div.img {
        background-color: #FFFFFF;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 12px;
        box-shadow:4px 4px 12px -2px rgba(20%,20%,40%,0.1);
        transition: 0.3s;
    }

    div.img:hover {
        border: 1px solid #777;
        border-radius: 12px;
    }

    div.img img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        transition: 0.3s;
    }
        
    div.img img:hover {
        opacity: 0.5;
    }
        
    div.desc {
        padding: 15px;
        text-align: center;
    }

    * {
        box-sizing: border-box;
    }

    .responsive {
        padding: 6px 6px;
        float: left;
        width: 24.99999%;
    }

    @media only screen and (max-width: 700px){
        .responsive {
            width: 49.99999%;
            margin: 6px 6px;
        }
    }

    @media only screen and (max-width: 500px){
        .responsive {
            width: 100%;
        }
    }

    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }
    </style>
</head>
<body>
    
<script>
    
    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        if (response.status === 'connected') {
            testAPI();
        } else if (response.status === 'not_authorized') {
            document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
        } else {
            document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1093053250804096', 
            cookie     : true,  
            xfbml      : true,  
            version    : 'v2.8' 
        });

        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });

    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/zh_TW/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
            console.log('Successful login for: ' + response.name);

            document.getElementById('status').innerHTML =
            "<button style='float: right; width: 70px; text-align: center;' class='myButton' id='fbLogout' onclick='fbLogout()'>LogOut</button><form action='upload.php' Method='POST' Enctype='multipart/form-data'>Welcome, " + response.name + "<input name='myName' type='hidden' value='" + response.name + "'>  <br><br>" +
            "<input type='file' name='fileImg[]' multiple='multiple'><input class='myButton' type='submit' value='上傳圖片'></form>";
            document.getElementById('divLogIn').innerHTML = "";
        });
    }

    function fbLogout() {
        FB.logout(function (response) {
            document.getElementById('divLogIn').innerHTML = '<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>';
            
            window.location.reload();
        });
    }
    
</script>
    
<div id="divLogIn" style="float: right;">
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button></div>
    
<div style="text-align: right;" id="status"></div>
    
<?php

    $conn = new mysqli('localhost', 'CatMao', '1032002', 'catmao');
    if($conn->connect_error){
        die('連線失敗' . $conn->connect_error);
    }
    
    $sql = 'SELECT * FROM upload';
    $conn->query("set names 'utf8'");
    $result = $conn->query($sql);
    while($row=$result->fetch_assoc()){
        
        $target_path = "img/" . $row["Picture"];
        
        if(is_file($target_path)){
            echo '<div class="responsive"><div class="img"><a target="_blank" href="' .
                $target_path . '"><img src="' . $target_path . '" alt="Trolltunga Norway"  style="width: 100%;"></a><div class="desc">檔名：' . $row["Picture"] . '<br>上傳者：' . $row["Name"] . '</div></div></div>';
        }
    }
    
    $conn->close();
    $conn = NULL;
?>

</body>
</html>