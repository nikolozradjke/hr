<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CandidateRequest;
use App\Models\Candidates;

class indexController extends Controller
{
    public function index(Request $request){
        $keyword = $request->keyword ? $request->keyword : false;
        $status = $request->status ? $request->status : false;
        $from_date = $request->from ? $request->from : false;
        $to_date = $request->to ? $request->to : false;

        $candidates = Candidates::getAll($keyword, $status, $from_date, $to_date);
        $count = Candidates::count();

        $statuses = $this->getStatuses();

        return view('dashboard.candidates.index', compact('statuses', 'candidates', 'count'));
    }

    public function create(){
        $fields = $this->getFields('candidates');

        return view('dashboard.candidates.add', compact('fields'));
    }

    public function store(CandidateRequest $request){
        $status = $this->getStatuses(1)->title;
        $insert = Candidates::store($request, $status);

        if(!$insert) 
        {
            $request->session()->flash('error', 'Something went wrong!');
            return redirect()->route('createDashboard');
        }
        
        return redirect()->route('Candidates')->with('success', 'The operation completed successfully:');
    }
    
    public function edit($id){
        $statuses = $this->getStatuses();
        $fields = $this->getFields('candidates');
        $item = Candidates::with('timelines')->find($id);

        return view('dashboard.candidates.edit', compact('statuses', 'fields', 'item'));
    }

    public function update($id, CandidateRequest $request){
        $item = Candidates::find($id);
        $update = Candidates::updateItem($item, $request);

        if(!$update) 
        {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        
        return redirect()->route('Candidates')->with('success', 'The operation completed successfully:');
    }

    public function remove($id){
        $candidate = Candidates::find($id);
        if($candidate->delete()){
            return redirect()->back()->with('success', 'The operation completed successfully:');
        }
        return abort('403', 'Unauthorized action.');
    }
}
