<?php
$video[0] = array("harmonia_mundie_300k.mp4", "Harmonia mundie", "Norsk beskrivelse","English description");
$video[1] = array("Mercator_map_300k.mp4", "Mercator Map", "","");
$video[2] = array("the_invisible_pyramid_300k.mp4", "The Invisible Pyramid", "","");
$video[3] = array("The_Key_of_Transition_300k.mp4", "The Key of Transition", "","");
$video[4] = array("The_Upper_Chamber_300k.mp4", "The Upper Chamber", "","");
$language = $_GET['lang'];
if ($language == '3') {
    $lstring = 'Show video';
    $LangIndex = 3;
} else {
    $lstring = 'Se video';
    $LangIndex = 2;
}
function VideoSelect($video, $lstring, $LangIndex)
{
    echo '<div class="videoElement">';
    echo '<img src="images/periscopevision_liten.jpg" align="left" alt="videoIcon"/>';
    printf('<h3>%s</h3><br>', $video[1]);
    $href = sprintf('playvideo.php?videofile=filmer/%s&videoname=%s&lang=%d', $video[0], $video[1], $LangIndex);
    printf('<a href="./%s"><strong>%s</strong></a>', $href, $lstring);
    echo '</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>List over alle filmer</title>
    <link href="css/html5.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <meta name="description" content="Bodvar Schjelderup’s discoveries and interpretations"/>
    <meta name="author" content="Bodvar Schjelderup"/>
</head>
<body>
<div class="wrapper">
    <div class="heading"></div>
    <div class="backMenu">
        <a href="./">&lt;&lt;Back</a>
    </div>
    <div class="mainSection">
        <?php VideoSelect($video[0], $lstring, $LangIndex) ?>
        <?php VideoSelect($video[1], $lstring, $LangIndex) ?>
        <?php VideoSelect($video[2], $lstring, $LangIndex) ?>
        <?php VideoSelect($video[3], $lstring, $LangIndex) ?>
        <?php VideoSelect($video[4], $lstring, $LangIndex) ?>
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




