<?php
/*
 * AlphaMech (MechQuest Private Server) 
 * Made by MentalBlank
 * File: mb-bugTrack - v0.0.1
 */

require("includes/config.php");
$query = $MySQLi->query("SELECT * FROM mq_settings LIMIT 1");
$fetch = $query->fetch_assoc();
$sitename = $fetch['DFSitename'];
$adminEmail = $fetch['AdminEmail'];

if (isset($_POST['How'])) {
    $email_to = $adminEmail;
    $email_subject = "AlphaMech Bug Report";

    $type = $_POST['Type'];
    $how = $_POST['How'];
    $recurring = $_POST['recurring'];
    $user = $_POST['charname'] . " (Character: " . $_POST['charname'] . ")";

    $string_exp = "/^[A-Za-z .'-]+$/";

    function clean_string($string)
    {
        $bad = ["content-type", "bcc:", "to:", "cc:", "href"];
        return str_replace($bad, "", $string);
    }

    if (strlen($how) < 1) {
        $EmailResult = "We are very sorry, but there were error(s) found with the form you submitted.<br />Please go back and fix these errors:<br /><br /><b>No information provided by user.</b><br /><br /><a href='{$_SERVER['PHP_SELF']}'>Back</a><br />";
    } else {
        $email_message = "Bug details below.\n\n";
        $email_message .= "Type: " . clean_string($type) . "\n";
        $email_message .= "How: " . clean_string($how) . "\n";
        $email_message .= "Reccuring: " . clean_string($recurring) . "\n";
        $email_message .= "User: " . clean_string($user) . "\n";

        // create email headers

        $headers = "From: bugs@{$_SERVER['SERVER_NAME']}\r\n" . "Reply-To: bugs@{$_SERVER['SERVER_NAME']}\r\n" . 'X-Mailer: PHP/' . phpversion();

        mail($email_to, $email_subject, $email_message, $headers);
        $EmailResult = "Your bug report has been sent, please wait patiently for it to be fixed.";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="includes/css/style.css"/>
    <link rel="shortcut icon" href="includes/favicon.ico"/>

    <title><?php echo $sitename; ?> | Bug Tracker</title>
</head>
<body>
<br/><a href="game/index.php"><img src="images/logo.png" width="300px"/></a><br/>
<section class="downloaded" style="width:500px;">
    <?php
    if (isset($_POST['How'])) {
        echo $EmailResult;
    } else {
        ?>
        <form method='post' name='submit'>
            <h2>Submit a Bug Report</h2>
            What type of problem is it?:<br/>
            <select NAME="Type">
                <option value="Character / Inventory / Dragons">Character / Inventory</option>
                <option value="Town / Quest / Scene / Zone">Town / Quest / Scene / Zone</option>
                <option value="Shop / Item">Shop / Item</option>
                <option value="NPCs / Pets / Guests">NPCs / Pets / Guests</option>
                <option value="Interfaces">Interfaces</option>
                <option value="Other Problems">Other Problems</option>
            </select><br/>
            <br/>What Happened?:<br/>
            <textarea NAME="How" rows="10" cols="60"
                      placeholder="What is the problem and how did it happen?"></textarea>
            <br/>
            <br/>Is it a recurring problem?:<br/>
            <select NAME="recurring">
                <option value='No'>No</option>
                <option value='Yes'>Yes</option>
            </select><br/>
            <br/>What is your Username?:<br/>
            <input name="username" placeholder="username"><br/>
            <br/>What is your Character name?:<br/>
            <input name="charname" placeholder="character name"><br/>
            <br/><input type='submit' name='bugs' value='Submit Bug'>
        </form>
        <?php
    }
    ?>
</section>
<section id="linkWindow"><br/>
    <span>
                        <span>
                            <a href="game/">Play</a> | 
                            <a href="mq-signup.php">Register</a> | 
                            <a href="top100.php">Top100</a> | 
                            <a href="mb-bugTrack.php">Submit Bug</a> | 
                            <a href="mq-lostpassword.php">Lost Password</a>
                        </span>
</section>
</body>
</html>