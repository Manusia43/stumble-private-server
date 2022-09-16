<?php
    include "../../asset_id.php";
    function getRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $headers = getRequestHeaders();
        $auth = json_decode($headers["Authorization"]);
        if (json_last_error() == 0) {
            $deviceid = $auth->DeviceId;
            if (file_exists("../../user/db/_$deviceid.json")) {
                $player_body = json_decode(file_get_contents("../../user/db/_$deviceid.json"));
                if (md5("thisiskey_lol_".$deviceid) == $player_body->User->Token) {
                    if (json_last_error() == 0) {
                        $input = file_get_contents("php://input");
                        if ($input != "") {
                            $params = json_decode($input);
                            if (json_last_error() == 0) {
                                $player_body_no_save = json_decode(file_get_contents("../../user/db/_$deviceid.json"));
                                $pass_index = $params->TierIndex;
                                $gems_reward = array("Amount" => 100,"TypeInfo" => "gems","Type" => "CURRENCY");
                                $dust_reward = array("Amount" => 25,"TypeInfo" => "dust","Type" => "CURRENCY");
                                $skin_reward = array("Amount" => 1,"TypeInfo" => "SKIN1","Type" => "SKIN");
                                $emote_reward = array("Amount" => 1,"TypeInfo" => "emote_punch","Type" => "EMOTE");
                                $anim_reward = array("Amount" => 1,"TypeInfo" => "animation5","Type" => "ANIMATION");
                                $foot_reward = array("Amount" => 1,"TypeInfo" => "footsteps_heart","Type" => "FOOTSTEPS");
                                
                                if ($pass_index > 29 || $pass_index < 0) {
                                    http_response_code(400);
                                    return;
                                }
                                if ($params->IsPremium == true) {
                                    if ($player_body->User->BattlePass->HasPurchased == true) {
                                        
                                        if (in_array($pass_index, $player_body->User->BattlePass->PremiumPassRewards) == false) {
                                            array_push($player_body->User->BattlePass->PremiumPassRewards, $pass_index); //push index
                                            sort($player_body->User->BattlePass->PremiumPassRewards);
                                            if ($pass_index == 0) random_epic(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 1) append_gems(100, $player_body, $player_body_no_save);
                                            else if ($pass_index == 2) append_emote("emote_taunt8", $player_body, $player_body_no_save);
                                            else if ($pass_index == 3) append_dust(25, $player_body, $player_body_no_save);
                                            else if ($pass_index == 4) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 5) append_emote("emote_dab", $player_body, $player_body_no_save);
                                            else if ($pass_index == 6) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 7) append_foot("footsteps_banana", $player_body, $player_body_no_save);
                                            else if ($pass_index == 8) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 9) append_dust(25, $player_body, $player_body_no_save);
                                            else if ($pass_index == 10) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 11) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 12) append_gems(100, $player_body, $player_body_no_save);
                                            else if ($pass_index == 13) append_emote("emote_taunt3", $player_body, $player_body_no_save);
                                            else if ($pass_index == 14) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 15) append_anim("animation12", $player_body, $player_body_no_save);
                                            else if ($pass_index == 16) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 17) append_dust(25, $player_body, $player_body_no_save);
                                            else if ($pass_index == 18) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 19) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 20) append_gems(100, $player_body, $player_body_no_save);
                                            else if ($pass_index == 21) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 22) append_foot("footsteps_rainbow", $player_body, $player_body_no_save);
                                            else if ($pass_index == 23) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 24) append_gems(100, $player_body, $player_body_no_save);
                                            else if ($pass_index == 25) random_rare(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 26) append_emote("emote_taunt11", $player_body, $player_body_no_save);
                                            else if ($pass_index == 27) append_dust(25, $player_body, $player_body_no_save);
                                            else if ($pass_index == 28) random_epic(1, $player_body, $player_body_no_save);
                                            else if ($pass_index == 29) append_emote("emote_punch", $player_body, $player_body_no_save);
                                            $player_body_no_save->User->BattlePass->PremiumPassRewards = $player_body->User->BattlePass->PremiumPassRewards;
                                            //Write to file
                                            $fp = fopen("../../user/db/_$deviceid.json", 'w');
                                            fwrite($fp, json_encode($player_body));
                                            fclose($fp);
                                            echo json_encode($player_body_no_save);
                                        }
                                        else http_response_code(400);
                                    }
                                    else http_response_code(400);
                                }
                                else {
                                    if (in_array($pass_index, $player_body->User->BattlePass->FreePassRewards) == false) {
                                        array_push($player_body->User->BattlePass->FreePassRewards, $pass_index); //push index
                                        sort($player_body->User->BattlePass->FreePassRewards);
                                        //anim_reward
                                        $player_body_no_save->User->BattlePass->FreePassRewards = $player_body->User->BattlePass->FreePassRewards;
                                        if ($pass_index == 0) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 2) append_gems(50, $player_body, $player_body_no_save);
                                        else if ($pass_index == 4) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 6) append_dust(10, $player_body, $player_body_no_save);
                                        else if ($pass_index == 8) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 10) append_anim("animation5", $player_body, $player_body_no_save);
                                        else if ($pass_index == 12) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 14) append_emote("emote_go", $player_body, $player_body_no_save);
                                        else if ($pass_index == 16) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 18) append_gems(50, $player_body, $player_body_no_save);
                                        else if ($pass_index == 20) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 22) append_dust(10, $player_body, $player_body_no_save);
                                        else if ($pass_index == 24) append_foot("footsteps_skull", $player_body, $player_body_no_save);
                                        else if ($pass_index == 25) append_gems(50, $player_body, $player_body_no_save);
                                        else if ($pass_index == 26) random_common(1, $player_body, $player_body_no_save);
                                        else if ($pass_index == 27) append_anim("animation3", $player_body, $player_body_no_save);
                                        else if ($pass_index == 28) append_dust(10, $player_body, $player_body_no_save);
                                        else if ($pass_index == 29) random_rare(1, $player_body, $player_body_no_save);
                                        
                                        $fp = fopen("../../user/db/_$deviceid.json", 'w');
                                        fwrite($fp, json_encode($player_body));
                                        fclose($fp);
                                        echo json_encode($player_body_no_save);
                                    }
                                    else http_response_code(400);
                                }
                                
                            }
                        }
                        else http_response_code(400);
                    }
                    else http_response_code(400);
                }
                else http_response_code(400);
            }
            else http_response_code(400);
        }
    }
    else http_response_code(400);
?>