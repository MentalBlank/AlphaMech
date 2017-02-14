<?php
/*
 * AlphaMech (MechQuest Private Server)
 * Made by MentalBlank
 * File: mb-fileGrab - v0.0.1
 */
$urlDF = 'http://mechquest.battleon.com/game/gamefiles/';
require("../includes/config.php");
if ($MySQLi->connect_errno) {
    die("Failed to connect to MySQL: (" . $MySQLi->connect_error . ")");
}
error_reporting(0);
set_time_limit(999999999999);
$rangeMin = 1;
$rangeMax = 50000;
?>

<html>
<head>
    <title>Download SWF From DF</title>
    <style>
        html, body {
            min-height: 100%;
            background-color: #eee;
            max-width: 98%;
        }

        .downloaded {
            background-color: #fff;
            width: 500px;
            margin-left: auto;
            margin-right: auto;
            padding: 10px 20px;
            border-radius: 5px 2px 2px 5px;
            max-height: 475px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<table align="center">
    <th>
        <h2>AlphaMech SWF Downloader</h2>
        <section class="downloaded">
            <?php

            function CheckCreateDir($urlBase, $urlFile, $class)
            {
                switch (strtolower($_GET['m'])) {
                    case 'items':
                        $urlComplete = $urlBase . $urlFile;
                        $urlFull = str_replace("game/", "", $urlComplete);
                        break;
                    case 'hairs':
                        if ($class == 2) {
                            $urlComplete = $urlBase . $urlFile;
                        } else {
                            $urlComplete = $urlBase . $urlFile;
                        }
                        $urlFull = str_replace("game/", "", $urlComplete);
                        break;
                    case 'maps':
                        $urlComplete = $urlBase . "maps/" . $urlFile;
                        $urlFull = str_replace("game/", "", $urlComplete);
                        break;
                    case 'classes':
                        if ($class == 2) {
                            $urlComplete = $urlBase . "classes/F/" . $urlFile;
                        } else {
                            $urlComplete = $urlBase . "classes/M/" . $urlFile;
                        }
                        $urlFull = str_replace("game/", "", $urlComplete);
                        break;
                }
                $urlPath = parse_url($urlFull);
                $urlPath = $urlPath["path"];
                $urlPath = str_replace("/$urlPath", "", $urlPath);
                $urlPath = preg_split('(/)', $urlPath, -1, PREG_SPLIT_NO_EMPTY);
                for ($a = 0; $a < count($urlPath) - 1; $a++) {
                    if (!file_exists($urlPath[$a])) {
                        echo("Made Directory: " . $urlPath[$a] . "<br />");
                        mkdir($urlPath[$a]);
                        chdir($urlPath[$a]);
                    } else {
                        chdir($urlPath[$a]);
                    }
                }
                for ($a; $a > 1; $a--) {
                    chdir("../");
                }
            }

            switch (strtolower($_GET['m'])) {
                case 'items':
                    $itemQuery = $MySQLi->query("SELECT strFileName, strItemName FROM mq_items WHERE `ItemID` BETWEEN {$rangeMin} AND {$rangeMax}");
                    while ($item = $itemQuery->fetch_assoc()) {
                        $item['strFileName'] = trim($item['strFileName']);
                        if ($item['strFileName'] != NULL && $item['strFileName'] != "") {
                            CheckCreateDir($urlDF, $item['strFileName'], 0);
                            if (!file_exists("{$item['strFileName']}")) {
                                if (preg_match('#^/#i', $item['strFileName']) === 1) {
                                    $str = ltrim($item['strFileName'], '/');
                                } else {
                                    $str = $item['strFileName'];
                                }
                                $str = str_replace(" ", "%20", $str);
                                copy($urlDF . $str, "{$str}");
                                if (!file_exists("{$str}")) {
                                    $failedItems[$str] = $item['strItemName'];
                                    array_unique($failedItems);
                                } else {
									echo("Downloaded: {$strItemName}<br/>");
								}
                            }
                            chdir("../");
                        }
                    }
                    if (isset($failedItems)) {
                        foreach ($failedItems as $fileURL => $strFileName) {
                            echo "Failed: {$strFileName} - <a href=\"{$urlDF}{$fileURL}\" target=\"_blank\">Manual Download</a><br>";
                        }
                    } else {
                        echo "All Items have been downloaded.";
                    }
                    break;
                case 'classes':
                    $itemQuery = $MySQLi->query("SELECT strClassFileName,strClassName FROM mq_class WHERE `ClassID` BETWEEN {$rangeMin} AND {$rangeMax}");
                    while ($item = $itemQuery->fetch_assoc()) {
                        $item['strClassName'] = trim($item['strClassName']);
                        CheckCreateDir($urlDF, $item['strClassFileName'], 1);
                        if (!file_exists("classes/M/{$item['strClassFileName']}")) {
                            copy("{$urlDF}classes/M/{$item['strClassFileName']}", "classes/M/{$item['strClassFileName']}");
                            if (!file_exists("classes/M/{$item['strClassFileName']}")) {
                                $failedClasses[$item['strClassFileName']] = $item['strClassName'];
                                array_unique($failedClasses);
                            } else {
									echo("Downloaded: {$strClassName}<br/>");
								}
                        }
                        chdir("../");
                        CheckCreateDir($urlDF, $item['strClassFileName'], 2);
                        if (!file_exists("classes/F/{$item['strClassFileName']}")) {
                            copy("{$urlDF}classes/F/{$item['strClassFileName']}", "classes/F/{$item['strClassFileName']}");
                            if (!file_exists("classes/F/{$item['strClassFileName']}")) {
                                $failedClasses2[$item['strClassFileName']] = $item['strClassName'];
                                array_unique($failedClasses2);
                            }
                        }
                        chdir("../");
                    }
                    if (isset($failedClasses) || isset($failedClasses2)) {
                        foreach ($failedClasses as $fileURL => $strFileName) {
                            echo "Failed: {$strFileName} (M) - <a href=\"{$urlDF}classes/M/{$fileURL}\" target=\"_blank\">Manual Download</a><br>";
                        }
                        foreach ($failedClasses2 as $fileURL => $strFileName) {
                            echo "Failed: {$strFileName} (F) - <a href=\"{$urlDF}classes/F/{$fileURL}\" target=\"_blank\">Manual Download</a><br>";
                        }
                    } else {
                        echo "All Classes have been downloaded.";
                    }
                    break;
                case 'maps':
                    $itemQuery = $MySQLi->query("SELECT FileName, Name FROM mq_quests WHERE `QuestID` BETWEEN {$rangeMin} AND {$rangeMax}");
                    while ($item = $itemQuery->fetch_assoc()) {
                        $item['FileName'] = trim($item['FileName']);
                        CheckCreateDir($urlDF, $item['FileName'], 0);
                        if (!file_exists("maps/{$item['FileName']}")) {
                            copy($urlDF . "maps/" . $item['FileName'], "maps/{$item['FileName']}");
                            if (!file_exists("maps/{$item['FileName']}")) {
                                $failedItems[$item['FileName']] = $item['Name'];
                                array_unique($failedItems);
                            } else {
									echo("Downloaded: {$Name}<br/>");
								}
                        }
                        chdir("../");
                    }
                    if (isset($failedItems)) {
                        foreach ($failedItems as $fileURL => $FileName) {
                            echo "Failed: {$FileName} - <a href=\"{$urlDF}maps/{$fileURL}\" target=\"_blank\">Manual Download</a><br>";
                        }
                    } else {
                        echo "All Maps have been downloaded.";
                    }
                    break;
                case 'hairs':
                    $itemQuery = $MySQLi->query("SELECT HairSWF,HairName,Gender FROM mq_hairs WHERE `HairID` BETWEEN {$rangeMin} AND {$rangeMax} ");
                    while ($item = $itemQuery->fetch_assoc()) {
                        $item['HairSWF'] = trim($item['HairSWF']);
                        CheckCreateDir($urlDF, $item['HairSWF'], 0);
                        if (!file_exists("{$item['HairSWF']}")) {
                            copy("{$urlDF}{$item['HairSWF']}", "{$item['HairSWF']}");
                            if (!file_exists("{$item['HairSWF']}")) {
                                if ($item['Gender'] == "F") {
                                    $failedItems2[$item['HairSWF']] = $item['HairName'];
                                    array_unique($failedItems2);
                                } else {
                                    $failedItems[$item['HairSWF']] = $item['HairName'];
                                    array_unique($failedItems);
                                }
                            } else {
								echo("Downloaded: {$HairName}<br/>");
							}
                        }
                        chdir("../");
                    }
                    if (isset($failedItems)) {
                        foreach ($failedItems as $fileURL => $HairSWF) {
                            echo "Failed: {$HairSWF} (M) - <a href=\"{$urlDF}head/M/{$fileURL}\" target=\"_blank\">Manual Download</a><br>";
                        }
                        foreach ($failedItems2 as $fileURL => $HairSWF) {
                            echo "Failed: {$HairSWF} (F) - <a href=\"{$urlDF}head/F/{$fileURL}\" target=\"_blank\">Manual Download</a><br>";
                        }
                    } else {
                        echo "All Hairs have been downloaded.";
                    }
                    break;
                default:
                    echo('<a href="?m=items">Download Items</a><br>');
                    echo('<a href="?m=classes">Download Classes</a><br>');
                    echo('<a href="?m=maps">Download Maps</a><br>');
                    echo('<a href="?m=hairs">Download Hairs</a><br>');
            }
            ?>
        </section>
    </th>
</table>
<br>
</body>
</html>