<?php
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
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $headers = getRequestHeaders();
        $auth = json_decode($headers["Authorization"]);
        if (json_last_error() == 0) {
            $deviceid = $auth->DeviceId;
            if (file_exists("../../user/db/_$deviceid.json")) {
                $player_body = json_decode(file_get_contents("../../user/db/_$deviceid.json"));
                if (md5("thisiskey_lol_".$deviceid) == $player_body->User->Token) {
                    if (json_last_error() == 0) {
                        if ($player_body->User->Balances[3]->Amount >= 30) {
                            $pass_point = $player_body->User->BattlePass->PassTokens;
                            if ($pass_point < 50) $player_body->User->BattlePass->PassTokens = 50;
                            else if ($pass_point < 110) $player_body->User->BattlePass->PassTokens = 110;
                            else if ($pass_point < 180) $player_body->User->BattlePass->PassTokens = 180;
                            else if ($pass_point < 260) $player_body->User->BattlePass->PassTokens = 260;
                            else if ($pass_point < 350) $player_body->User->BattlePass->PassTokens = 350;
                            else if ($pass_point < 440) $player_body->User->BattlePass->PassTokens = 440;
                            else if ($pass_point < 535) $player_body->User->BattlePass->PassTokens = 535;
                            else if ($pass_point < 630) $player_body->User->BattlePass->PassTokens = 630;
                            else if ($pass_point < 730) $player_body->User->BattlePass->PassTokens = 730;
                            else if ($pass_point < 830) $player_body->User->BattlePass->PassTokens = 830;
                            else if ($pass_point < 940) $player_body->User->BattlePass->PassTokens = 940;
                            else if ($pass_point < 1050) $player_body->User->BattlePass->PassTokens = 1050;
                            else if ($pass_point < 1170) $player_body->User->BattlePass->PassTokens = 1170;
                            else if ($pass_point < 1290) $player_body->User->BattlePass->PassTokens = 1290;
                            else if ($pass_point < 1420) $player_body->User->BattlePass->PassTokens = 1420;
                            else if ($pass_point < 1550) $player_body->User->BattlePass->PassTokens = 1550;
                            else if ($pass_point < 1690) $player_body->User->BattlePass->PassTokens = 1690;
                            else if ($pass_point < 1830) $player_body->User->BattlePass->PassTokens = 1830;
                            else if ($pass_point < 1980) $player_body->User->BattlePass->PassTokens = 1980;
                            else if ($pass_point < 2130) $player_body->User->BattlePass->PassTokens = 2130;
                            else if ($pass_point < 2290) $player_body->User->BattlePass->PassTokens = 2290;
                            else if ($pass_point < 2450) $player_body->User->BattlePass->PassTokens = 2450;
                            else if ($pass_point < 2620) $player_body->User->BattlePass->PassTokens = 2620;
                            else if ($pass_point < 2790) $player_body->User->BattlePass->PassTokens = 2790;
                            else if ($pass_point < 2970) $player_body->User->BattlePass->PassTokens = 2970;
                            else if ($pass_point < 3150) $player_body->User->BattlePass->PassTokens = 3150;
                            else if ($pass_point < 3340) $player_body->User->BattlePass->PassTokens = 3340;
                            else if ($pass_point < 3530) $player_body->User->BattlePass->PassTokens = 3530;
                            else if ($pass_point < 3730) $player_body->User->BattlePass->PassTokens = 3730;
                            else if ($pass_point < 3930) $player_body->User->BattlePass->PassTokens = 3930;
                            else if ($pass_point < 4140) $player_body->User->BattlePass->PassTokens = 4140;
                            else http_response_code(400);        
                            $player_body->User->Balances[3]->Amount -= 30;   
                            $fp = fopen("../../user/db/_$deviceid.json", 'w');
                            fwrite($fp, json_encode($player_body));
                            fclose($fp);
                            echo json_encode($player_body);
                       }
                       else http_response_code(400);
                    }
                }
            }
            else http_response_code(400);
        }
    }
    else http_response_code(400);
?>