<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id(); // `id` sebagai Primary Key dengan AUTO_INCREMENT
            $table->string('plan_name', 100);
            $table->boolean('is_default');
            $table->decimal('point_per_day', 20, 8);
            $table->string('version');
            $table->decimal('earning_rate', 20, 8);
            $table->decimal('price', 20, 8);
            $table->integer('duration');
            $table->decimal('profit', 20, 8);

            $table->timestamps(); // Opsional, jika kamu ingin menambahkan kolom created_at dan updated_at
        });

        // Menambahkan data awal
        $initialData = [
            [
                'plan_name'         => 'Free',
                'is_default'        => true,
                'point_per_day'     => 0.02000000,
                'version'           => 'Free',
                'earning_rate'      => 0.00091389,
                'price'             => 0.00000000,
                'duration'          => 0,
                'profit'            => 100,
            ],
            [
                'plan_name'         => 'Plan 1',
                'is_default'        => false,
                'point_per_day'     => 0.10000000,
                'version'           => 'Plan 1',
                'earning_rate'      => 0.05091389,
                'price'             => 5.00000000,
                'duration'          => 10,
                'profit'            => 110,
            ],
            [
                'plan_name'         => 'Plan 2',
                'is_default'        => false,
                'point_per_day'     => 0.10000000,
                'version'           => 'Plan 2',
                'earning_rate'      => 0.55099089,
                'price'             => 10.00000000,
                'duration'          => 10,
                'profit'            => 110,
            ],
            [
                'plan_name'         => 'Plan 3',
                'is_default'        => false,
                'point_per_day'     => 0.10000000,
                'version'           => 'Plan 3',
                'earning_rate'      => 5.25091389,
                'price'             => 20.00000000,
                'duration'          => 20,
                'profit'            => 150,
            ],
        ];

        DB::table('plans')->insert($initialData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
