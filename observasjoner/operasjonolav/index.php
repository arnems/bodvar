<?php
function reorderPictureArray($Array, $sFile)
{
    $sArray = null;
    if (($handle = fopen($sFile, 'r')) != FALSE) {
        while (($data = fgetcsv($handle, 0, ";")) != FALSE) {
            $sArray[] = $data;
        }
        $newArray = array();
        foreach($Array as $index => $value){
            foreach ($sArray[0] as $sIndex => $sValue) {
                if (strpos($Array[$index], $sValue) !== false) {
                    $newArray[$sIndex] = $value;
                }
            }
        }
        ksort($newArray);
        return $newArray;
    }
}

$serie = $_GET["serie"];
if ($serie == '') {
    $serie = 'serie1';
}
//Get picture ID in group
$picid = $_GET["picid"];
if ($picid == '') {
    $picid = 0;
}

//Read in all poster names (filenames)
$imageDir = './' . $serie .'/' ;
$pictureArray = array();
if ($handle = opendir($imageDir)) {
    while (false !== ($file = readdir($handle))) {
        if (substr($file, 0, 1) != '.') {
            $info = new SplFileInfo($imageDir . $file);
            $pictureArray[] = $info->getFilename();
        }
    }
    closedir($handle);
    sort($pictureArray);
    $sequeceFilename = "./" . $serie . "/sequence.txt";
    if (file_exists($sequeceFilename)) {
        $pictureArray = reorderPictureArray($pictureArray, $sequeceFilename);
    }
    $pictureArray = array_values($pictureArray);
}
//var_dump($pictureArray);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <meta name="description" content="Bodvar Schjelderup’s discoveries and interpretations"/>
    <meta name="author" content="Bodvar Schjelderup"/>
    <meta name="keywords" content="kildespeilet, periscope, pyramid, mercator"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <link href="../../includes/styles.css" rel="stylesheet" type="text/css"/>
    <link href="//cloud.webtype.com/css/69607097-073d-4768-8705-cf18e5bba52e.css" rel="stylesheet" type="text/css"/>
    <title>Operasjon Olav</title>
    <style>
        h2 {  padding-bottom: 0 color: #666}
        .bTopp {  font-size: 1.2em;  text-align: center;}
        a {  text-decoration: none;}
    </style>
</head>
<body>
<div class="wrapper" style="width: 90%">
    <?php include('../../includes/header.php'); ?>
    <div class="section">
        <h1 style="font-size: 3em;">Operasjon Olav</h1>
        <div class="seriesSelction">
            <?php
            // Utheving av valg meny
            printf('<a class="%s" href="index.php?serie=serie1">Vis serie 1</a>', ($serie == 'serie1') ? 'tMenu tMenuSelected' : 'tMenu');
            printf('<a class="%s" href="index.php?serie=serie2">Vis serie 2</a>', ($serie == 'serie2') ? 'tMenu tMenuSelected' : 'tMenu');
            printf('<a class="%s" href="index.php?serie=serie3">Vis serie 3</a>', ($serie == 'serie3') ? 'tMenu tMenuSelected' : 'tMenu');
//            printf('<a class="tMenu" href="../">Tilbake til Observasjoner</a>');
            ?>
        </div>
        <div class="bildeStrip">
            <?php
            // Forward and backward pictrure key
            $prev = $picid -1;
            if($prev < 0){
                $prev=0;
                $bwClass = "nextPrev notActive";
            } else
                $bwClass = "nextPrev";

            $next = $picid+1;
            if($next > count($pictureArray)-1){
                $next=count($pictureArray)-1;
                $fwClass = "nextPrev notActive";
            }else
                $fwClass = "nextPrev";

            printf('<a class="%s" href="index.php?serie=%s&picid=%s" title="forrige bilde">&#8592;</a>', $bwClass, $serie, $prev); // previous picture
            printf('<a class="%s" href="index.php?serie=%s&picid=%s" title="neste bilde">&#8594;</a>', $fwClass, $serie, $next);   // next picture
            ?>
            <div>
                <?php
                 $i = 0;
//                $c = $i + 1;
//                echo "serie".$c;
//                echo $serie;
                foreach ($pictureArray as $thumbString){
                    printf('<a href="index.php?serie=%s&picid=%s">', $serie, $i);
                    printf('<img class="%s" src="./%s/thumbnails/%s" alt="" >', ($picid == $i) ? 'imgThumb imgThumbSelected' : 'imgThumb' , $serie, $thumbString);
                    printf('</a>');
                    $i++;
                    }
                ?>
            </div>
        </div>
        <div class="bilde">
            <div>
                <?php
                    $imgString = $pictureArray[$picid];
                    printf('<img class="imgBilde" src="./%s/%s" alt="" >', $serie, $imgString);
                ?>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>

    <?php include('../../includes/footer.php'); ?>
</div>
</body>
</html>