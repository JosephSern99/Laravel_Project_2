<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoDetailColumn extends Migration
{
    private $drops = [
		'MODetail' => ['maod_refmodetailid', 'maod_bomdetailid', 'maod_bomheaderid']
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->drop();
		Schema::table('MODetail', function (Blueprint $table) {
            $table->integer("maod_refmodetailid")->nullable();
            $table->integer("maod_bomdetailid")->nullable();
            $table->integer("maod_bomheaderid")->nullable();
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
