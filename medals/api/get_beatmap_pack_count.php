<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");
if(isset($_GET['id'])) {
    $ids = explode(",", $_GET['id']);

    $response = [];
    

    foreach($ids as $id) {
        if($id == "") {
            $response["i".rand()] = null;
            continue;
        }
        $maps = Database::execSelect("SELECT * FROM MedalsBeatmapPacks WHERE Id = ?", "s", [$id])[0];
        if($maps['Length'] == 0) {
            $map_ids = json_decode($maps['Ids']);
            $length = 0;
            foreach($map_ids as $mapid) {
                $data = Database::execSelect("SELECT * FROM BeatmapLengths WHERE Id = ?", "i", [$mapid])[0];
                $length += $data['Length'];
            }
            Database::execOperation("UPDATE MedalsBeatmapPacks SET Length = ? WHERE Id = ?", "is", [$length, $id]);
            $maps['Length'] = $length;
        }
        unset($maps['Ids']);
        $response["i".$id] = $maps;
    }

    echo json_encode($response);
}