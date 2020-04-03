<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmojiPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('emoji_package', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emoji_img')->comment('表情图片');
            $table->Integer('ub_id')->comment('创建用户id');
            $table->string('content');
            $table->timestamps();
            $table->Integer('collect_num')->default(1)->comment('用户收藏数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
