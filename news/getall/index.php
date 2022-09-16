<?php
    $news = array();
    $news_id = 1;
    function append_new($header, $desc, $lang, $type, $image, $redirect) {
        //{"id":1,"headerText":"Need help?","contentText":"Watch our tutorial!","language":"EN","newsType":"1","imagePath":"","targetUrl":"https://youtu.be/uO5kVxhVBVE","timestamp":"2022-08-28T00:00:00Z"}
        $data = array(
            "id" => $GLOBALS['news_id'],
            "headerText" => $header,
            "contentText" => $desc,
            "language" => $lang,
            "newsType" => $type, 
            "imagePath" => $image,
            "targetUrl" => $redirect,
            "timestamp" => "2022-08-28T00:00:00Z"
        );
        array_push($GLOBALS['news'], $data);
        $GLOBALS['news_id'] += 1;
    }
    append_new("New Patch", "- Saved account\n- Free Gems", "EN", 1, "", "https://discord.gg/kipasgts", "2022-08-28T00:00:00Z");
    append_new("More Info", "Join our Discord to get more information", "EN", 1, "", "https://discord.gg/kipasgts", "2022-08-28T00:00:00Z");
    
    echo json_encode($news)
?>