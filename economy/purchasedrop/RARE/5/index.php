<?php
    include "../../../../asset_id.php";
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
            if (file_exists("../../../../user/db/_$deviceid.json")) {
                $player_body = json_decode(file_get_contents("../../../../user/db/_$deviceid.json"));
                if (md5("thisiskey_lol_".$deviceid) == $player_body->User->Token) {
                    if (json_last_error() == 0) {
                        $total_spin = explode("/", $_SERVER['REQUEST_URI'])[4];
                        if ($total_spin < 1 || $total_spin > 10 || !is_numeric($total_spin)) {
                            http_response_code(400);
                            return;
                        }
                        if ($player_body->User->Balances[3]->Amount >= 90 * $total_spin) {
                            $player_body_no_save = json_decode(file_get_contents("../../../../user/db/_$deviceid.json"));
                            random_rare($total_spin, $player_body, $player_body_no_save);
                            $player_body->User->Balances[3]->Amount -= 90 * $total_spin;
                            $player_body_no_save->User->Balances[3]->Amount -= 90* $total_spin;
                            $fp = fopen("../../../../user/db/_$deviceid.json", 'w');
                            fwrite($fp, json_encode($player_body));
                            fclose($fp);
                            echo json_encode($player_body_no_save);
                        }
                        else http_response_code(400);
                    }
                }
                else http_response_code(400);
            }
            else http_response_code(400);
        }
        else http_response_code(400);
    }
?>