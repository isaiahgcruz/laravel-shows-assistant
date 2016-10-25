<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Http\Requests;
use App\Show;
use App\User;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->input('user');
        $user = User::find($user['id']);
        $showIds = $user->shows()->lists('shows.id');
        $episodes = Episode::whereIn('show_id', $showIds)->orderBy('airdate')->get()->toArray();
        return response($episodes, 200);
    }

    /**
     * Display upcoming episodes.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upcoming(Request $request)
    {
        $user = $request->input('user');
        $user = User::find($user['id']);
        $showIds = $user->shows()->lists('shows.id');
        $date = \Carbon\Carbon::now();
        $episodes = Episode::whereIn('show_id', $showIds)
            ->where('airdate', '>=', $date->toDateString())
            ->where('airdate', '<=', $date->addWeek())
            ->orderBy('airdate')->get()->groupby('airdate')->toArray();
        return response($episodes, 200);
    }

    public function refreshEpisodes(Request $request)
    {
        $shows = Show::all();
        Episode::truncate();
        foreach ($shows as $show) {
            generateEpisodes($show->id);
        }
        return response('Finished generating episodes', 200);
    }
}
