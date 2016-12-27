<?php
/**
 * Created by PhpStorm.
 * User: arne
 * Date: 16/07/15
 * Time: 09:17
 */
/* Return a text string from a CSV-file
 * Parameters:
 * 	$OptionName - First field (Key) in a line
 * 	$filename - Name of file in directory /options
 */
function getcsv($OptionName, $filename, $directory='..'){
    $csvfile = "$directory/$filename";
    if (($handle = fopen($csvfile, 'r')) != FALSE) {
        while (($data = fgetcsv($handle, 0, ";")) != FALSE) {
            if($data[0] == $OptionName){
                return $data;
            }
        }
    }
}
function singleGroup($groupNo, $lang){
    $template = 'posters.php';
    $data = getcsv($groupNo, 'groups.txt','./groups/');
    if(trim($data[3]) == 'false'){
        $class = 'disabled';
    }else{
        $class = 'enabled';
    }
    $singleString = "<a class=\"%s\" href=\"%s?group=%s\"><strong>%s</strong></a><span class=\"%s\" > %s. </span>";
    printf($singleString, $class, $template, $groupNo, $groupNo, $class, $data[$lang]);
}
function doubleGroup($groupNo1, $groupNo2, $lang){
    $template = 'posters.php';
    $data1 = getcsv($groupNo1, 'groups.txt','./groups/');
    if(trim($data1[3]) == 'false'){
        $class1 = 'disabled';
    }else{
        $class1 = 'enabled';
    }
    $data2 = getcsv($groupNo2, 'groups.txt','./groups/');
    if(trim($data2[3]) == 'false'){
        $class2 = 'disabled';
    }else{
        $class2 = 'enabled';
    }
    if($class1 == 'disabled' && $class2 == 'disabled'){
        $class3 = 'disabled';
    }else{
        $class3 = 'enabled';
    }
    $doubleString = "<a class=\"%s\" href=\"%s?group=%s\"><strong>%s</strong>-</a><a class=\"%s\" href=\"%s?group=%s\"><strong>%s</strong></a><span class=\"%s\" > %s. </span>";
    printf($doubleString, $class1, $template, $groupNo1, $groupNo1, $class2, $template, $groupNo2, $groupNo2, $class3, $data1[$lang]);
}

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