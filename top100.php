<?php
include('includes/config.php');
$query = $MySQLi->query("SELECT * FROM mq_settings LIMIT 1");
$fetch = $query->fetch_assoc();
$sitename = $fetch['DFSitename'];
if (filter_input(INPUT_GET, 'order') == "name" || filter_input(INPUT_GET, 'order') == "level" || filter_input(INPUT_GET, 'order') == "classid" || filter_input(INPUT_GET, 'order') == "gold" || filter_input(INPUT_GET, 'order') == "coins" || filter_input(INPUT_GET, 'order') == "dragon_amulet" || filter_input(INPUT_GET, 'order') == "userid") {
    $order = filter_input(INPUT_GET, 'order');
} else {
    $order = "intLevel";
}
?>
<head>
    <title><?php echo $sitename; ?> | Top 100</title>
    <link rel="shortcut icon" href="includes/favicon.ico" />
    <link rel="stylesheet" href="includes/css/style.css" />
    
</head>
<div style="text-align: center;">
    <form>
        <table width="548" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr> 
                <td align="center" valign="top" height="173"> 
                    <a href="game/index.php"><img src="images/logo.png" width="300px"/></a><br />

                    <table width="548" border="1" cellspacing="0" cellpadding="5">
                        <tr>
                            <td class='top100Heading'>#</td>
                            <td class='top100Heading'><a href="top100.php?order=name"><b>Character</b></a></td>
                            <td class='top100Heading'><a href="top100.php?order=level"><b>Level</b></a></td>
                            <td class='top100Heading'><a href="top100.php?order=classid"><b>Class</b></a></td>
                            <td class='top100Heading'><a href="top100.php?order=gold"><b>Gold</b></a></td>
                            <td class='top100Heading'><a href="top100.php?order=coins"><b>Coins</b></a></td>
                            <td class='top100Heading'><a href="top100.php?order=dragon_amulet"><b>Upgraded</b></a></td>
                        </tr>
            <?php
            if ($order == "strCharacterName" || $order == "ClassID" || $order == "intDragonAmulet" || $order == "UserID") {
                $character = $MySQLi->query("SELECT * FROM mq_characters ORDER BY ".$order." ASC LIMIT 100");
            } else {
                $character = $MySQLi->query("SELECT * FROM mq_characters ORDER BY intLevel DESC LIMIT 100");
            }

            $i = 0;
            while ($chr = $character->fetch_assoc()) {

                $i = $i + 1;
                $class_query = $MySQLi->query("SELECT strClassName FROM mq_class WHERE ClassID = '{$chr['ClassID']}'");
                $class = $class_query->fetch_assoc();
                $user_query = $MySQLi->query("SELECT name FROM mq_users WHERE id = '{$chr['userid']}'");
                $user = $user_query->fetch_assoc();
                ?>
                <tr>
                    <td class='top100'><p><?php echo $i; ?></p></td>
                    <td class='top100Name'><p><a href="mq-chardetail.php?id=<?php echo $chr["id"]; ?>"><?php echo $chr["strCharacterName"]; ?></a></p></td>
                    <td class='top100'><p><?php echo $chr["intLevel"]; ?></p></td>
                    <td class='top100'><p><?php echo $class["strClassName"]; ?></p></td>
                    <td class='top100'><p><?php echo $chr["intGold"]; ?></p></td>
                    <td class='top100'><p><?php echo $chr["intCoins"]; ?></p></td>
                    <td class='top100'><p><?php
                            if ($chr['dragon_amulet'] == "1" || $user['dragon_amulet'] == 1) {
                                echo "<font style=\"color: gold; font-weight: bold;\">True</font>";
                            } else {
                                echo "False";
                            }
                            ?></p></td>
                </tr>
                <?php
            }
            ?>
        </table>
        </td>
        </tr>
        </table>
    </form>
    <section id="linkWindow">
                        <span>
                            <a href="game/">Play</a> | 
                            <a href="mq-signup.php">Register</a> | 
                            <a href="top100.php">Top100</a> | 
                            <a href="mb-bugTrack.php">Submit Bug</a> | 
                            <a href="mq-lostpassword.php">Lost Password</a>
                        </span>
    </section>
</div>