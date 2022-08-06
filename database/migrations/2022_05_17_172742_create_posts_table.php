<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->string('slug_en');
            $table->string('slug_bn');
            $table->string('title_en')->unique();
            $table->string('title_bn')->unique();
            $table->longText('content_en');
            $table->longText('content_bn');
            $table->string('video_url')->nullable();
            $table->string('image')->nullable();
            $table->string('image_url')->nullable();
            $table->dateTime('published_at');
            $table->dateTime('approved_at')->nullable();
            $table->enum('status', ['Draft', 'Published', 'Rejected'])->default('Draft');
            $table->boolean('feature_post')->default(0);
            $table->boolean('feature_post_2')->default(0);
            $table->boolean('exclusive')->default(0);
            $table->unsignedBigInteger('total_view')->default(0);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('posts');
    }
}
