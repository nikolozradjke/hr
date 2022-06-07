<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Statuses;
use App\Models\Candidates;

class indexController extends Controller
{
    public function index(){
        $statuses = Statuses::with('candidates')->get();
        $candidates = Candidates::with('status')->latest()->get();
        $fields = $this->getFields('candidates');
        
        return view('layouts.dashboard', compact('statuses', 'candidates', 'fields'));
    }

    public static function getFields($table){
        $main_table_columns = Schema::getColumnListing($table);
        $main_no_generate_columns = [
            'id',
            'last_name',
            'pdf',
            'created_at',
            'updated_at'
        ];
        
        return  array_diff($main_table_columns,$main_no_generate_columns);
    }
    
}
