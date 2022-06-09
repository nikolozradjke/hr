<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CandidateRequest;
use Illuminate\Support\Facades\Schema;
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

        return view('dashboard.index', compact('statuses', 'candidates', 'count'));
    }

    public function create(){
        $statuses = $this->getStatuses();
        $fields = $this->getFields('candidates');

        return view('dashboard.add', compact('statuses', 'fields'));
    }

    public function store(CandidateRequest $request){
        $status = $this->getStatuses()->where('id', 1)->first()->title;
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

        return view('dashboard.edit', compact('statuses', 'fields', 'item'));
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

    public static function getFields($table){
        $main_table_columns = Schema::getColumnListing($table);
        $main_no_generate_columns = [
            'id',
            'created_at',
            'updated_at'
        ];
        
        return  array_diff($main_table_columns,$main_no_generate_columns);
    }
}
