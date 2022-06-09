<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidates;
use App\Models\Timelines;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\CandidateRequest;

class CandidateController extends Controller
{
    public function index(Request $request){
        $keyword = $request->keyword ? $request->keyword : false;
        $status = $request->status ? $request->status : false;
        $from_date = $request->from ? $request->from : false;
        $to_date = $request->to ? $request->to : false;

        $candidates = Candidates::getAll($keyword, $status, $from_date, $to_date);
        
        if(count($candidates)){
            return response()->json([
                'status' => 1,
                'desc' => 'Success',
                'candidates' => json_encode($candidates)
            ]);
        }

        return response()->json([
            'status' => 0,
            'desc' => 'Not exists'
        ]);
        
    }

    public function store(CandidateRequest $request){
        $status = $this->getStatuses(1)->title;
        $insert = Candidates::store($request, $status);
        
        if(!$insert){
            return response()->json([
                'status' => 0,
                'desc' => 'Something went wrong'
            ]);
        }
        return response()->json([
            'status' => 1,
            'desc' => 'Candidate created successfully'
        ]);
    }

    public function show(Request $request){
        $candidate = Candidates::with('timelines')->find($request->candidate_id);

        if($candidate){
            return response()->json([
                'status' => 1,
                'desc' => 'Success',
                'candidate' => json_encode($candidate),
            ]);
        }
        return response()->json([
            'status' => 0,
            'desc' => 'Not exists'
        ]);
        
    }

    public function showCandidateTimeline(Request $request){
        $timeline = Timelines::where('candidate_id', $request->candidate_id)->orderBy('id', 'ASC')->get();
        if(count($timeline)){
            $details = [];
            foreach($timeline as $key => $item){
                $details[$key] = [
                    'candidate_name' => $item->candidate->first_name . ' ' . $item->candidate->last_name,
                    'user' => $item->user->name,
                    'comment' => $item->comment,
                    'status' => $item->status,
                ];
            }
            return response()->json([
                'status' => 1,
                'desc' => 'Success',
                'timeline' => json_encode($details)
            ]);
        }
        return response()->json([
            'status' => 0,
            'desc' => 'No data'
        ]);
    }

    public function changeStatus(StatusRequest $request){
        $candidate = Candidates::find($request->candidate_id);
        $status = $this->getStatuses($request->timeline_status)->title;
        if($candidate && $candidate->update(['status' => $request->timeline_status])){
            Timelines::create([
                'candidate_id' => $candidate->id,
                'user_id' => \Auth::user()->id,
                'comment' => $request->comment,
                'status' => $status
            ]);
            return response()->json([
                'status' => 1,
                'desc' => 'Success'
            ]);
        }
        return response()->json([
            'status' => 0,
            'desc' => 'Something went wrong'
        ]);
    }
}
