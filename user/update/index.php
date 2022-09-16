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
    function update_user($deviceid, $cn = false, $input = "") {
        
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $headers = getRequestHeaders();
        $auth = json_decode($headers["Authorization"]);
        if (json_last_error() == 0) {
            $deviceid = $auth->DeviceId;
            if (file_exists("../db/_$deviceid.json")) {
                $player_body = json_decode(file_get_contents("../db/_$deviceid.json"));
                if (md5("thisiskey_lol_".$deviceid) == $player_body->User->Token) {
                    if (json_last_error() == 0) { 
                        $input = file_get_contents("php://input");
                        if ($input != "") {
                            $params = json_decode($input);
                            if (json_last_error() == 0) {
                                $player_body->User->Username = $params->Username;
                                $fp = fopen("../db/_$deviceid.json", 'w');
                                fwrite($fp, json_encode($player_body));
                                fclose($fp);
                                echo json_encode($player_body);
                            }
                        }
                    } 
                }
                else http_response_code(405);
            }
            else http_response_code(405);
        }
        else http_response_code(405);
    }
    else http_response_code(405);
?>