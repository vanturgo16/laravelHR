<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('candidate_edu');
            $table->string('candidate_birthday');
            $table->string('candidate_exp');
            $table->string('candidate_lastposition');
            $table->string('candidate_appliedposition');
            $table->text('candidate_skills');
            $table->string('candidate_email');
            $table->string('candidate_phone');
            $table->string('candidate_attachment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
