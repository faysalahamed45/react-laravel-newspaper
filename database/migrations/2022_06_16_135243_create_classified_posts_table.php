<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment('classified_categories table id');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->longText('content_en');
            $table->longText('content_bn');
            $table->date('published_date');
            $table->date('expired_date')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->enum('status', ['Draft', 'Published', 'Rejected'])->default('Draft');
            $table->enum('is_premium', ['No', 'Yes'])->default('No');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->on('classified_categories')->references('id')->onDelete('cascade');
            $table->foreign('editor_id')->on('admins')->references('id')->onDelete('set null');
            $table->foreign('approved_by')->on('admins')->references('id')->onDelete('set null');
            $table->foreign('created_by')->on('admins')->references('id')->onDelete('set null');
            $table->foreign('updated_by')->on('admins')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classified_posts');
    }
}
