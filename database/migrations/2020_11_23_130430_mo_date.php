<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoDate extends Migration
{
    private $drops = [
        'MOHeader' => ['maoh_startdate', 'maoh_enddate']
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->drop();

        Schema::table('MOHeader', function (Blueprint $table) {
            $table->timestamp("maoh_startdate")->nullable();
            $table->timestamp("maoh_enddate")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop();
    }

    public function drop(){
        foreach($this->drops as $table => $value){
            $columns = is_array($value) ? $value : [$value];
            $columns_count = count($columns);
            for($c = 0; $c < $columns_count; $c++){
                if (Schema::hasColumn($table, $columns[$c])) {
                    Schema::table($table, function (Blueprint $table) use ($columns, $c) {
                        $table->dropColumn($columns[$c]);
                    });
                }
            }
        }
    }
}
