<?php

/*
 * AlphaFable (DragonFable Private Server) 
 * Made by MentalBlank
 * File: cf-npccharacternew - v0.0.1
 */

include("../includes/classes/Core.class.php");
include('../includes/config.php');

if (isset($_POST['intUserID']) && isset($_POST['strToken'])) {
    $sign = [
        'intUserID' => $MySQLi->real_escape_string($_POST['intUserID']),
        'strUsername' => $MySQLi->real_escape_string($_POST['strUsername']),
        'strPassword' => $MySQLi->real_escape_string($_POST['strPassword']),
        'strToken' => $MySQLi->real_escape_string($_POST['strToken']),
        'intNPC' => $MySQLi->real_escape_string($_POST['intNPC'])
    ];

    $query = [];
    $result = [];

    $query[0] = $MySQLi->query("SELECT * FROM `df_users` WHERE id = '{$sign['intUserID']}' AND LoginToken = '{$sign['strToken']}' ORDER BY id DESC LIMIT 1");
    $result[0] = $query[0]->fetch_assoc();
    if ($query[0]->num_rows == 1) {
        date_default_timezone_set('America/Los_Angeles');
        $dateToday = date('Y\-m\-j\TH\:i\:s\.B');
        switch ($sign['intNPC']) {
            case 1: //Ash DragonBlade
                $MySQLi->query("INSERT INTO df_characters(userid, name, dragon_amulet, HomeTownID, gender, born, hairid, colorhair, colorskin, colorbase, colortrim, classid, BaseClassID, PrevClassID, raceid, hairframe) VALUES('{$sign['intUserID']}', 'Ash Dragonblade', {$result[0]['upgrade']}, 373, 'M', '{$dateToday}', '3', '7027237', '15388042', '12766664', '7570056', '42', '42', '42', 'Human', '1')");
                break;
            case 2: //Alexander
                $MySQLi->query("INSERT INTO df_characters(userid, name, dragon_amulet, HomeTownID, gender, born, hairid, colorhair, colorskin, colorbase, colortrim, classid, BaseClassID, PrevClassID, raceid, hairframe) VALUES('{$sign['intUserID']}', 'Alexander', {$result[0]['upgrade']}, 832, 'M', '{$dateToday}', '3', '7027237', '15388042', '12766664', '7570056', '71', '71', '71', 'Human', '1')");
                break;
        }

        if ($MySQLi->affected_rows > 0) {
            $Core->sendVar('code', 0);
        } else {
            $Core->sendErrorVar('Error!', "There has been an error adding the character to your account.");
        }
    } else {
        $Core->sendErrorVar('Error!', "User information could not be found.");
    }
} else {
    $Core->sendErrorVar('Invalid Data!', 'none');
}
$MySQLi->close();