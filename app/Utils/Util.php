<?php

namespace App\Utils;

use App\Business;

class Util
{
	/**
     * This function unformats a number and returns them in plain eng format
     * 
     * @param int $input_number
     *
     * @return float
     */
	public function num_uf($input_number, $currency_details = []){
          $thousand_separator  = '';
          $decimal_separator  = '';

          if(!empty($currency_details)){
               $thousand_separator = $currency_details->thousand_separator;
               $decimal_separator = $currency_details->decimal_separator;
          } else {
               $thousand_separator = session('currency')['thousand_separator'];
               $decimal_separator = session('currency')['decimal_separator'];
          }

		$num = str_replace($thousand_separator, '', $input_number);
		$num = str_replace($decimal_separator, '.', $num);

		return (float)$num;
	}

	/**
     * This function formats a number and returns them in specified format
     * 
     * @param int $input_number
     * @param boolean $add_symbol = false
     *
     * @return string
     */
	public function num_f($input_number, $add_symbol = false){
          $formatted = number_format($input_number, 2, session('currency')['decimal_separator'], session('currency')['thousand_separator']);

          if($add_symbol){
               
               if(session('business.currency_symbol_placement') == 'after'){
                    $formatted = $formatted . ' ' . session('currency')['symbol'];
               } else {
                    $formatted = session('currency')['symbol'] . ' ' . $formatted;
               }
          }

          return $formatted;
	}

     /**
     * Calculates percentage for a given number
     * 
     * @param int $number
     * @param int $percent
     * @param int $addition default = 0
     *
     * @return float
     */
     public function calc_percentage($number, $percent, $addition = 0){ 
          return ($addition + ($number * ($percent / 100)));
     }

     /**
     * Calculates base value on which percentage is calculated
     * 
     * @param int $number
     * @param int $percent
     *
     * @return float
     */
     public function calc_percentage_base($number, $percent){ 

          return ($number * 100) / (100 + $percent);
     }

     /**
     * Calculates percentage
     * 
     * @param int $base
     * @param int $number
     *
     * @return float
     */
     public function get_percent($base, $number){ 

          $diff = $number - $base;
          
          return ($diff / $base) * 100;
     }

     //Returns all avilable purchase statuses
     public function orderStatuses(){
          return [ 'received' => __('lang_v1.received'), 'pending' => __('lang_v1.pending'), 'ordered' => __('lang_v1.ordered')];
     }
     
     /**
     * Defines available Payment Types
     *
     * @return array
     */
     public function payment_types(){ 
          $payment_types = ['cash' => __('lang_v1.cash'), 'card' => __('lang_v1.card'), 'cheque' => __('lang_v1.cheque'), 'bank_transfer' => __('lang_v1.bank_transfer'), 'other' => __('lang_v1.other')];

          return $payment_types;
     }

     /**
     * Returns the list of modules enabled
     *
     * @return array
     */
     public function allModulesEnabled(){
        $enabled_modules = session('business')['enabled_modules'];
        $enabled_modules = (!empty($enabled_modules) && $enabled_modules != 'null') ? json_decode($enabled_modules) : [];

        return $enabled_modules;
        //Module::has('Restaurant');
     }

     /**
     * Returns the list of modules enabled
     *
     * @return array
     */
     public function isModuleEnabled($module){
        $enabled_modules = $this->allModulesEnabled();

        if(in_array($module, $enabled_modules)){
            return true;
        } else {
            return false;
        }
     }

     /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false) 
     * @return strin
     */
     public function uf_date($date, $time = false){
          $date_format = session('business.date_format');
          $mysql_format = 'Y-m-d';
          if($time){
               if(session('business.time_format') == 12){
                    $date_format = $date_format . ' h:i A';
               } else {
                    $date_format = $date_format . ' H:i';
               }
               $mysql_format = 'Y-m-d H:i:s';
          }

          return \Carbon::createFromFormat($date_format, $date)->format($mysql_format);
     }


     /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false) 
     * @return strin
     */
     public function format_date($date, $show_time = false){
          $format = session('business.date_format');
          if(!empty($show_time)){
               if(session('business.time_format') == 12){
                    $format .= ' h:i A';
               } else {
                    $format .= ' H:i';
               }
          }
          return \Carbon::createFromTimestamp(strtotime($date))->format($format);
     }


}