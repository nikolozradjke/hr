<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timelines;
use App\Models\Candidates;


class TimelineController extends Controller
{
    public function store($id, Request $request){
        $candidate = Candidates::find($id);
        $status = $this->getStatuses()->where('id', $request->timeline_status)->first()->title;
        if($candidate->update(['status' => $request->timeline_status])){
            Timelines::create([
                'candidate_id' => $id,
                'user_id' => \Auth::user()->id,
                'comment' => $request->comment,
                'status' => $status
            ]);
            return redirect()->back();
        }

        return abort(403, 'Unauthorized action.');
    }
}
