<?php
require("../includes/config.php");
$size = $_GET["size"];
if ($size == "" or "normal") {
    $width = "750";
    $height = "550";
    $font = "10";
}
if ($size == "tiny") {
    $width = "475";
    $height = "350";
    $font = "8";
}
if ($size == "large") {
    $width = "1150";
    $height = "840";
    $font = "14";
}
if ($size == "huge") {
    $width = "1750";
    $height = "1280";
    $font = "19";
}
$query = $MySQLi->query("SELECT * FROM mq_settings LIMIT 1");
$fetch = $query->fetch_assoc();
$CoreSWF = $fetch['gameSWF'];
$sitename = $fetch['DFSitename'];
$MySQLi->close();
?>
<html lang="en" dir="ltr">
<head>
    <title><?php echo $sitename; ?> | Play</title>
    <link rel="stylesheet" href="../includes/css/style.css"/>
    <link rel="shortcut icon" href="../includes/favicon.ico"/>
    <script src="../includes/scripts/AC_RunActiveContent.js" type="text/javascript"></script>
    <script src="../includes/scripts/extra.js" type="text/javascript"></script>

    <meta charset="utf-8"/>
    <!--[if lt IE 9]>
    <script src="https://raw.githubusercontent.com/aFarkas/html5shiv/master/src/html5shiv.js"></script><![endif]-->
</head>
<body onload="pageLoaded()">
<section id="window">
    <section id="outsideWindow">
        <section id="gameWindow" style="width:<?php
        echo $width;
        ?>; height:<?php
        echo $height;
        ?>;">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="<?php echo $width; ?>" height="<?php echo $height; ?>" align="middle">
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="movie" value=""<?php echo $CoreSWF; ?>" />
                <param name="menu" value="false" />
                <param name="BGCOLOR" value="#072438" />
                <param name="SCALE" value="exactfit" />
                <embed src="<?php echo $CoreSWF; ?>" name="FFable" width="<?php echo $width; ?>" height="<?php echo $height; ?>" align="middle" bgcolor="#072438" menu="false" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" scale="exactfit" swLiveConnect="true" />
            </object>
            <section id="linkWindow">
                        <span>
                        <span>
                            <a href="index.php">Play</a> | 
                            <a href="../mq-signup.php">Register</a> | 
                            <a href="../top100.php">Top100</a> | 
                            <a href="../mb-bugTrack.php">Submit Bug</a> | 
                            <a href="../mq-lostpassword.php">Lost Password</a>
                        </span>
            </section>
        </section>
    </section>
</section>
</body>
</html>