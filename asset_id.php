<?php
    $legend_skin = array("SKIN26","SKIN55","SKIN65","SKIN71","SKIN72","SKIN74","SKIN111","SKIN115","SKIN160","SKIN162","SKIN168","SKIN180","SKIN185","SKIN189","SKIN200","SKIN208","SKIN211","SKIN218","SKIN219","SKIN227","SKIN229");
    $mythic_skin = array("SKIN212","SKIN213","SKIN214","SKIN215");
    $epic_skin = array("SKIN21","SKIN23","SKIN30","SKIN35","SKIN42","SKIN50","SKIN56","SKIN57","SKIN60","SKIN64","SKIN66","SKIN68","SKIN69","SKIN70","SKIN73","SKIN102","SKIN110","SKIN114","SKIN118","SKIN119","SKIN144","SKIN158","SKIN159","SKIN161","SKIN163","SKIN169","SKIN178","SKIN179","SKIN181","SKIN183","SKIN184","SKIN186","SKIN187","SKIN188","SKIN190","SKIN191","SKIN192","SKIN201","SKIN202","SKIN204","SKIN205","SKIN207","SKIN209","SKIN216","SKIN224","SKIN225","SKIN226","SKIN228");
    $rare_skin = array("SKIN16","SKIN17","SKIN22","SKIN33","SKIN44","SKIN45","SKIN48","SKIN49","SKIN51","SKIN53","SKIN54","SKIN63","SKIN67","SKIN76","SKIN84","SKIN100","SKIN103","SKIN124","SKIN125","SKIN128","SKIN129","SKIN130","SKIN139","SKIN140","SKIN145","SKIN150","SKIN151","SKIN152","SKIN155","SKIN156","SKIN157","SKIN164","SKIN174","SKIN175","SKIN176","SKIN177","SKIN182","SKIN195","SKIN196","SKIN197","SKIN198","SKIN199","SKIN203","SKIN206","SKIN210","SKIN217","SKIN220","SKIN221");
    $common_skin = array("SKIN3","SKIN6","SKIN7","SKIN8","SKIN9","SKIN14","SKIN18","SKIN19","SKIN20","SKIN28","SKIN31","SKIN40","SKIN47","SKIN59","SKIN77","SKIN78","SKIN79","SKIN80","SKIN81","SKIN85","SKIN86","SKIN87","SKIN88","SKIN89","SKIN90","SKIN91","SKIN96","SKIN104","SKIN105","SKIN106","SKIN107","SKIN109","SKIN121","SKIN136","SKIN137","SKIN138","SKIN146","SKIN147","SKIN148","SKIN149","SKIN166","SKIN167");
    $uncommon_skin = array("SKIN5","SKIN11","SKIN12","SKIN13","SKIN15","SKIN24","SKIN29","SKIN36","SKIN37","SKIN41","SKIN43","SKIN46","SKIN52","SKIN58","SKIN61","SKIN62","SKIN75","SKIN82","SKIN83","SKIN92","SKIN93","SKIN94","SKIN95","SKIN97","SKIN98","SKIN99","SKIN101","SKIN108","SKIN112","SKIN113","SKIN116","SKIN117","SKIN120","SKIN122","SKIN123","SKIN126","SKIN127","SKIN131","SKIN132","SKIN133","SKIN134","SKIN135","SKIN141","SKIN142","SKIN143","SKIN153","SKIN154","SKIN165","SKIN170","SKIN171","SKIN172","SKIN173","SKIN193","SKIN194","SKIN222","SKIN223");
    
    $gems_reward = array("Amount" => 100,"TypeInfo" => "gems","Type" => "CURRENCY");
    $dust_reward = array("Amount" => 25,"TypeInfo" => "dust","Type" => "CURRENCY");
    $skin_reward = array("Amount" => 1,"TypeInfo" => "SKIN1","Type" => "SKIN");
    $emote_reward = array("Amount" => 1,"TypeInfo" => "emote_punch","Type" => "EMOTE");
    $anim_reward = array("Amount" => 1,"TypeInfo" => "animation5","Type" => "ANIMATION");
    $foot_reward = array("Amount" => 1,"TypeInfo" => "footsteps_heart","Type" => "FOOTSTEPS");
                                
    function random_rare($amount, &$body1, &$body2) {
        $skin_gacha = array();     
        for ($x = 0; $x < $amount; $x++) {
            $chance = rand(0,100);
            $the_rand = 0;
            $isDuplicate = false;
            if ($chance == 88 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['mythic_skin'][array_rand($GLOBALS['mythic_skin'])];
            else if ($chance == 78 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['legend_skin'][array_rand($GLOBALS['legend_skin'])];
            else if ($chance == 68 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['epic_skin'][array_rand($GLOBALS['epic_skin'])];
            else $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['rare_skin'][array_rand($GLOBALS['rare_skin'])];
            
            if (in_array($GLOBALS["skin_reward"]["TypeInfo"], $body1->User->Skins) == false) {
                array_push($body1->User->Skins, $GLOBALS["skin_reward"]["TypeInfo"]);
                array_push($body2->User->Skins, $GLOBALS["skin_reward"]["TypeInfo"]);
            }
            else {
                $the_rand = rand(1,10);
                $body1->User->Balances[11]->Amount += $the_rand;
                $body2->User->Balances[11]->Amount += $the_rand;
                $isDuplicate = true;
            }
            array_push($body2->User->Rewards, $GLOBALS["skin_reward"]);
            if ($isDuplicate) {
                $dust_reward["Amount"] = $the_rand;
                array_push($body2->User->Rewards, $GLOBALS["dust_reward"]);
            }
        }
    }
    
    function random_common($amount, &$body1, &$body2) {
        $skin_gacha = array();     
        for ($x = 0; $x < $amount; $x++) {
            $chance = rand(0,100);
            $the_rand = 0;
            $isDuplicate = false;
            if ($chance == 88 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['mythic_skin'][array_rand($GLOBALS['mythic_skin'])];
            else if ($chance == 78 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['legend_skin'][array_rand($GLOBALS['legend_skin'])];
            else if ($chance == 68 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['epic_skin'][array_rand($GLOBALS['epic_skin'])];
            else if ($chance >= 58 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['rare_skin'][array_rand($GLOBALS['rare_skin'])];
            else if ($chance >= 48 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['uncommon_skin'][array_rand($GLOBALS['uncommon_skin'])];
            else $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['common_skin'][array_rand($GLOBALS['common_skin'])];
            
            if (in_array($GLOBALS["skin_reward"]["TypeInfo"], $body1->User->Skins) == false) {
                array_push($body1->User->Skins, $GLOBALS["skin_reward"]["TypeInfo"]);
                array_push($body2->User->Skins, $GLOBALS["skin_reward"]["TypeInfo"]);
            }
            else {
                $the_rand = rand(1,10);
                $body1->User->Balances[11]->Amount += $the_rand;
                $body2->User->Balances[11]->Amount += $the_rand;
                $isDuplicate = true;
            }
            array_push($body2->User->Rewards, $GLOBALS["skin_reward"]);
            if ($isDuplicate) {
                $dust_reward["Amount"] = $the_rand;
                array_push($body2->User->Rewards, $GLOBALS["dust_reward"]);
            }
        }
    }
    
    function random_epic($amount, &$body1, &$body2, $always = 0) {
        $skin_gacha = array();     
        for ($x = 0; $x < $amount; $x++) {
            $chance = rand(0,100);
            $the_rand = 0;
            $isDuplicate = false;
            if ($chance == 86 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['mythic_skin'][array_rand($GLOBALS['mythic_skin'])];
            else if ($chance == 78 + rand(1,3)) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['legend_skin'][array_rand($GLOBALS['legend_skin'])];
            else $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['epic_skin'][array_rand($GLOBALS['epic_skin'])];
            if ($always == 1) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['mythic_skin'][array_rand($GLOBALS['mythic_skin'])];
            else if ($always == 2) $GLOBALS["skin_reward"]["TypeInfo"] = $GLOBALS['legend_skin'][array_rand($GLOBALS['legend_skin'])];
            
            if (in_array($GLOBALS["skin_reward"]["TypeInfo"], $body1->User->Skins) == false) {
                array_push($body1->User->Skins, $GLOBALS["skin_reward"]["TypeInfo"]);
                array_push($body2->User->Skins, $GLOBALS["skin_reward"]["TypeInfo"]);
            }
            else {
                $the_rand = rand(1,10);
                $body1->User->Balances[11]->Amount += $the_rand;
                $body2->User->Balances[11]->Amount += $the_rand;
                $isDuplicate = true;
            }
            array_push($body2->User->Rewards, $GLOBALS["skin_reward"]);
            if ($isDuplicate) {
                $dust_reward["Amount"] = $the_rand;
                array_push($body2->User->Rewards, $GLOBALS["dust_reward"]);
            }
        }
    }
    
    function append_gems($amount, &$body1, &$body2) {
        $body1->User->Balances[3]->Amount += $amount;
        $body2->User->Balances[3]->Amount += $amount;
        array_push($body2->User->Rewards, $GLOBALS["gems_reward"]);
    }
    function append_emote($emote_name, &$body1, &$body2) {
        $GLOBALS["emote_reward"]["TypeInfo"] = $emote_name;
        array_push($body1->User->Emotes, $GLOBALS["emote_reward"]["TypeInfo"]);
        array_push($body2->User->Emotes, $GLOBALS["emote_reward"]["TypeInfo"]);
        array_push($body2->User->Rewards, $GLOBALS["emote_reward"]);
    }
    function append_anim($anim_id, &$body1, &$body2) {
        $GLOBALS["anim_reward"]["TypeInfo"] = $anim_id;
        array_push($body1->User->Animations, $GLOBALS["anim_reward"]["TypeInfo"]);
        array_push($body2->User->Animations, $GLOBALS["anim_reward"]["TypeInfo"]);
        array_push($body2->User->Rewards, $GLOBALS["anim_reward"]);
    }
    function append_foot($foot_id, &$body1, &$body2) {
        $GLOBALS["foot_reward"]["TypeInfo"] = $foot_id;
        array_push($body1->User->Footsteps, $GLOBALS["foot_reward"]["TypeInfo"]);
        array_push($body2->User->Footsteps, $GLOBALS["foot_reward"]["TypeInfo"]);
        array_push($body2->User->Rewards, $GLOBALS["foot_reward"]);
    }
    function append_dust($amount, &$body1, &$body2) {
        $body1->User->Balances[11]->Amount += $amount;
        $body2->User->Balances[11]->Amount += $amount;
        array_push($body2->User->Rewards, $GLOBALS["dust_reward"]);
    }
?>