<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Statuses;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getStatuses($id = false){
        if($id){
            return Statuses::find($id);
        }
        return Statuses::withCount(['candidates'])->get();
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
