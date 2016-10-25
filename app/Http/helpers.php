<?php
use App\Episode;

function generateEpisodes($showId)
{
    $json = file_get_contents('http://api.tvmaze.com/shows/' . $showId . '/episodes');
    $episodes = json_decode($json);
    foreach ($episodes as $episode)
    {
        if ($episode->airdate) {
            Episode::create([
                'name' => $episode->name,
                'airdate' => $episode->airdate,
                'airtime' => $episode->airtime,
                'season' => $episode->season,
                'number' => $episode->number,
                'runtime' => $episode->runtime,
                'show_id' => $showId,
            ]);
        }
    }
}