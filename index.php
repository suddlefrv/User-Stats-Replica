
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if(!isset($_GET["user"])):?> Heloo <?php else:?> Viewing <?=$_GET["user"]?> <?php endif;?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        @font-face {
            font-family: 'Minecraft';
            src: url('minecraft.woff2') format('woff2');
        }
        body{
            font-family: Poppins;
        }
    </style>
</head>
<body>

<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none" style="font-size: 20px;">
                <img src="https://media.discordapp.net/attachments/1017009585640456193/1021105159293648996/Baslksz-6.png" class="img-fluid">
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/index.php" class="nav-link px-2 <?php if(!isset($_GET["user"])):?> text-secondary <?php else:?> text-white <?php endif;?>">Home</a></li>
                <li><a href="#" class="nav-link px-2 <?php if(isset($_GET["user"])):?> text-secondary <?php else:?> text-white <?php endif;?>">Player</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="">
                <input type="search" name="user" class="form-control form-control-dark text-bg-dark" placeholder="Search User" aria-label="Search">
            </form>

            <div class="text-end">
                <button type="button" class="btn btn-outline-light me-2">Login</button>
                <button type="button" class="btn btn-danger">SignUp</button>
            </div>
        </div>
    </div>
</header>
<?php if(!isset($_GET["user"])):?>
    <div class="container py-3">
        <div class="px-4 py-5 my-5 text-center">
            <img class="d-block mx-auto mb-4" src="https://media.discordapp.net/attachments/1017009585640456193/1021105159293648996/Baslksz-6.png" alt="" width="120" height="120">
            <h1 class="display-5 fw-bold">Welcome to UserStats</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">You can search any player's stats or capes here.</p>
                <form class="d-grid gap-1 justify-content-sm-center" action="">
                    <input type="search" name="user" class="form-control" placeholder="Search User" aria-label="Search"><br>
                    <button type="submit" class="btn btn-primary px-4">Start Searching</button>
                </form>
            </div>
        </div>
    </div>
<?php else:?>

<?php

$username = $_GET["user"];
$uuid = "";
$capecs = "";
$elytra = false;
?>
<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.mojang.com/users/profiles/minecraft/' . $username);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
$rs = json_decode($result, TRUE);
$uuid = $rs["id"];
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

?>
<div class="container py-3">
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal">Viewing Player</h1>
    </div>
    <main>
            <div class="col-lg-4 text-center" style="margin:auto;">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal"><?=$username?></h4>
                    </div>
                    <div class="card-body">
                        <div class="skin-container" style="margin: auto;text-align: center;">
                            <canvas style="align-items: center; margin: auto; position:relative; border-radius: 15px" id="skin_container"></canvas>
                        </div>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>UUID: <?=$uuid?></li>
                        </ul>
                        <div class="form-container" style="margin: auto;text-align: center;">
                            <div class="control-section">
                                <h1>Speed</h1>
                                <form>
                                    <input id="speedcik" type="number" class="form-control" value="2" step="0.1" max="10.0" size="3"><br>
                                    <button type="button" class="btn btn-success" onclick="console.log('Updated Speed To ' + document.getElementById('speedcik').value); updateSpeed(document.getElementById('speedcik').value)">Update</button>
                                </form>


                            </div>
                            <div class="control-section">
                                <h1>Other</h1>
                                <form class="text-center">
                                    <button type="button" class="btn btn-dark" onclick="changeStatusOfElytra();">Elytra</button>
                                    <button type="button" class="btn btn-dark" onclick="changeStatusOfCape();">Cape</button>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
        </div>

        <br>

    </main>


<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid . '/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
function is_obj_empty($obj){
    if( is_null($obj) ){
        return true;
    }
    foreach( $obj as $key => $val ){
        return false;
    }
    return true;
}

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
$rs = json_decode($result, TRUE);
$getresult = json_decode($result);
$texture = $getresult->properties;
$capecik2 = base64_decode($texture[0]->value);
$resultsos = json_decode($capecik2);
if(!is_obj_empty($resultsos->textures->CAPE)){
    $capecs = $resultsos->textures->CAPE->url;
    $capecs = str_replace("http://textures.minecraft.net/texture/" ,"https://api.gapple.pw/cors/textures/", $capecs);
} else {
    $capecs = "https://api.gapple.pw/cors/optifine/" . $username;
}

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

?>
<script src="skinview3d.bundle.js"></script>
<script>
    let skinViewer = new skinview3d.SkinViewer({
        canvas: document.getElementById("skin_container"),
        width: 300,
        height: 300,
        skin: "https://mineskin.eu/skin/<?=$username?>"
    });

    // Change viewer size
    skinViewer.width = 250;
    skinViewer.height = 350;

    skinViewer.loadCape("<?=$capecs?>");
    // Change camera FOV
    skinViewer.fov = 100;
    skinViewer.nameTag = "<?=$username?>";
    // Set the background to a panoramic image
    // Zoom out
    skinViewer.zoom = 0.7;

    // Rotate the player
    skinViewer.autoRotate = false;

    // Apply an animation
    skinViewer.animation = new skinview3d.WalkingAnimation();

    // Set the speed of the animation
    skinViewer.animation.speed = document.getElementById("speedcik").value;

    // Pause the animation
    skinViewer.animation.paused = false;

    // Remove the animation
    function updateSpeed($speed){
        skinViewer.animation.speed = $speed;
    }
    function changeStatusOfElytra(){
        skinViewer.loadCape("<?=$capecs?>", { backEquipment: "elytra" });
    }
    function changeStatusOfCape(){
        skinViewer.loadCape("<?=$capecs?>", { backEquipment: "cape" });
    }
</script>
<?php endif;?>
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">© 2022 Reberion, Inc</p>

        <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <img src="https://media.discordapp.net/attachments/1017009585640456193/1021105159293648996/Baslksz-6.png" class="img-fluid">
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="/index.php" class="nav-link px-2 <?php if(!isset($_GET["user"])):?> text-secondary <?php else:?> text-muted <?php endif;?>">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 <?php if(isset($_GET["user"])):?> text-secondary <?php else:?> text-muted <?php endif;?>">Player</a></li>
        </ul>
    </footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>



