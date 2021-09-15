<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAssetsTable extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_1995563')->references('id')->on('asset_categories');
            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_1995567')->references('id')->on('asset_statuses');
            $table->unsignedInteger('location_id')->nullable();
            $table->foreign('location_id', 'location_fk_1995568')->references('id')->on('asset_locations');
            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_1995596')->references('id')->on('projects');
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_1995603')->references('id')->on('departments');
        });
    }
}
