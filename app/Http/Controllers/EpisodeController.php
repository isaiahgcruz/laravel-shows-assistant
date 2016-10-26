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
        $dt = \Carbon\Carbon::now();
        $config = $request->input('config');
        $query;
        switch($config) {
            case 1:
                $showIds = $user->shows()->lists('shows.id');
                $query = Episode::whereIn('show_id', $showIds)->orderBy('airdate');
                break;
            case 2:
                $showIds = $user->shows()->lists('shows.id');
                $query = Episode::whereIn('show_id', $showIds)->orderBy('airdate');
                $query = $query->where('airdate', '>=', $dt->toDateString());
                break;
            case 3:
                $shows = $user->shows;
                $episodes = [];
                foreach ($shows as $show) {
                    $lastSeason = $show->episodes()->orderBy('season', 'desc')->first()->season;
                    $episodes = array_merge($episodes, 
                        $show->episodes()->where('season', $lastSeason)->orderBy('airdate')->get()->toArray());
                }
                return response($episodes, 200);
                break;
            case 4:
                $showIds = $user->shows()->lists('shows.id');
                $query = Episode::whereIn('show_id', $showIds)->orderBy('airdate');
                $query = $query->where('airdate', '>=', $dt->setDate($dt->year, $dt->month, 1)->toDateString());
                break;
            default:
                break;
        }
        $query = $query->get()->toArray();
        return response($query, 200);
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
