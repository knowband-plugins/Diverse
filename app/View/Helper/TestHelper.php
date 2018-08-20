<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Images helper
 *
 * @author Mohit Kochhar
 */

class TestHelper extends AppHelper {

    public function getLineNumber($key_path, $json_string){
        $allwords = explode('/',$key_path);
        $shifted_array = array_reverse($allwords);
        $array = json_decode($json_string, true);
        $testarray = json_decode($json_string, true);
        $this->recur_ksort($array);
        $this->recur_ksort($testarray);
        $test = array();
        $i = 0;
        foreach($allwords as $word){
            
            if(count($allwords)-1 !== $i ){
                if(isset($array[$word])){
                    $array = $array[$word];
                }elseif(isset($array[0][$word])){
                    $array = $array[0][$word];
                }else{
                    $array = $array[$word];
                }
            }
            if($word == end($allwords)){
                if(isset($array[$word])){
                    $array[$word] = $array[$word]."_______MAK";
                }elseif(isset($array[0][$word])){
                    $array[0][$word] = $array[0][$word]."_______MAK";
                }
            }
            $i++;
        }
        $filter_array = array();
        $j = 0;
        foreach($shifted_array as $word){
            if($word == end($allwords)){
                $filter_array = $array;
            }else{
                $tmp_filter_array = $filter_array;
                $filter_array = array();
                $filter_array[$word] = $tmp_filter_array;
            }
        }
        
        $t = array_replace_recursive($testarray,$filter_array);
        $new_string = json_encode($t, JSON_PRETTY_PRINT);
        $content = explode(PHP_EOL, $new_string);
        $line_inc = 0;
        foreach($content as $con) {
            if(strpos($con,'_______MAK') !== false){
                break;
            }
            $line_inc++;
        }
       return $line_inc;
       
    }
    protected function recur_ksort(&$array) {
       foreach ($array as &$value) {
          if (is_array($value)) $this->recur_ksort($value);
       }
       return ksort($array);
    }
}

?>
