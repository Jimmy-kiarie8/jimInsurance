<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('client_id');
            $table->integer('InsClass_id');
            $table->integer('InsType_id');
            $table->string('policy_no');
            $table->string('policy_status_id');
            $table->string('insured')->nullable();
            $table->string('coverage')->nullable();
            $table->decimal('premium');
            $table->decimal('premium_paid');
            $table->decimal('commission');
            $table->date('effective_date');
            $table->date('exp_date');
            $table->string('file_no');
            $table->string('client')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('policies');
    }
}
