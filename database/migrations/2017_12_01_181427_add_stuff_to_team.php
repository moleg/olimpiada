<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStuffToTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
        $table->string("School",50);
        $table->string("Teacher",50);
        $table->string("LeadSource",50);
            for($i=1;$i<11;$i++)
            {
                $table->tinyInteger("test".$i,false,true)->default(0);
            }
            $table->string("comment",50)->nullable();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
