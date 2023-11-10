<?php
namespace App\Http\Controllers\LiveStreaming;

use Illuminate\Http\Request;
use App\Models\Events;

class GetContestListController

{
    public function index(Request $request) 
    {
        
        $events = Events::get();

        foreach ($events as $event)
        {
            dd($event);
        }
        dd($events->count());
    }
     
    public function display(Request $request)
    {
        $events = Events::all();
        
        //dd($contests);

        return view('contests.post', compact('events'));
    }

}

?>