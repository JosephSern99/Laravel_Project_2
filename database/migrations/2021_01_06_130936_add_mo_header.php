<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoHeader extends Migration
{
     private $drops = [
        'MOHeader' => ['maoh_docnum', 'maoh_recpnumber'],
		'MODetail' => ['maod_status']
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
            $table->text("maoh_docnum")->nullable();
            $table->text("maoh_recpnumber")->nullable();
        });
		
		Schema::table('MODetail', function (Blueprint $table) {
            $table->text("maod_status")->nullable();
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
