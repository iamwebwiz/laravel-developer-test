<?php

use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->foreignIdFor(Person::class)->constrained('people');
            $table->unsignedBigInteger('spouse_id')->nullable();
            $table->unsignedBigInteger('mother_id')->nullable();
            $table->unsignedBigInteger('father_id')->nullable();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
