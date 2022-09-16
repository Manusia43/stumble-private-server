<?php
    if(is_dir("../../../user/db/")) {
         $users = array_diff(scandir("../../../user/db"), array('.', '..'));
         $user_amount = count($users);
         if ($user_amount >= 1) {
            $users_list = array();
            //?start=0&count=100&country=
            $start_index = $_GET["start"];
            $count_index = $_GET["count"];
            $country = $_GET["country"];
            for ($x = 0; $x < count($users); $x++) {
                $arr_data = array();
                $player_body = json_decode(file_get_contents("../../../user/db/".$users[$x]));
                if ($country != "") {
                    if ($player_body->User->Country == $country) {
                        $arr_data = array("Username" => $player_body->User->Username, "SkillRating" => $player_body->User->SkillRating, "Country" => $country);
                    }             
                }
                else {
                    $arr_data = array("Username" => $player_body->User->Username, "SkillRating" => $player_body->User->SkillRating, "Country" => $player_body->User->Country);
                }
                array_push($users_list, $arr_data);
            }
            $crown = array_column($users_list, 'SkillRating');
            array_multisort($crown, SORT_DESC, $users_list);
            
            if (count($users_list) > 100 && $start_index == 100) {
                for ($i = 0; $i < 100; $i++) {
                    $real_data = array("User" => $users_list[$i]);
                    $users_list[$i] = $real_data;
                }
            }
            else {
                for ($i = 0; $i < count($users_list); $i++) {
                    $real_data = array("User" => $users_list[$i]);
                    $users_list[$i] = $real_data;
                }
            }
            $leaderboard = array("scores" => $users_list);
            echo json_encode($leaderboard);      
         }
         else http_response_code(400);
    }
    else http_response_code(400);
?>