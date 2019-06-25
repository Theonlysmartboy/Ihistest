<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drop5d1225549450aPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('patients');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(! Schema::hasTable('patients')) {
            Schema::create('patients', function (Blueprint $table) {
                $table->increments('id');
                $table->string('huduma_no');
                $table->string('f_no')->nullable();
                $table->string('m_no')->nullable();
                $table->string('l_name')->nullable();
                $table->datetime('dob')->nullable();
                $table->string('email')->nullable();
                $table->string('photo')->nullable();
                $table->string('telephone')->nullable();
                $table->string('address')->nullable();
                $table->text('diagnostic')->nullable();
                $table->text('prescription')->nullable();
                
                $table->timestamps();
                $table->softDeletes();

            $table->index(['deleted_at']);
            });
        }
    }
}
