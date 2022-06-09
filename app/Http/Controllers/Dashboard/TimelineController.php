<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StatusRequest;
use App\Models\Timelines;
use App\Models\Candidates;


class TimelineController extends Controller
{
    public function store($id, StatusRequest $request){
        $candidate = Candidates::findOrFail($id);
        $status = $this->getStatuses($request->timeline_status)->title;
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
