<?php

namespace App\Http\Controllers\LiveStreaming;

use Illuminate\Http\Request;
use App\Models\Events;

class DeleteContestController
{
    public function delete($id)
    {
        $event = Events::find($id);

        if (!$event) {
            return redirect()->route('contests.post')->with('error', 'Contest not found');
        }

        $event->delete();

        return redirect()->route('contests.post')->with('success', 'Contest deleted successfully');
    }
}
