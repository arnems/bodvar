<?php
$videoFileName = $_GET['videofile'];
$videoname = $_GET['videoname'];
$lang = $_GET['lang'];
if ($lang == 2) {
    $leadIn = 'Film: ';
} else {
    $leadIn = 'Video: ';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Periscope Vision - www.periscopevision.org</title>
    <link href="css/html5.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <div class="heading"></div>
    <div class="backMenu">
        <a href="./video.php?lang=<?php echo $lang ?>">&lt;&lt;Back</a>
    </div>
    <div class="mainSection">
        <div class="videoFrame">
            <h1 style="color: #ccc;"><?php //echo $leadIn ?><?php echo $videoname ?></h1>
            <video controls autoplay preload="">
                <source src="<?php echo './' . $videoFileName ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="videoProd">
            <a href="http://www.doc-art.no/#about" target="_blank">Videoproduksjon: Doc-Art/Randi St&oslash;rseth</a>
        </div>
        <div class="spacer"></div>
    </div>
    <div class="footer">
        <div align="center" class="copyright"> Bodvar Schjelderup &copy;2007 &nbsp;&nbsp;www.periscopevision.org</div>
    </div>
</div>
</body>
</html>
