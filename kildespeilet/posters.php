<?php
include("./Functions.php");
$group = $_GET["group"];
if ($group == '') {
    $group = '01';
}
//Get picture ID in group
$picid = $_GET["picid"];
if ($picid == '') {
    $picid = 0;
}
//Get text for selected group
$filename = "./groups/" . $group . "/groupText.html";
if (!file_exists($filename)) {
    $groupText = 'Tekst til denne gruppen mangler <br/> No text for this group';
} else {
    $handle = fopen($filename, "r");
    $groupText = fread($handle, filesize($filename));
    fclose($handle);
}
$loupe = $_GET["loupe"];
if ($loupe == '1') {
    $loupeId = "plansje";
    $lStatus = 'På';
    $elStatus = 'On';
} else {
    $loupeId = "xplansje";
    $lStatus = 'Av';
    $elStatus = 'Off';
}
//Read in all poster names (filenames)
$imageDir = './groups/' . $group . "/images/";
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
$sequeceFilename = "./groups/" . $group . "/sequence.txt";
if (file_exists($sequeceFilename)) {
    $pictureArray = reorderPictureArray($pictureArray, $sequeceFilename);
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>the periscope - kildespeilet</title>
    <link href="./css/styles.css" rel="stylesheet" type="text/css"/>
    <link href="//cloud.webtype.com/css/69607097-073d-4768-8705-cf18e5bba52e.css" rel="stylesheet" type="text/css"/>
    <meta name="description" content="det skjulte arkivet for tallsymbolikk og andre tilknyttede emner"/>
    <meta name="author" content="Bodvar Schjelderup"/>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <script type="text/javascript" src="./js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="./js/jquery.mlens-1.5.js"></script>
    <script>
        // when the document is ready, run this function
        jQuery(function( $ ) {
            var keymap = {};

            // LEFT
            keymap[ 37 ] = "#prev";
            // RIGHT
            keymap[ 39 ] = "#next";

            $( document ).on( "keyup", function(event) {
                var href,
                  selector = keymap[ event.which ];
                // if the key pressed was in our map, check for the href
                if ( selector ) {
                    href = $( selector ).attr( "href" );
                    if ( href ) {
                        // navigate where the link points
                        window.location = href;
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        <!--
        $(document).ready(function () {
            $("#plansje").mlens(
                {
                    imgSrc: $("#plansje").attr("data-big"),	// path of the hi-res version of the image
                    lensShape: "square",				// shape of the lens (circle/square)
                    lensSize: 300,					    // size of the lens (in px)
                    borderSize: 4,					    // size of the lens border (in px)
                    borderColor: "#ff0000",				// color of the lens border (#hex)
                    borderRadius: 10,				    // border radius (optional, only if the shape is square)
                    overlayAdapt: true,                 // true if the overlay image has to adapt to the lens size (true/false)
                    zoomLevel: 1                        // zoom level multiplicator (number)
                });
        });
        function ShowDIV() {
            if (comerce1.style.display == "none") {
                comerce1.style.display = "block";
                comerce2.style.display = "none";
            }
            else {
                comerce1.style.display = "none";
                comerce2.style.display = "block";
            }
        }
        function HideDIV() {
            comerce1.style.display = "none";
            comerce2.style.display = "none";
        }
        //-->
    </script>
</head>
<body  onload="myFunction()">

<div class="floatWrapPosters">
    <div class="tekstfelt1">
        <div class="leftWrapper">
            <p class="leftHead"><span class="topLeftHead">the periscope</span><br/>
                <span class="lowerLeftHead">kildespeilet</span></p>
            <?php
            printf('<p class="leftSeries">series / serie %s (1-%s)</p>', $group, count($pictureArray));
            $filename = "./groups/" . $group . "/video.txt";
            // prepare for displaying a video
            if (!file_exists($filename)) {
//                printf('<div class="video">');
//                printf('</div>');
            } else {
                $videoUrl = 'ukjent';
                $data = getcsv($picid, 'video.txt', './groups/' . $group . '/');
                $data0 = getcsv(0, 'video.txt', './groups/' . $group . '/');
                if ($data != null) {
                    $videoUrl = trim($data[1]);
                } else {
                    $videoUrl = trim($data0[1]);
                }
                if ($data != null || $data0 != null) {
                    printf('<div class="video">');
                    printf("<iframe width=\"260\" height=\"200\" src=\"%s\"></iframe>", $videoUrl);
                    printf('</div>');
                } else {
//                    printf('<div class="video">');
//                    printf('</div>');
                }
            }
            }
            ?>
            <?php printf($groupText); ?>
        </div>
    </div>
    <div id="plansjeDiv">
        <?php
        printf("<img id=\"%s\" src=\"./groups/%s/images/%s\"  class=\"imageDiv\" alt=\"%s\" data-big=\"./groups/%s/images/%s\" />",
            $loupeId, $group, $pictureArray[$picid], $pictureArray[$picid], $group, $pictureArray[$picid]);
        ?>
    </div>
    <div class="tekstfelt2">
        <div class="control">
            <?php ?>
            <?php printf('<h4>Pictures in this theme:<br/>Bilder i dette tema:</h4>'); ?>
            <div class="pictureLine">
                <?php
                // Display a one line list of group files
                $pid = 0;
                $currentFile = basename($_SERVER['PHP_SELF']);
                foreach ($pictureArray as $pic) {
                    $style = 'font-size: 18px';
                    if ($picid == $pid) {
                        $style = 'font-size: 20px; font-weight: bold; color: #e36c0b';
                    }
                    $a1 = str_replace('.jpg', '', $pic);
                    $displayName = substr($a1, -4);
                    printf("<a href=\"%s?group=%s&amp;picid=%s\" title=\"%s\"><span style=\"%s\">%s</span></a> ",
                        $currentFile, $group, $pid, $displayName, $style, $pid + 1);
                    $pid++;
                }
                $a1 = str_replace('.jpg', '', $pictureArray[$picid]);
                $pos = strpos($a1, '0');
                $displayName = substr($a1, $pos);
                ?>
            </div>
            <div class="arrow">
                <?php
                $forwVisible = $backVisible ='visible';
                $forID = 'next';
                $bacID = 'prev';
                if ($picid == 0) {
                    $backVisible = 'hidden';
                    $bacID = 'disable';
                }
                if ($picid == count($pictureArray) - 1) {
                    $forwVisible = 'hidden';
                    $forID = 'disable';
                }
                printf("<span style=\"visibility: %s\"><a id=\"%s\" href=\"%s?group=%s&amp;picid=%s\" title='previous' >&#8592;</a></span>",
                    $backVisible, $bacID, $currentFile, $group, $picid - 1);
                printf("<span style=\"visibility: %s\"><a id=\"%s\" href=\"%s?group=%s&amp;picid=%s\" title='next' > &#8594;</a></span>",
                    $forwVisible, $forID, $currentFile, $group, $picid + 1);
                ?>
            </div>
            <?php
            //  turn magnifying glass on or off
            $fileWithParams = $_SERVER['REQUEST_URI'];
            if ($loupe == '') {
                $fileWithParams = "{$fileWithParams}&amp;loupe=1";
            } elseif ($loupe == 0) {
                $fileWithParams = str_replace('loupe=0', 'loupe=1', $fileWithParams);
                $loupe = 1;
            } elseif ($loupe == 1) {
                $fileWithParams = str_replace('loupe=1', 'loupe=0', $fileWithParams);
                $loupe = 0;
            }
            ?>
            <div class="magnifier">
                Magnifier / Lupe:
                <a href="<?php printf($fileWithParams); ?>">
                    <button type="button" class="magnifyButton"><?php printf("%s / %s", $elStatus, $lStatus) ?></button>
                </a>
            </div>
            <a href="./">
                <button type="button" class="returnButton">Back to overview.<br/>Tilbake til oversikt.</button>
            </a>
        </div>

        <div id="comerce1">
            <hr>
            <p><strong>Bodvar Schjelderup<br/>PUBLICATIONS</strong></p>
            <p>BOOKS, BOOKLETS</p>
            <p><strong>Evidence</strong> (1986) E<br/>
                (the Great Pyramid, sacred geometry)</p>
            <p><strong>Den lysende broen</strong> (1991) N<br/>
                (Marian apparitions)</p>
            <p><strong>Pilegrim/Pilgrim...</strong> (1992)<br/>
                (meditations;23 languages)</p>
            <p><strong>Loggbok for en helgen</strong> (1997) N<br/>
                (Saint Olav: a study of signals)</p>
            <p><strong>The Way to the Middle</strong> (2004) E<br/>
                (extended version of Evidence)</p>
            <p><strong>Table Five</strong> (2006) E<br/>
                (Decalogue & bible code readings)</p>
            <p><strong>A Riddle of Rings</strong> (2006) E<br/>
                (Danish ring castles, a study)</p>
            <p><strong>Mirror of Recognitions</strong> (2006) E<br/>
                (body & chakra ladder – a study)</p>
            <p><strong>Ageless Testament A, B</strong> (2011) E<br/>
                (synoptic study: sacred geography,
                symbols, Great Pyramid, religion ...)</p>
            <p><strong>Fra ordspor til kildebilde</strong> (2015) N<br/>
                (ideas, proposals, poetry, projects)</p>
            <p><strong>Gjemt er ikke glemt</strong> (2015) N<br/>
                (kortversjon av Loggbok for en helgen)</p>
            <div style="text-align: right;margin-right: 20px"><a href="javascript:HideDIV()">hide...</a></div>
        </div>
        <div id="comerce2">
            <hr>

            <p><strong>Bodvar Schjelderup<br/>PUBLICATIONS</strong></p>
            <p>EXHIBITIONS</p>
            <p><strong>Steinene synger / The Stones Sing
                    / Es singen die Steine</strong> (1989)<br/>4 lang.
                (Oslo, Düsseldorf, Tallinn, Budapest...)</p>
            <p><strong>Morgentegnet /Sign of Daybreak</strong><br/>
                (St Olav 1000 years, a study)
                (Trondheim, Reykjavik, Oslo...)</p>
            <p><strong>The House of Memory</strong> (2003)<br/>
                (Gt Pyramid studies; 10 languages)
                (Library of Alexandria)</p>
            <p><strong>Unfolding the World</strong> (2003)<br/>
                (sacred geography; 10 languages)
                (Library of Alexandria)</p>
            <p><strong>Mercator’s Window (2012)</strong> E,N<br/>
                (sacred geography) (Trondheim)</p>
            <p><strong>The Jerusalem Signal</strong> (2012) E,N<br/>
                (Jesus’ Jerusalem signature) (Trh.)</p>
            <div style="text-align: right;margin-right: 20px"><a href="javascript:HideDIV()">hide...</a></div>
        </div>
        <div class="container">
            <div class="text">
                <a href="javascript:ShowDIV()">Bodvar Schjelderup's publications..</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
