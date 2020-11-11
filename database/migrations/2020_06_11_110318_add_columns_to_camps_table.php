<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('camps', function (Blueprint $table)
        {
            $table->decimal('hd',10,2)->nullable()->default(235.00)->after('ends_at');
            $table->decimal('fd',10,2)->nullable()->default(395.00)->after('hd');
            $table->decimal('fhd',10,2)->nullable()->default(60.00)->after('fh');
            $table->decimal('ffd',10,2)->nullable()->default(75.00)->after('fhd');

            $table->string('hd_p_id')->nullable()->default('prod_HNnRQf8XskCyhf')->after('ffd');
            $table->string('fd_p_id')->nullable()->default('prod_HNnSMxNVjfVCKC')->after('hd_p_id');
            $table->string('fhd_hd_p_id')->nullable()->default('prod_HNmVeozJYil326')->after('fd_p_id');
            $table->string('fhd_fd_p_id')->nullable()->default('prod_HNnO4KY1teKDCJ')->after('fhd_hd_p_id');
            $table->string('ffd_hd_p_id')->nullable()->default('prod_HNnNzUD7iDtsoI')->after('fhd_fd_p_id');
            $table->string('ffd_fd_p_id')->nullable()->default('prod_HNnQjgcbT82bKe')->after('ffd_hd_p_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('camps', function (Blueprint $table)
        {
            $table->dropColumn('hd');
            $table->dropColumn('fh');
            $table->dropColumn('fhd');
            $table->dropColumn('ffd');

            $table->dropColumn('hd_p_id');
            $table->dropColumn('fd_p_id');
            $table->dropColumn('fhd_hd_p_id');
            $table->dropColumn('fhd_fd_p_id');
            $table->dropColumn('ffd_hd_p_id');
            $table->dropColumn('ffd_fd_p_id');
        });
    }
}
