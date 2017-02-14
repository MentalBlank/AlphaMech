<?php
/*
 * AlphaMech (MechQuest Private Server) 
 * Made by MentalBlank
 * File: mb-dataGrab - v0.0.1
 */

$urlDF = 'http://mechquest.battleon.com/game/';
require("../includes/classes/Ninja.class.php");
require("../includes/classes/Files.class.php");
require("../includes/config.php");
error_reporting(0);
set_time_limit(999999999999);

//UserInfo
$PId = "666666";
$PToken = "KKKKKKKKKK";

//Quests
$TS = "1";
$TE = "500";

//Shops
$SS = "1";
$SE = "500";

//Merge Shops
$MSS = "1";
$MSE = "20";

//Classes
$CS = "1";
$CE = "300";

//Hair Shops
$HSS = "1";
$HSE = "200";
?>

<html>
<head>
    <title>Grab From MQ</title>
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
        <h2>AlphaMech Data Grabber / Updater</h2>
        <section class="downloaded">
            <?php
            switch (strtolower($_GET['m'])) {
                case 'quests':
                    for ($intQuestID = $TS; $intQuestID <= $TE; $intQuestID++) {
                        $XML_PAYLOAD = $Ninja->encryptNinja("<flash><strToken>{$PToken}</strToken><intCharID>{$PId}</intCharID><intQuestID>{$intQuestID}</intQuestID></flash>");
                        $XML_POST_URL = "{$urlDF}cf-questload.asp";

                        $result = $Files->dfCurl($XML_POST_URL, $XML_PAYLOAD);
                        $xml = simplexml_load_string($result);
						
                        $QuestID = $xml->quest["QuestID"];
                        $strName = mysqli_real_escape_string($MySQLi, $xml->quest["strName"]);
                        $strDescription = mysqli_real_escape_string($MySQLi, $xml->quest["strDescription"]);
                        $strComplete = mysqli_real_escape_string($MySQLi, $xml->quest["strComplete"]);
                        $strFileName = mysqli_real_escape_string($MySQLi, $xml->quest["strFileName"]);
                        $intMaxGold = $xml->quest["intMaxGold"];
                        $intMaxExp = $xml->quest["intMaxExp"];

                        if ($intQuestID == $QuestID) {
                            $items = $MySQLi->query("SELECT * FROM mq_quests WHERE QuestID = '{$QuestID}'");
                            if ($items->num_rows == 0) {
                                $MySQLi->query("INSERT INTO `mq_quests` (`id`, `QuestID`, `Name`, `Description`, `Complete`, `FileName`, `MaxGold`, `MaxExp`) VALUES (NULL, '{$QuestID}', '{$strName}', '{$strDescription}', '{$strComplete}', '{$strFileName}', '{$intMaxGold}', '{$intMaxExp}');");
                                echo("Quest {$QuestID}: Quest Data Added to Database<br />");
                                $grabbedItems2++;
                            } else {
                                $MySQLi->query("UPDATE `mq_quests` SET `Name` = '{$strName}', `Description` = '{$strDescription}', `Complete` = '{$strComplete}', `FileName` = '{$strFileName}', `MaxGold` = '{$intMaxGold}', `MaxExp` = '{$intMaxExp}' WHERE `QuestID` = '{$intQuestID}'");
                                if ($MySQLi->affected_rows > 0) {
                                    echo("Quest {$QuestID}: Quest Data Updated<br />");
                                    $updatedItems2++;
                                }
                            }
                        }
                    }
                    echo "Search Complete.<br />";
                    if ($grabbedItems2 > 0) {
                        echo "Quests Downloaded: {$grabbedItems2}<br />";
                    }
                    if ($updatedItems2 > 0) {
                        echo "Quests Updated: {$updatedItems2}<br />";
                    }
                    break;
                case 'class':
                    for ($intClass = $CS; $intClass <= $CE; $intClass++) {
                        $XML_PAYLOAD = $Ninja->encryptNinja("<flash><strToken>{$PToken}</strToken><intCharID>{$PId}</intCharID><intClassID>" . $intClass . "</intClassID></flash>");
                        $XML_POST_URL = "{$urlDF}cf-classload.asp";
                        $result = $Files->dfCurl($XML_POST_URL, $XML_PAYLOAD);
                        $xml = simplexml_load_string($result);
die($result);
                        $ClassID = $xml->character["ClassID"];
                        $strClassName = mysqli_real_escape_string($MySQLi, $xml->character["strClassName"]);
                        $strClassFileName = mysqli_real_escape_string($MySQLi, $xml->character['strClassFileName']);
                        $strArmorName = mysqli_real_escape_string($MySQLi, $xml->character['strArmorName']);
                        $strArmorDescription = mysqli_real_escape_string($MySQLi, $xml->character['strArmorDescription']);
                        $strArmorResists = mysqli_real_escape_string($MySQLi, $xml->character['strArmorResists']);
                        $intDefMelee = $xml->character['intDefMelee'];
                        $intDefRange = $xml->character['intDefRange'];
                        $intDefMagic = $xml->character['intDefMagic'];
                        $intParry = $xml->character['intParry'];
                        $intDodge = $xml->character['intDodge'];
                        $intBlock = $xml->character['intBlock'];
                        $strWeaponName = mysqli_real_escape_string($MySQLi, $xml->character['strWeaponName']);
                        $strWeaponDescription = mysqli_real_escape_string($MySQLi, $xml->character['strWeaponDescription']);
                        $strWeaponDesignInfo = mysqli_real_escape_string($MySQLi, $xml->character['strWeaponDesignInfo']);
                        $strWeaponResists = mysqli_real_escape_string($MySQLi, $xml->character['strWeaponResists']);
                        $intWeaponLevel = $xml->character['intWeaponLevel'];
                        $strWeaponIcon = mysqli_real_escape_string($MySQLi, $xml->character['strWeaponIcon']);
                        $strType = mysqli_real_escape_string($MySQLi, $xml->character['strType']);
                        $strItemType = mysqli_real_escape_string($MySQLi, $xml->character['strItemType']);
                        $intCrit = $xml->character['intCrit'];
                        $intDmgMin = $xml->character['intDmgMin'];
                        $intDmgMax = $xml->character['intDmgMax'];
                        $intBonus = $xml->character['intBonus'];
                        $strElement = mysqli_real_escape_string($MySQLi, $xml->character['strElement']);

                        if ($intClass == $ClassID && $ClassID != NULL) {
                            $items = $MySQLi->query("SELECT * FROM mq_class WHERE ClassID = '{$ClassID}'");
                            if ($items->num_rows == 0) {
                                $MySQLi->query("INSERT INTO `mq_class` (`id`, `ClassID`, `ClassName`, `ClassSWF`, `ArmorName`, `ArmorDescription`, `ArmorResists`, `DefMelee`, `DefPierce`, `DefMagic`, `Parry`, `Dodge`, `Block`, `WeaponName`, `WeaponDescription`, `WeaponDesignInfo`, `WeaponResists`, `WeaponLevel`, `WeaponIcon`, `Type`, `ItemType`, `Crit`, `DmgMin`, `DmgMax`, `Bonus`, `Element`, `Save`) VALUES (NULL, '{$ClassID}', '{$strClassName}', '{$strClassFileName}', '{$strArmorName}', '{$strArmorDescription}', '{$strArmorResists}', '{$intDefMelee}', '{$intDefRange}', '{$intDefMagic}', '{$intParry}', '{$intDodge}', '{$intBlock}', '{$strWeaponName}', '{$strWeaponDescription}', '{$strWeaponDesignInfo}', '{$strWeaponResists}', '{$intWeaponLevel}', '{$strWeaponIcon}', '{$strType}', '{$strItemType}', '{$intCrit}', '{$intDmgMin}', '{$intDmgMax}', '{$intBonus}', '{$strElement}', '1');");
                                echo("Class {$ClassID}: Added to Database<br />");
                                $grabbedItems++;
                            } else {
                                $MySQLi->query("UPDATE `mq_class` SET `ClassName` = '{$strClassName}', `ClassSWF` = '{$strClassFileName}', `ArmorName` = '{$strArmorName}', `ArmorDescription` = '{$strArmorDescription}', `ArmorResists` = '{$strArmorResists}', `DefMelee` = '{$intDefMelee}', `DefPierce` = '{$intDefRange}', `DefMagic` = '{$intDefMagic}', `Parry` = '{$intParry}', `Dodge` = '{$intDodge}', `Block` = '{$intBlock}', `WeaponName` = '{$strWeaponName}', `WeaponDescription` = '{$strWeaponDescription}', `WeaponDesignInfo` = '{$strWeaponDesignInfo}', `WeaponResists` = '{$strWeaponResists}', `WeaponLevel` = '{$intWeaponLevel}', `WeaponIcon` = '{$strWeaponIcon}', `Type` = '{$strType}', `ItemType` = '{$strItemType}', `Crit` = '{$intCrit}', `DmgMin` = '{$intDmgMin}', `DmgMax` = '{$intDmgMax}', `Bonus` = '{$intBonus}', `Element` = '{$strElement}' WHERE `mq_class`.`ClassID` = {$ClassID};");
                                if ($MySQLi->affected_rows > 0) {
                                    echo("Class {$ClassID}: Updated in Database<br />");
                                    $updatedItems++;
                                }
                            }
                        }
                    }
                    echo "Search Complete.<br />";
                    if ($grabbedItems > 0) {
                        echo "Downloaded: {$grabbedItems}<br />";
                    }
                    if ($updatedItems > 0) {
                        echo "Updated: {$updatedItems}<br />";
                    }
                    break;
                case 'shops':
                    for ($intShopID = $SS; $intShopID <= $SE; $intShopID++) {
                        $XML_PAYLOAD = $Ninja->encryptNinja("<flash><strToken>{$PToken}</strToken><intCharID>{$PId}</intCharID><intShopID>" . $intShopID . "</intShopID></flash>");
                        $XML_POST_URL = "{$urlDF}cf-Shopload.asp";
                        $result = $Files->dfCurl($XML_POST_URL, $XML_PAYLOAD);
                        $xml = simplexml_load_string($result);
                        $ShopID = $xml->shop["ShopID"];
                        $strName = mysqli_real_escape_string($MySQLi, $xml->shop["strCharacterName"]);

                        $TotalItems = count($xml->shop->items);
                        $itemList = '';
                        if ($TotalItems > 0) {
                            for ($a = 0; $a < $TotalItems; $a++) {
 								$i1 = $xml->shop->items[$a]["ItemID"];
                                $i2 = mysqli_real_escape_string($MySQLi, $xml->shop->items[$a]["strItemName"]);
                                $i3 = mysqli_real_escape_string($MySQLi, $xml->shop->items[$a]["strItemDescription"]);
								$i4 = mysqli_real_escape_string($MySQLi, $xml->shop->items[$a]["strFileName"]);
								$i5 = $xml->shop->items[$a]["intRarity"];
								$i6 = $xml->shop->items[$a]["intLevel"];
								$i7 = $xml->shop->items[$a]["intEnergyCost"];
								$i8 = $xml->shop->items[$a]["intCoolDown"];
								$i9 = mysqli_real_escape_string($xml->shop->items[$a]["strIcon"]);
								$i10 = $xml->shop->items[$a]["bitDragonAmulet"];
								$i11 = mysqli_real_escape_string($xml->shop->items[$a]["strElement"]);
								$i12 = mysqli_real_escape_string($xml->shop->items[$a]["strCategory"]);
								$i13 = mysqli_real_escape_string($xml->shop->items[$a]["strEquipSpot"]);
								$i14 = mysqli_real_escape_string($xml->shop->items[$a]["strES"]);
								$i15 = mysqli_real_escape_string($xml->shop->items[$a]["strItemType"]);
								$i16 = $xml->shop->items[$a]["intDmgMin"];
								$i17 = $xml->shop->items[$a]["intDmgMax"];
								$i18 = $xml->shop->items[$a]["intReflex"];
								$i19 = $xml->shop->items[$a]["intPower"];
								$i20 = $xml->shop->items[$a]["intAccuracy"];
								$i21 = $xml->shop->items[$a]["intEfficiency"];
								$i22 = $xml->shop->items[$a]["intPerception"];
								$i23 = $xml->shop->items[$a]["intLuck"];
                                $i24 = $xml->shop->items[$a]["intCrit"];
								$i25 = $xml->shop->items[$a]["intBonus"];
								$i26 = $xml->shop->items[$a]["intDodge"];
								$i27 = $xml->shop->items[$a]["intDefense"];
								$i28 = $xml->shop->items[$a]["intMaxStackSize"];
								$i29 = $xml->shop->items[$a]["ShopItemID"];
								$i30 = $xml->shop->items[$a]["intCount"];
								$i31 = $xml->shop->items[$a]["bitEquipped"];
								$i32 = $xml->shop->items[$a]["bitDefault"];
								$i33 = $xml->shop->items[$a]["bitDestroyable"];
								$i34 = $xml->shop->items[$a]["bitSellable"];
								$i35 = $xml->shop->items[$a]["intCost"];
								$i36 = $xml->shop->items[$a]["intCurrency"];
								$i37 = mysqli_real_escape_string($MySQLi, $xml->shop->items[$a]["strType"]);
								$i38 = $xml->shop->items[$a]["intHP"];
								$i39 = $xml->shop->items[$a]["intEP"];
								$i40 = $xml->shop->items[$a]["intEnergyRegen"];
								$i41 = $xml->shop->items[$a]["intBoost"];
								$i42 = $xml->shop->items[$a]["intHit"];
								$i43 = mysqli_real_escape_string($MySQLi, $xml->shop->items[$a]["strResists"]);
								
                                if ($itemList == '') {
                                    $itemList = $i1;
                                } else {
                                    $itemList = $itemList . ',' . $i1;
                                }
                                $items = $MySQLi->query("SELECT * FROM mq_items WHERE ItemID = '{$i1}'");
                                if ($items->num_rows == 0) {
									
									$MySQLi->query("INSERT INTO `mq_items` (`id`, `ItemID`, `strItemName`, `strItemDescription`, `strFileName`, `intRarity`, `intLevel`, `intEnergyCost`, `intCoolDown`, `strIcon`, `bitDragonAmulet`, `strElement`, `strCategory`, `strEquipSpot`, `strES`, `strItemType`, `intDmgMin`, `intDmgMax`, `intReflex`, `intPower`, `intAccuracy`, `intEfficiency`, `intPerception`, `intLuck`, `intCrit`, `intBonus`, `intDodge`, `intDefense`, `intMaxStackSize`, `ShopItemID`, `intCount`, `bitEquipped`, `bitDefault`, `bitDestroyable`, `bitSellable`, `intCost`, `intCurrency`, `strType`, `intHP`, `intEP`, `intEnergyRegen`, `intBoost`, `intHit`, `strResists`) VALUES (NULL, '{$i1}', '{$i2}', '{$i3}', '{$i4}', '{$i5}', '{$i6}', '{$i7}', '{$i8}', '{$i9}', '{$i10}', '{$i11}', '{$i12}', '{$i13}', '{$i14}', '{$i15}', '{$i16}', '{$i17}', '{$i18}', '{$i19}', '{$i20}', '{$i21}', '{$i22}', '{$i23}', '{$i24}', '{$i25}', '{$i26}', '{$i27}', '{$i28}', '{$i29}', '{$i30}', '{$i31}', '{$i32}', '{$i33}', '{$i34}', '{$i35}', '{$i36}', '{$i37}', '{$i38}', '{$i39}', '{$i40}', '{$i41}', '{$i42}', '{$i43}')");
									
                                    echo("Item {$i1}: Data Added to Database<br />");
                                    $grabbedItems++;
                                } else {
                                    //TODO: UPDATE QUERY
                                    if ($MySQLi->affected_rows > 0) {
                                        echo("Item {$i1}: Data Updated in Database<br />");
                                        $updatedItems++;
                                    }
                                }
                            }
                        }
                        if ($intShopID == $ShopID) {
                            echo("Checking Shop {$ShopID}<br />");
                            $items = $MySQLi->query("SELECT * FROM mq_vendors WHERE ShopID = '{$ShopID}'");
                            if ($items->num_rows == 0) {
                                $MySQLi->query("INSERT INTO `mq_vendors` (`id`, `ShopID`, `ShopName`, `ItemIDs`) VALUES (NULL, '{$ShopID}', '{$strName}', '{$itemList}');");
                                echo("Shop {$ShopID}: Shop Data Added to Database<br />");
                                $grabbedItems2++;
                            } else {
                                $MySQLi->query("UPDATE `mq_vendors` SET `ShopName` = '{$strName}', `ItemIDs` = '{$itemList}' WHERE `ShopID` = {$ShopID};");
                                if ($MySQLi->affected_rows > 0) {
                                    echo("Shop {$ShopID}: Shop Data Updated in Database<br />");
                                    $updatedItems2++;
                                }
                            }
                        }
                    }
                    echo "Search Complete.<br />";
                    if ($grabbedItems > 0) {
                        echo "Items Downloaded: {$grabbedItems}<br />";
                    }
                    if ($grabbedItems2 > 0) {
                        echo "Shops Downloaded: {$grabbedItems2}<br />";
                    }
                    if ($updatedItems > 0) {
                        echo "Items Updated: {$updatedItems}<br />";
                    }
                    if ($updatedItems2 > 0) {
                        echo "Shops Updated: {$updatedItems2}<br />";
                    }
                    break;
                case 'merges':
                    for ($intMergeShop = $MSS; $intMergeShop <= $MSE; $intMergeShop++) {
                        $XML_PAYLOAD = $Ninja->encryptNinja("<flash><strToken>{$PToken}</strToken><intCharID>{$PId}</intCharID><intMergeShopID>" . $intMergeShop . "</intMergeShopID></flash>");
                        $XML_POST_URL = "{$urlDF}cf-mergeshopload.asp";
                        $result = $Files->dfCurl($XML_POST_URL, $XML_PAYLOAD);
						
                        $xml = simplexml_load_string($result);
                        $MergeShop = $xml->mergeshop["MSID"];
                        $strName = mysqli_real_escape_string($MySQLi, $xml->mergeshop["strName"]);

                        $TotalItems = count($xml->mergeshop->items);
                        $itemList = '';
                        if ($TotalItems > 0) {
                            for ($a = 0; $a < $TotalItems; $a++) {
								
								$i1 = $xml->mergeshop->items[$a]["ItemID"];
								$i29 = 0;
								$i30 = 0;
								$i31 = 0;
								$i32 = 0;
								$i33 = 0;
								$i34 = 0;
								$i35 = 0;
								$i36 = 0;
								$i37 = 0;
								$i38 = 0;
								$i39 = 0;
								$i40 = 0;
								$i41 = 0;
								$i42 = 0;
								$i43 = 0;
								
                                $i1 = $xml->mergeshop->items[$a]["NewItemID"];
                                $i2 = mysqli_real_escape_string($MySQLi, $xml->mergeshop->items[$a]["strItemName"]);
                                $i3 = mysqli_real_escape_string($MySQLi, $xml->mergeshop->items[$a]["strItemDescription"]);
								$i4 = mysqli_real_escape_string($MySQLi, $xml->mergeshop->items[$a]["strFileName"]);
								$i5 = $xml->mergeshop->items[$a]["intRarity"];
								$i6 = $xml->mergeshop->items[$a]["intLevel"];
								$i7 = $xml->mergeshop->items[$a]["intEnergyCost"];
								$i8 = $xml->mergeshop->items[$a]["intCoolDown"];
								$i9 = mysqli_real_escape_string($xml->mergeshop->items[$a]["strIcon"]);
								$i10 = $xml->mergeshop->items[$a]["bitDragonAmulet"];
								$i11 = mysqli_real_escape_string($xml->mergeshop->items[$a]["strElement"]);
								$i12 = mysqli_real_escape_string($xml->mergeshop->items[$a]["strCategory"]);
								$i13 = mysqli_real_escape_string($xml->mergeshop->items[$a]["strEquipSpot"]);
								$i14 = mysqli_real_escape_string($xml->mergeshop->items[$a]["strES"]);
								$i15 = mysqli_real_escape_string($xml->mergeshop->items[$a]["strItemType"]);
								$i16 = $xml->mergeshop->items[$a]["intDmgMin"];
								$i17 = $xml->mergeshop->items[$a]["intDmgMax"];
								$i18 = $xml->mergeshop->items[$a]["intReflex"];
								$i19 = $xml->mergeshop->items[$a]["intPower"];
								$i20 = $xml->mergeshop->items[$a]["intAccuracy"];
								$i21 = $xml->mergeshop->items[$a]["intEfficiency"];
								$i22 = $xml->mergeshop->items[$a]["intPerception"];
								$i23 = $xml->mergeshop->items[$a]["intLuck"];
                                $i24 = $xml->mergeshop->items[$a]["intCrit"];
								$i25 = $xml->mergeshop->items[$a]["intBonus"];
								$i26 = $xml->mergeshop->items[$a]["intDodge"];
								$i27 = $xml->mergeshop->items[$a]["intDefense"];
								$i28 = $xml->mergeshop->items[$a]["intMaxStackSize"];

                                $m1 = $xml->mergeshop->items[$a]["NewItemID"];
                                $m2 = $xml->mergeshop->items[$a]["ItemID1"];
                                $m3 = $xml->mergeshop->items[$a]["Item1"];
                                $m4 = $xml->mergeshop->items[$a]["Qty1"];
                                $m5 = $xml->mergeshop->items[$a]["ItemID2"];
                                $m6 = $xml->mergeshop->items[$a]["Item2"];
                                $m7 = $xml->mergeshop->items[$a]["Qty2"];

                                if ($itemList == '') {
                                    $itemList = $m1;
                                } else {
                                    $itemList = $itemList . ',' . $m1;
                                }
                                $items = $MySQLi->query("SELECT * FROM mq_items WHERE ItemID = '{$m1}'");
                                if ($items->num_rows == 0) {
                                    $MySQLi->query("INSERT INTO `mq_items` (`id`, `ItemID`, `strItemName`, `strItemDescription`, `strFileName`, `intRarity`, `intLevel`, `intEnergyCost`, `intCoolDown`, `strIcon`, `bitDragonAmulet`, `strElement`, `strCategory`, `strEquipSpot`, `strES`, `strItemType`, `intDmgMin`, `intDmgMax`, `intReflex`, `intPower`, `intAccuracy`, `intEfficiency`, `intPerception`, `intLuck`, `intCrit`, `intBonus`, `intDodge`, `intDefense`, `intMaxStackSize`, `ShopItemID`, `intCount`, `bitEquipped`, `bitDefault`, `bitDestroyable`, `bitSellable`, `intCost`, `intCurrency`, `strType`, `intHP`, `intEP`, `intEnergyRegen`, `intBoost`, `intHit`, `strResists`) VALUES (NULL, '{$i1}', '{$i2}', '{$i3}', '{$i4}', '{$i5}', '{$i6}', '{$i7}', '{$i8}', '{$i9}', '{$i10}', '{$i11}', '{$i12}', '{$i13}', '{$i14}', '{$i15}', '{$i16}', '{$i17}', '{$i18}', '{$i19}', '{$i20}', '{$i21}', '{$i22}', '{$i23}', '{$i24}', '{$i25}', '{$i26}', '{$i27}', '{$i28}', '{$i29}', '{$i30}', '{$i31}', '{$i32}', '{$i33}', '{$i34}', '{$i35}', '{$i36}', '{$i37}', '{$i38}', '{$i39}', '{$i40}', '{$i41}', '{$i42}', '{$i43}')");
                                    echo("Item {$i1}: Data Added to Database<br />");
                                    $grabbedItems++;
                                } else {
                                    //TODO: UPDATE QUERY
                                }
                                $items = $MySQLi->query("SELECT * FROM mq_merges WHERE ResultID = '{$m1}'");
                                if ($items->num_rows == 0) {
                                    $MySQLi->query("INSERT INTO `mq_merges` (`id`, `ResultID`, `RequiredID1`, `RequiredQTY1`, `RequiredID2`, `RequiredQTY2`) VALUES (NULL, '{$m1}', '{$m2}', '{$m4}', '{$m5}', '{$m7}');");
                                    $grabbedItems2++;
                                } else {
                                    $MySQLi->query("UPDATE `mq_merges` SET `RequiredID1` = '{$m2}', `RequiredQTY1` = '{$m4}', `RequiredID2` = '{$m5}', `RequiredQTY2` = '{$m7}' WHERE `mq_merges`.`ResultID` = {$m1}");
                                    if ($MySQLi->affected_rows > 0) {
                                        $updatedItems2++;
                                    }
                                }
                            }
                        }
                        if ($intMergeShop == $MergeShop) {
                            $items = $MySQLi->query("SELECT * FROM mq_merge_vendors WHERE ShopID = '{$MergeShop}'");
                            if ($items->num_rows == 0) {
                                $MySQLi->query("INSERT INTO `mq_merge_vendors` (`id`, `ShopID`, `ShopName`, `ItemIDs`) VALUES (NULL, '{$MergeShop}', '{$strName}', '{$itemList}');");
                                echo("Merge Shop {$MergeShop}: Shop Data Added to Database<br />");
                                $grabbedItems3++;
                            } else {
                                $MySQLi->query("UPDATE `mq_merge_vendors` SET `ShopName` = '{$strName}', `ItemIDs` = '{$itemList}' WHERE `ShopID` = {$MergeShop};");
                                if ($MySQLi->affected_rows > 0) {
                                    echo("Merge Shop {$MergeShop}: Shop Data Updated Database<br />");
                                    $updatedItems3++;
                                }
                            }
                        }
                    }
                    echo "Search Complete.<br />";
                    if ($grabbedItems > 0) {
                        echo "Items Downloaded: {$grabbedItems}<br />";
                    }
                    if ($grabbedItems2 > 0) {
                        echo "Merges Downloaded: {$grabbedItems2}<br />";
                    }
                    if ($grabbedItems3 > 0) {
                        echo "Shops Downloaded: {$grabbedItems3}<br />";
                    }
                    if ($updatedItems > 0) {
                        echo "Updated: {$updatedItems}<br />";
                    }
                    if ($updatedItems2 > 0) {
                        echo "Merges Updated: {$updatedItems2}<br />";
                    }
                    if ($updatedItems3 > 0) {
                        echo "Shops Updated: {$updatedItems3}<br />";
                    }
                    break;
                case 'hairs':
                    for ($intHairShop = $HSS; $intHairShop <= $HSE; $intHairShop++) {
                        $XML_PAYLOAD = $Ninja->encryptNinja("<flash><strToken>{$PToken}</strToken><intCharID>{$PId}</intCharID><intHairShopID>" . $intHairShop . "</intHairShopID><strGender>M</strGender></flash>");
                        $XML_POST_URL = "{$urlDF}cf-hairshopload.asp";
                        $result = $Files->dfCurl($XML_POST_URL, $XML_PAYLOAD);
die($result);
                        $xml = simplexml_load_string($result);
                        $xml = $Ninja->decodeNinja($xml);
                        $xml = simplexml_load_string($xml);

                        $strName = mysqli_real_escape_string($MySQLi, $xml->HairShop["strHairShopName"]);
                        $strFile = mysqli_real_escape_string($MySQLi, $xml->HairShop["strFileName"]);
                        $TotalItems = count($xml->HairShop->hair);
                        $itemList = '';
                        if ($TotalItems > 0) {
                            for ($a = 0; $a < $TotalItems; $a++) {
                                $i1 = $xml->HairShop->hair[$a]["HairID"];
                                $i2 = mysqli_real_escape_string($MySQLi, $xml->HairShop->hair[$a]["strName"]);
                                $i3 = mysqli_real_escape_string($MySQLi, $xml->HairShop->hair[$a]["strFileName"]);
                                $i8 = $xml->HairShop->hair[$a]["intFrame"];
                                $i6 = $xml->HairShop->hair[$a]["RaceID"];
                                $i4 = $xml->HairShop->hair[$a]["intPrice"];
                                $i5 = mysqli_real_escape_string($MySQLi, $xml->HairShop->hair[$a]["strGender"]);
                                $i7 = $xml->HairShop->hair[$a]["bitEarVisible"];
                                if ($itemList == '') {
                                    $itemList = $i1;
                                } else {
                                    $itemList = $itemList . ',' . $i1;
                                }
                                $items = $MySQLi->query("SELECT * FROM mq_hairs WHERE HairID = '{$i1}'");
                                if ($items->num_rows == 0) {
                                    $MySQLi->query("INSERT INTO `mq_hairs` (`id`, `HairID`, `HairSWF`, `HairName`, `EarVisible`, `Gender`, `Price`, `Frame`, `RaceID`) VALUES (NULL, '{$i1}', '{$i3}', '{$i2}', '{$i7}', '{$i5}', '{$i4}', '{$i8}', '{$i6}');");
                                    echo("Hair {$i1}: Added to database<br />");
                                    $grabbedItems++;
                                } else {
                                    $MySQLi->query("UPDATE `mq_hairs` SET `HairSWF` = '{$i3}', `HairName` = '{$i2}', `EarVisible` = '{$i7}', `Gender` = '{$i5}', `Price` = '{$i4}', `Frame` = '{$i8}', `RaceID` = '{$i6}' WHERE `mq_hairs`.`HairID` = {$i1};");
                                    if ($MySQLi->affected_rows > 0) {
                                        echo("Hair {$i1}: Updated in database<br />");
                                        $updatedItems++;
                                    }
                                }
                            }
                        }

                        $XML_PAYLOAD = $Ninja->encryptNinja("<flash><strToken>{$PToken}</strToken><intCharID>{$PId}</intCharID><intHairShopID>" . $intHairShop . "</intHairShopID><strGender>F</strGender></flash>");
                        $XML_POST_URL = "{$urlDF}cf-hairshopload.asp";
                        $result = $Files->dfCurl($XML_POST_URL, $XML_PAYLOAD);

                        $xml = simplexml_load_string($result);
                        $xml = $Ninja->decodeNinja($xml);
                        $xml = simplexml_load_string($xml);

                        $strName = mysqli_real_escape_string($MySQLi, $xml->HairShop["strHairShopName"]);
                        $strFile = mysqli_real_escape_string($MySQLi, $xml->HairShop["strFileName"]);
                        $TotalItems = count($xml->HairShop->hair);
                        $itemList = '';
                        if ($TotalItems > 0) {
                            for ($a = 0; $a < $TotalItems; $a++) {
                                $i1 = $xml->HairShop->hair[$a]["HairID"];
                                $i2 = mysqli_real_escape_string($MySQLi, $xml->HairShop->hair[$a]["strName"]);
                                $i3 = mysqli_real_escape_string($MySQLi, $xml->HairShop->hair[$a]["strFileName"]);
                                $i8 = $xml->HairShop->hair[$a]["intFrame"];
                                $i6 = $xml->HairShop->hair[$a]["RaceID"];
                                $i4 = $xml->HairShop->hair[$a]["intPrice"];
                                $i5 = mysqli_real_escape_string($MySQLi, $xml->HairShop->hair[$a]["strGender"]);
                                $i7 = $xml->HairShop->hair[$a]["bitEarVisible"];
                                if ($itemList == '') {
                                    $itemList = $i1;
                                } else {
                                    $itemList = $itemList . ',' . $i1;
                                }
                                $items = $MySQLi->query("SELECT * FROM mq_hairs WHERE HairID = '{$i1}'");
                                if ($items->num_rows == 0) {
                                    $MySQLi->query("INSERT INTO `mq_hairs` (`id`, `HairID`, `HairSWF`, `HairName`, `EarVisible`, `Gender`, `Price`, `Frame`, `RaceID`) VALUES (NULL, '{$i1}', '{$i3}', '{$i2}', '{$i7}', '{$i5}', '{$i4}', '{$i8}', '{$i6}');");
                                    echo("Hair {$i1}: Added to database<br />");
                                    $grabbedItems++;
                                } else {
                                    $MySQLi->query("UPDATE `mq_hairs` SET `HairSWF` = '{$i3}', `HairName` = '{$i2}', `EarVisible` = '{$i7}', `Gender` = '{$i5}', `Price` = '{$i4}', `Frame` = '{$i8}', `RaceID` = '{$i6}' WHERE `mq_hairs`.`HairID` = {$i1};");
                                    if ($MySQLi->affected_rows > 0) {
                                        echo("Hair {$i1}: Updated in database<br />");
                                        $updatedItems++;
                                    }
                                }
                            }
                        }
                        if ($intHairShop == $i1 && $i1 != NULL) {
                            $items = $MySQLi->query("SELECT * FROM mq_hair_vendors WHERE ShopID = '{$intHairShop}'");
                            if ($items->num_rows == 0) {
                                $MySQLi->query("INSERT INTO `mq_hair_vendors` (`id`, `ShopID`, `ShopName`, `SwfFile`, `ItemIDs`) VALUES (NULL, '{$intHairShop}', '{$strName}', '{$strFile}', '{$itemList}');");
                                echo("Hair Shop {$intHairShop}: Shop Data Added to Database<br />");
                                $grabbedItems2++;
                            } else {
                                $MySQLi->query("UPDATE `mq_hair_vendors` SET `ShopName` = '{$strName}', `SwfFile` = '{$strFile}', `ItemIDs` = '{$itemList}' WHERE `ShopID` = {$intHairShop};");
                                if ($MySQLi->affected_rows > 0) {
                                    if ($MySQLi->affected_rows > 0) {
                                        echo("Hair Shop {$intHairShop}: Shop Data Updated in Database<br />");
                                        $updatedItems2++;
                                    }
                                }
                            }
                        }
                    }
                    echo "Search Complete.<br />";
                    if ($grabbedItems > 0) {
                        echo "Items Downloaded: {$grabbedItems}<br />";
                    }
                    if ($grabbedItems2 > 0) {
                        echo "Shops Downloaded: {$grabbedItems2}<br />";
                    }
                    if ($updatedItems > 0) {
                        echo "Items Updated: {$updatedItems}<br />";
                    }
                    if ($updatedItems2 > 0) {
                        echo "Shops Updated: {$updatedItems2}<br />";
                    }
                    break;
                default:
                    echo('<a href="?m=quests">Download Town/Quest Data</a><br>');
                    echo('<a href="?m=shops">Download Shop Data</a><br>');
                    echo('<a href="?m=merges">Download Merge Shop Data</a><br>');
            }
            ?>
        </section>
    </th>
</table>
<br>
</body>
</html>