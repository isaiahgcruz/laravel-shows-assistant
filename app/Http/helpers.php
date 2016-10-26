<?php
use App\Episode;

function generateEpisodes($showId)
{
    $json = file_get_contents('http://api.tvmaze.com/shows/' . $showId . '/episodes');
    $episodes = json_decode($json);
    $defaultAirtime = "12:00";
    foreach ($episodes as $episode) {
        if ($episode->airdate) {
            Episode::create([
                'name' => $episode->name,
                'airdate' => $episode->airdate,
                'airtime' => ($episode->airtime) ? $episode->airtime : $defaultAirtime,
                'season' => $episode->season,
                'number' => $episode->number,
                'runtime' => $episode->runtime,
                'show_id' => $showId,
            ]);
        }
    }
}