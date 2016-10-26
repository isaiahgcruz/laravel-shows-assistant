<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Show;
use App\User;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request
     * @param  App\User
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $query = $user->shows();

        if ($request->has('q')) {
            $query = $query->search($request->input('q'));
        }

        if ($request->has('sort')) {
            $column = str_replace('-', '', $request->input('sort'));
            $direction = $request->input('sort') != $column ? 'desc' : 'asc';
            if (Schema::hasColumn('cods', $column)) {
                $query = $query->orderBy($column, $direction);
            }
        }

        if ($request->has('page')) {
            $currentPage = $request->input('page');
            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
            $perPage = $request->has('per_page') ? $request->input('per_page') : 10;
            $query = $query->paginate($perPage);
        } else {
            $query = $query->get();
        }
        return response()->json($query, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $show = $request->input('show');
        $exists = Show::find($show['id']);

        if ($exists) {
            $exists->update(['name' => $show['name']]);
        } else {
            $timezone = "";
            if ($show['network']) {
                $timezone = $show['network']['country']['timezone'];
            } else if ($show['webChannel']) {
                $timezone = $show['webChannel']['country']['timezone'];
            } else {
                $timezone = Config::get('app.timezone');
            }
            Show::create(['id' => $show['id'], 
                'name' => $show['name'], 
                'timezone' => $timezone
            ]);
            generateEpisodes($show['id']);
        }

        if (!$user->shows()->where('shows.id', $show['id'])->count()) {
            $user->shows()->attach($show['id']);
        }

        return response()->json($show, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
    