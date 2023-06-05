<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createbom extends Migration
{
    private $drops = [
        'BOMHeader' => ['bomh_morequiredtemperature', 'bomh_morequiredtimeduration', 'bomh_shelflife'],
        'MOHeader' => ['maoh_morequiredtemperature', 'maoh_morequiredtimeduration', 'maoh_shelflife']
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->drop();

        Schema::table('BOMHeader', function (Blueprint $table) {
            $table->decimal("bomh_morequiredtemperature", 30, 6)->nullable();
            $table->decimal("bomh_morequiredtimeduration", 30, 6)->nullable();
            $table->decimal("bomh_shelflife", 30, 6)->nullable();
        });

        Schema::table('MOHeader', function (Blueprint $table) {
            $table->decimal("maoh_morequiredtemperature", 30, 6)->nullable();
            $table->decimal("maoh_morequiredtimeduration", 30, 6)->nullable();
            $table->decimal("maoh_shelflife", 30, 6)->nullable();
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
