<?php
// Tanza 2023-05-13
// ? i'm so sorry for this mess, but it takes 118ms to
// ? do it all so i think it's reasonable lol
// ? can implement caching at a later date

require_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");



$packs = Database::execSimpleSelect('SELECT medalid, packid, name, link FROM Medals WHERE packid IS NOT NULL AND packid != "" AND packid != "0" AND packid != "0,0,0,0"');

$gamemodes = ["standard", "taiko", "catch", "mania"];

function getpack($packId) {
    return Database::execSelect("SELECT * FROM MedalsBeatmapPacks WHERE Id = ?", "i", [$packId])[0];
}

for($x = 0; $x < count($packs); $x++) {
    $pack = $packs[$x];
    $packIds = explode(",", $pack['packid']);
    $fastest_time = PHP_INT_MAX;
    $fastest_gamemode = null;
    $y = 0;
    foreach($packIds as $packId) {
        $length = getpack($packId)['Length'];
        if($length < $fastest_time && $length != 0) {
            $fastest_time = $length;
            $fastest_gamemode = $gamemodes[$y];
        }
        $y++;
    }

    if($fastest_time == PHP_INT_MAX) {
        $fastest_time = -1;
    }

    $packs[$x]['fastest_time'] = $fastest_time;
    $packs[$x]['fastest_gamemode'] = $fastest_gamemode;
}

usort($packs,function($first,$second){
    // if the time is -1 we put it at the end of the array so it doesn't get in the way
    if($first['fastest_time'] == -1) {
        return 1;
    }
    if($second['fastest_time'] == -1) {
        return -1;
    }
    return $first['fastest_time'] > $second['fastest_time'];
});


echo json_encode($packs);