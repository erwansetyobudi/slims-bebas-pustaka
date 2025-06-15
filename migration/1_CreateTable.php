<?php
use SLiMS\Migration\Migration;
use SLiMS\Table\Schema;
use SLiMS\Table\Blueprint;

class CreateTable extends Migration
{
    function up()
    {
        Schema::create('bebas_pustaka_history', function(Blueprint $table) {
            $table->autoIncrement('id');
            $table->string('member_id', 20)->notNull();
            $table->string('uid', 50)->nullable(); // fleksibel, bisa diisi null untuk kasus lama
            $table->text('letter_number_format')->notNull();
            $table->unique('member_id', 'member_id_unq');
            $table->index('member_id');
            $table->fulltext('letter_number_format');
            $table->timestamps();
            $table->engine = 'MyISAM';
        });
    }

    function down()
    {
        Schema::dropIfExists('bebas_pustaka_history');
    }
}
