<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('experience')->after('last_name')->nullable();
            $table->string('source')->after('last_name')->nullable();
            $table->string('email')->after('last_name')->nullable();
            $table->string('phone')->after('last_name')->nullable();
            $table->string('current_work_place')->after('last_name')->nullable();
            $table->string('facebook')->after('linkedin')->nullable();
            $table->string('education')->after('last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                                'experience',
                                'source',
                                'email',
                                'phone',
                                'current_work_place',
                                'facebook',
                                'education'
                               ]);
        });
    }
};
