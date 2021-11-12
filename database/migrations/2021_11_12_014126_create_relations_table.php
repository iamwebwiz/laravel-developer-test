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
            $table->foreignIdFor(Person::class, 'relative_id')->constrained('people');
            $table->string('relationship');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
