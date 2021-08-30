<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewEcmColumnToEcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecm', function (Blueprint $table) {
            $table->string('underlit_type_of_lamp')->nullable();
            $table->string('underlit_unit_price_of_lamp')->nullable();
            $table->string('underlit_lumen_of_lamp')->nullable();
            $table->string('underlit_power_rating_of_lamp')->nullable();
            $table->string('underlit_difference_in_lux')->nullable();
            $table->string('underlit_number_of_lamp_required')->nullable();
            $table->string('underlit_investment_cost')->nullable();
            $table->string('underlit_annual_energy_consumption')->nullable();
            $table->string('underlit_annual_energy_cost')->nullable();

            $table->string('overlit_type_of_lamp')->nullable();
            $table->string('overlit_unit_price_of_lamp')->nullable();
            $table->string('overlit_lumen_of_lamp')->nullable();
            $table->string('overlit_power_rating_for_lamp')->nullable();
            $table->string('overlit_difference_in_lux')->nullable();
            $table->string('overlit_number_of_delamping')->nullable();
            $table->string('overlit_annual_energy_consumption')->nullable();
            $table->string('overlit_annual_energy_cost')->nullable();
            $table->string('overlit_annual_energy_saving')->nullable();
            $table->string('overlit_annual_cost_saving')->nullable();
            $table->string('overlit_investment_cost')->nullable();
            $table->string('overlit_payback_period')->nullable();

            $table->string('efficacy_current_total_lumen')->nullable();
            $table->string('efficacy_current_power_rating')->nullable();
            $table->string('efficacy_current_efficacy_lamp')->nullable();
            $table->string('efficacy_current_total_number_of_lamp')->nullable();
            $table->string('efficacy_corrective_type_of_lamp')->nullable();
            $table->string('efficacy_corrective_efficacy_of_lamp')->nullable();
            $table->string('efficacy_corrective_unit_price_of_lamp')->nullable();
            $table->string('efficacy_corrective_lumen_of_lamp')->nullable();
            $table->string('efficacy_corrective_power_rating')->nullable();
            $table->string('efficacy_corrective_number_of_lamp_required')->nullable();
            $table->string('efficacy_corrective_annual_energy_consumption')->nullable();
            $table->string('efficacy_corrective_annual_energy_cost')->nullable();
            $table->string('efficacy_corrective_annual_energy_saving')->nullable();
            $table->string('efficacy_corrective_investment_cost')->nullable();
            $table->string('efficacy_corrective_payback_period')->nullable();
            $table->string('efficacy_corrective_')->nullable();

            $table->string('maximize_duration_of_daylight_usage')->nullable();
            $table->string('maximize_annual_energy_saving')->nullable();
            $table->string('maximize_annual_energy_cost_saving')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecm', function (Blueprint $table) {
            //
        });
    }
}
