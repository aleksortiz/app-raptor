<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChecklistCommentsToFinalChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('final_checklists', function (Blueprint $table) {
            $table->json('checklist')->nullable()->after('firma');
            $table->json('checklist_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('final_checklists', function (Blueprint $table) {
            $table->dropColumn('checklist');
            $table->dropColumn('checklist_comments');
        });
    }
}
