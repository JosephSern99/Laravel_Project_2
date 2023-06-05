<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModetailUomid extends Migration
{
    private $drops = [
		'MODetail' => ['maod_uomid']
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
            $table->string("maod_uomid")->nullable();
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
