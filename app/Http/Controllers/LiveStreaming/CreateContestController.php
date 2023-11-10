<?php

namespace App\Http\Controllers\LiveStreaming;

use Illuminate\Http\Request;
use App\Models\Events;

class CreateContestController
{

    public function create()
    {
        return view('contests.create'); // Create a view to input contest details
    }


}

?>