<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Timelines;

class Candidates extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'salary_range',
        'skills',
        'linkedin',
        'cv',
        'status',
        'experience',
        'source',
        'current_work_place',
        'education',
        'facebook',
        'phone',
        'email'
    ];

    public function getStatus(){
        return $this->belongsTo(Statuses::class, 'status', 'id');
    }

    public function timelines(){
        return $this->hasMany(Timelines::class, 'candidate_id', 'id')->orderBy('id', 'ASC');
    }

    public static function store($request, $status){
        $request_keys = $request->except(['_token','cv','skills']);
        $item = new Candidates;

        foreach($request_keys as $key => $value){
            $item->$key = $value;
        }

        if ($request->hasFile('cv')) 
        {
            $destination = 'uploads/candidates';
            $extension = $request->file('cv')->getClientOriginalExtension();
            $fileName = mt_rand(11111, 99999) . time() . '.' . $extension;
            $file_src = '/uploads/candidates/' . $fileName;
            $request->file('cv')->move($destination, $fileName);
            $item->cv = $file_src;
        }

        if($request->skills){
            $skills = explode(',', trim($request->skills));
            $item->skills = json_encode($skills);
        }

        if($item->save()){
            Timelines::create([
                'candidate_id' => $item->id,
                'user_id' => \Auth::user()->id,
                'comment' => 'Added to pipeline on stage ' . $status . ' by ' . \Auth::user()->name,
                'status' => $status
            ]);
            return true;
        }

        return false;
    }

    public static function updateItem($item, $request){
        $request_keys = $request->except(['_token','cv','skills','itemSkills']);

        foreach($request_keys as $key => $value){
            $item->$key = $value;
        }
        
        if ($request->hasFile('cv')) 
        {
            $destination = 'uploads/candidates';
            $extension = $request->file('cv')->getClientOriginalExtension();
            $fileName = mt_rand(11111, 99999) . time() . '.' . $extension;
            $file_src = '/uploads/candidates/' . $fileName;
            $request->file('cv')->move($destination, $fileName);
            $item->cv = $file_src;
        }

        if($request->skills){
            $skills = explode(',', trim($request->skills));
            $final_skills = array_merge($skills, $request->itemSkills ? $request->itemSkills : []);
            $item->skills = json_encode($final_skills);
        }else{
            $item->skills = json_encode($request->itemSkills);
        }

        if($item->update()){
            return true;
        }

        return false;
    }

    public static function getAll($keyword = false, $status = false){
        return Candidates::join('statuses', 'candidates.status', '=', 'statuses.id')
                        ->when($keyword, function ($query, $keyword) { 
                                return $query->where('first_name', 'LIKE', '%'.$keyword.'%')
                                            ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                                            ->orWhereJsonContains('skills', $keyword)
                                            ->orWhere('position', 'LIKE', '%'.$keyword.'%')
                                            ->orWhere('phone', 'LIKE', '%'.$keyword.'%')
                                            ->orWhere('email', 'LIKE', '%'.$keyword.'%');
                        })
                        ->when($status, function ($query, $status){
                            return $query->where('status', $status);
                        })
                        ->select(
                            'candidates.*',
                            'statuses.title'
                        )
                        ->orderBy('id', 'DESC')
                        ->get();
    }
}
