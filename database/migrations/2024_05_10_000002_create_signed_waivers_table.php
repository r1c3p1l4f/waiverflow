<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('signed_waivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('waiver_template_id')->constrained('waiver_templates');
            $table->json('signed_content');
            $table->text('signature_data'); // Base64 encoded signature image
            $table->string('ip_address')->nullable();
            $table->timestamp('signed_at');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signed_waivers');
    }
};
