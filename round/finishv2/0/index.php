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
            if (file_exists("../../../user/db/_$deviceid.json")) {
                $player_body = json_decode(file_get_contents("../../../user/db/_$deviceid.json"));
                if (md5("thisiskey_lol_".$deviceid) == $player_body->User->Token) {
                    if (json_last_error() == 0) {
                        $player_body->User->Experience += 100;
                        $player_body->User->HiddenRating += 100;
                        $player_body->User->BattlePass->PassTokens += 20;
                        
                        $fp = fopen("../../../user/db/_$deviceid.json", 'w');
                        fwrite($fp, json_encode($player_body));
                        fclose($fp);
                        echo json_encode($player_body);
                        
                    }
                    else http_response_code(400);
                }
                else http_response_code(400);
            }
            else http_response_code(400);
        }
        else http_response_code(400);
    }
?>