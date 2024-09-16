<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->string('nationality');
			$table->integer('ethnicity');
			$table->integer('religion');
			$table->string('languages');
			$table->integer('body');
			$table->string('country');
			$table->string('city');
			$table->integer('education');
			$table->integer('occupation');
			$table->integer('star_sign');
			$table->integer('relationship_status');
			$table->integer('kids');
			$table->text('about');
		});
	}


	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('nationality');
			$table->dropColumn('ethnicity');
			$table->dropColumn('religion');
			$table->dropColumn('languages');
			$table->dropColumn('body');
			$table->dropColumn('country');
			$table->dropColumn('city');
			$table->dropColumn('education');
			$table->dropColumn('occupation');
			$table->dropColumn('star_sign');
			$table->dropColumn('relationship_status');
			$table->dropColumn('kids');
			$table->dropColumn('about');
		});
	}
};
