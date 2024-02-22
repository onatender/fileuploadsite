<!DOCTYPE html>
<html lang="en">
<?php
function getnewtoken()
{
    $zaman = time();
    $token = md5($zaman);
    return $token;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['deleteimage']) && isset($_REQUEST['key']) &&  $_REQUEST['key'] == "00000000") {
    setcookie("TOKEN", getnewtoken(), time() + 36000000, "/");
    $dosya_adi = $_FILES['dosya']['name'];
    $dosya_gecici_adi = $_FILES['dosya']['tmp_name'];
    $hedef_dizin = 'files/';

    $sayac = 1;
    $yeni_dosya_adi = $sayac . "." . pathinfo($dosya_adi, PATHINFO_EXTENSION);
    while (file_exists($hedef_dizin . $yeni_dosya_adi)) {
        $yeni_dosya_adi =  $sayac . '.' . pathinfo($dosya_adi, PATHINFO_EXTENSION);
        $sayac++;
    }
    $hedef_dizin .= $yeni_dosya_adi;
    $move = move_uploaded_file($dosya_gecici_adi, $hedef_dizin);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteimage'])) {

    $file = "files/" . $_POST['deleteimage'];
    if (file_exists($file)) {
        unlink($file);
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosya Transferi
    </title>
</head>

<body>

    <div class="container">
        <?php
        if (isset($_REQUEST['key']) &&  $_REQUEST['key'] == "00000000") {
            $dosya_dizini = 'files/';

            $dosyalar = scandir($dosya_dizini);

            $dosyalar = array_diff($dosyalar, array('.', '..'));

            $photocount = 0;
            foreach ($dosyalar as $dosya) {
                if ($dosya == ".htaccess") continue;
                echo '<div class="resim">';
                echo '<a href="' . $dosya_dizini . $dosya . "?key=" . $_REQUEST['key'] . "&req=" . random_int(1, 1000000) . '"><img class="images" src="' . $dosya_dizini . $dosya . "?key=" . $_REQUEST['key'] . "&req=" . random_int(1, 1000000) . '"></img></a>';
                echo '<form method="post"> <button name="deleteimage" value="' . $dosya . '"class="deletebtn">SİL</button></form>';
                echo '</div>';
                $photocount++;
                if ($photocount != 0 && $photocount % 3 == 0) {
                    $photocount = 0;
                    echo '<br>';
                }
            }
        }
        ?>
    </div>
    <form method="post" enctype="multipart/form-data">
        <label class="btnstyle1" for="dosya">Resim Yükle</label>
        <input type="file" style="display:none;" id="dosya" name="dosya" accept="image/*"><!-- Kabul edilen dosya türlerini buraya ekleyebilirsiniz -->
        <button style="display:none;" id="btnsubmit" onclick="bp()" value="0" type="submit">Yükle</button>
    </form>
    <style>
        label {
            all: initial;
        }

        @import url('https://fonts.googleapis.com/css2?family=Preahvihear&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


        * {

            margin: 0px;
            padding: 0px;
            font-family: 'Preahvihear', sans-serif;
            font-weight: 300;
            user-select: none;
            box-sizing: border-box;
        }





        .deletebtn {
            font-family: 'Preahvihear', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 24px;
            width: 100%;
            border: none;
            border-top: 1px solid black;
            height: 50px;
            transition: .3s;
            outline: none;
            background-color: darkgray;
        }

        .deletebtn:hover {
            background-color: lightgray;
            cursor: pointer;
        }

        .resim {
            width: 30%;
            margin-bottom: 70px;
            margin-left: 1%;
            display: inline-block;
            height: 33%;
        }

        .images {
  object-fit: cover;

            margin: 0;
            padding: 0;
            width: 100%;
            ;
            height: 100%;
            ;
            float:left;
        }

        .btnstyle1 {
            background-color: gray;
            bottom: 0;
            width: 100%;
            height: 100px;
            font-size: 55px;
            align-items: center;
            position: absolute;
            display: flex;
            text-align: center;
            box-shadow: 1px 2px 12px gray;
            justify-content: center;
            transition: .3s;
            color: black;
        }

        body {
            background-color: rgb(30, 30, 30);
            padding-top: 2%;
        }

        .btnstyle1:hover {
            background-color: lightgray;
            cursor: pointer;
        }

        html,
        body {
            height: 100%;
            max-width: 97%;
        }



        .container {
            max-height: 100%;
            overflow-y: auto;
            width: 100%;
            margin-left: 5%;
            height: 100%;
            padding-bottom: 100px;
        }

        @media only screen and (max-width: 1000px) {

            body {
                padding-left: 0%;
                padding-right: 0%;
            }
        }
    </style>


</body>
<script>
    document.getElementById('dosya').addEventListener("change", function(event) {
        document.getElementById('btnsubmit').click();
    });

    let isButtonPressed = false;

    function bp() {
        document.getElementById('btnsubmit').setAttribute('value', '1');
    }
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>