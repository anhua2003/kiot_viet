<?php
//{lam_tron value=$so_lamTron currency=$setup.currency decimal=$setup.decimal}
function smarty_function_lamTron($params, &$smarty)
{

    $value = $params['value'];
    $currency = $params['currency'];
    $decimal = $params['decimal'];

    if($currency == 'USD'){
        //USD
        $have_decimal = number_format(fmod( $value , 0.1), 2);
        if($have_decimal != 0){

            if($have_decimal < 0.05){
                $value = $value - $have_decimal;
                return number_format($value, $decimal, '.', ',');
            }else if($have_decimal == 0.05){
                return number_format($value, $decimal, '.', ',');
            }else{
                $value = $value + (0.1 - $have_decimal);
                return number_format($value, $decimal, '.', ',');
            }

        }else{
            return number_format($value, $decimal, '.', ',');
        }
    }else{
        //VND
        $have_decimal = number_format(fmod( $value , 1000), 0);
        if( $have_decimal != 0 ){

            if( $have_decimal < 500){
                $value = $value - $have_decimal;
                return number_format($value, $decimal, '.', ',');
            }else if( $have_decimal == 500 ){
                return number_format($value, $decimal, '.', ',');
            }else{
                $value = $value + (1000 - $have_decimal);
                return number_format($value, $decimal, '.', ',');
            }
            
        }else{
            return number_format($value, $decimal, '.', ',');
        }
    }
}
