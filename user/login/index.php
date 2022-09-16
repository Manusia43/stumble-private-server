<?php
    function country_code($IPaddress) {
        $country = file_get_contents('http://ipinfo.io/$IPaddress/country');
        echo $country;
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = file_get_contents("php://input");
        if ($input != "") {
            $jsn = json_decode($input);
            $jsn2 = json_decode($input, true);
            $start_gems = 1000000;
            $start_dust = 500000;
            if (json_last_error() == 0) {
                if(array_key_exists('Id', $jsn2) && array_key_exists('DeviceId', $jsn2) && array_key_exists('Version', $jsn2) && array_key_exists('Hash', $jsn2) && array_key_exists('AdvertisingId', $jsn2) && array_key_exists('Timestamp', $jsn2) && array_key_exists('FacebookId', $jsn2) && array_key_exists('GoogleId', $jsn2) && array_key_exists('AppleId', $jsn2)) {
                    $userid = $jsn->Id;
                    $deviceid = $jsn->DeviceId;
                    $version = $jsn->Version;
                    $appleid = $jsn->AppleId;
                    $fbid = $jsn->FacebookId;
                    $goid = $jsn->GoogleId;
                    $timestamp = $jsn->Timestamp;
                    $advid = $jsn->AdvertisingId;
                    $hash = $jsn->Hash;
                    $ccode = country_code($_SERVER['REMOTE_ADDR']);
                    
                    $def_player_body = json_decode('{"User":{"Id":129817,"DeviceId":"KIPASGTSSERVER","GoogleId":null,"FacebookId":null,"AppleId":null,"AdvertisingId":null,"Username":"PLAYER NAME","Country":"US","Region":"CA","Token":"discord.gg/kipasgts","Version":"0.40","Created":"2022-09-12T23:02:00.078Z","LastLogin":"2022-09-12T23:02:00.078Z","NewsVersion":0,"SkillRating":0,"Experience":0,"Crowns":0,"HiddenRating":0,"IsBanned":false,"PurchaseReceipts":[],"Friends":null,"Skins":[],"SkinVariants":[],"Emotes":[],"Animations":[],"Footsteps":[],"HasBattlePass":false,"PassTokens":0,"FreePassRewards":[],"PremiumPassRewards":[],"VersionResult":"","Balances":[{"Amount":100,"Name":"coins","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":0},{"Amount":0,"Name":"remove_ads","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":2},{"Amount":50,"Name":"video","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":5000},{"Amount":20000,"Name":"gems","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":0},{"Amount":10,"Name":"video_gems","SecondsSince":0,"SecondsPerUnit":5400,"MaxAmount":10},{"Amount":10,"Name":"video_coins","SecondsSince":0,"SecondsPerUnit":7200,"MaxAmount":10},{"Amount":3,"Name":"special_video","SecondsSince":0,"SecondsPerUnit":28800,"MaxAmount":3},{"Amount":0,"Name":"skin_charge","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":5},{"Amount":1,"Name":"skin_purchase","SecondsSince":0,"SecondsPerUnit":86400,"MaxAmount":1},{"Amount":0,"Name":"gem_charge","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":3},{"Amount":1,"Name":"gem_purchase","SecondsSince":0,"SecondsPerUnit":86400,"MaxAmount":1},{"Amount":3000,"Name":"dust","SecondsSince":0,"SecondsPerUnit":0,"MaxAmount":0}],"Rewards":[],"AvailableNewsVersion":1,"RewardID":"VF59Z53GEoC+nD5+RQYNps4fbok=","BattlePass":{"Id":188717,"FreePassRewards":[],"PremiumPassRewards":[],"PassTokens":0,"HasPurchased":false,"PassID":4,"SecondsToEnd":2147483647},"SecondsSinceCreated":0},"Timestamp":"2022-09-12T23:02:00.079Z"}');
                    if (json_last_error() == 0) {
                        $def_player_body->User->Id = $userid;
                        $def_player_body->User->DeviceId = $deviceid;
                        $def_player_body->User->Token = md5("thisiskey_lol_".$deviceid);
                        $def_player_body->User->Country = $ccode;
                        $def_player_body->User->Region = $ccode;
                        if (file_exists("../db/_$deviceid.json")) { //./user/db
                            //TODO ACCOUNT EXISTS
                            $player_body = json_decode(file_get_contents("../db/_$deviceid.json"));
                            if (json_last_error() == 0) {
                                $player_body->User->Id = $userid;
                                $player_body->User->DeviceId = $deviceid;
                                $player_body->User->Token = md5("thisiskey_lol_".$deviceid);
                                echo json_encode($player_body);
                            }
                            else http_response_code(405);
                        }
                        else {
                            $def_player_body->User->Username = "Player ".generateRandomString(8);
                            $def_player_body->User->Balances[11]->Amount = $start_dust;
                            $def_player_body->User->Balances[3]->Amount = $start_gems;
                            $output = json_encode($def_player_body);
                            if (json_last_error() == 0) {
                                $fp = fopen("../db/_$deviceid.json", 'w');
                                fwrite($fp, $output);
                                fclose($fp);
                                echo json_encode($def_player_body);
                            }
                            else http_response_code(405);
                        }
                    }
                    else http_response_code(405);
                }
                else http_response_code(405);
            }
            else http_response_code(405);
        }
        else http_response_code(405);
    }
    else {
        http_response_code(405);
    }
?>
