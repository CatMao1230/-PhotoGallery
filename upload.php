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
    <script>
        function btnBackOnClick(){
            document.location.href="1032002.php";
        }
    </script>
</head>
<body>
<button style='float: right; width: 100px; text-align: center;' class='myButton' id='btnBack' onclick='btnBackOnClick();'>返回主頁面</button>
<?php
    
    $fileCount = count( $_FILES["fileImg"]["name"] );
    $Name = mb_convert_encoding($_POST["myName"], "UTF-8", "auto");
    
    echo $Name . "上傳了" . $fileCount . "個檔案<br>";
    
    for( $i = 0; $i < $fileCount; $i++ )
    {
        if($_FILES['fileImg']['error'][$i] > 0){
            echo "上傳檔案有錯誤：" . $_FILES['fileImg']['error'][$i] . "<br>";
        }
        else{
            
            $conn = new mysqli('localhost', 'CatMao', '1032002', 'catmao');
            if($conn->connect_error){
                die('連線失敗' . $conn->connect_error);
            }

            if(file_exists("img/" . $_FILES['fileImg']['name'][$i])){
                echo $_FILES['fileImg']['name'][$i] . "已存在，請勿重複上傳。<br>";
            }
            else{
                $target_path = "img/" . $_FILES['fileImg']['name'][$i];

                $file_name = $_FILES['fileImg']['name'][$i];
                if(move_uploaded_file($_FILES['fileImg']['tmp_name'][$i], iconv("UTF-8", "big5", $target_path))){

                    $sql = 'INSERT INTO upload (Name, Picture) VALUES ("' .
                           $Name . '", "' . $_FILES['fileImg']['name'][$i] .
                           '")';

                    $conn->query("set names 'utf8'");
                    $conn->query($sql);
                    
                    echo '<div class="responsive"><div class="img"><a target="_blank" href="' .
                        $target_path . '"><img src="' . $target_path . '" alt="Trolltunga Norway" width="300" height="200"></a><div class="desc">檔名：' . $_FILES['fileImg']['name'][$i] . '<br>上傳者：' . $Name . '</div></div></div>';
                }
                else{
                    echo "檔案上傳失敗！<br>";
                }
            }

            $conn->close();
            $conn = NULL;
        }
    }
?>
    
    
</body>
</html>