<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CandidateRequest;
use Illuminate\Support\Facades\Schema;
use App\Models\Statuses;
use App\Models\Candidates;

class indexController extends Controller
{
    public function index(){
        $statuses = $this->getStatuses();
        $candidates = Candidates::with('getStatus')->latest()->get();

        return view('dashboard.index', compact('statuses', 'candidates'));
    }

    public function create(){
        $statuses = $this->getStatuses();
        $fields = $this->getFields('candidates');

        return view('dashboard.add', compact('statuses', 'fields'));
    }

    public function store(CandidateRequest $request){
        $insert = Candidates::store($request);

        if(!$insert) 
        {
            $request->session()->flash('error', 'Something went wrong!');
            return redirect()->route('createDashboard');
        }

        $request->session()->flash('success', 'The operation completed successfully:');
        
        return redirect()->route('dashboard');
    }
    
    public function edit($id){
        $statuses = $this->getStatuses();
        $fields = $this->getFields('candidates');
        $item = Candidates::find($id);

        return view('dashboard.edit', compact('statuses', 'fields', 'item'));
    }

    public function update($id, CandidateRequest $request){
        $item = Candidates::find($id);
        $update = Candidates::updateItem($item, $request);

        if(!$update) 
        {
            $request->session()->flash('error', 'Something went wrong!');
            return redirect()->back();
        }

        $request->session()->flash('success', 'The operation completed successfully:');
        
        return redirect()->route('dashboard');
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

    public static function getStatuses(){
        return Statuses::with('candidates')->get();
    }
    
}
