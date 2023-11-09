<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;
use App\Models\Contests;

class ContestController extends Controller
{
    //
    public function index(){
        $contests = Contests::all();
        return view('contests.index',['contests' => $contests]);
    }

    public function create(){
        return view('contests.create');
    }

    public function store(Request $request){
        $data = $request->validate([

            'title' =>'required',
            'title_locale' =>'required',
        ]);

        $newContest = Contests::create($data);

        return redirect(route('contests.index'));
        
    }

    public function edit(Contests $contests){

        //dd($contests);
        return view('contests.edit', ['contests'=> $contests]);
    }

    public function update(Contests $contests, Request $request){

        $data = $request->validate([

            'title' =>'required',
            'title_locale' =>'required',
        ]);

        $contests->update($data);

        return redirect(route('contests.index'))->with('success','Contest updated successfully');
    }

    public function delete(Contests $contests){

        $contests->delete();

        return redirect(route('contests.index'))->with('success','Contest delete successfully');

    }
}
