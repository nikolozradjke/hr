<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Statuses;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            'Initial',
            'First contract',
            'Interview',
            'Tech assignment',
            'Rejected',
            'Hired'
        ];

        foreach($records as $record){
            Statuses::create(['title' => $record]);
        }
    }
}
