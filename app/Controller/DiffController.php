<?php

/**
 * Dashboard Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Velocity Software Solutions (http://www.velsof.com)
 * @link          http://www.mockingfish.com MockingFish Project
 * @since         3 Feb 2015
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		 1.0
 * @todo
 */
class DiffController extends AppController {


    function beforeFilter() {
        $this->Auth->allow('index','prettify','exportToExcel');
    }
    public function index() {
        if ($this->request->is("post")) {
            $treewalker = new TreeWalker(array(
                "debug" => true, //true => return the execution time, false => not
                "returntype" => "array")         //Returntype = ["obj","jsonstring","array"]
            );

            $left_data = $this->request->data("left_data");
            $left_data = empty($left_data)?"{}":$left_data;
            $left_data_array = json_decode($left_data, true);
            $right_data = $this->request->data("right_data");
            $right_data = empty($right_data)?"{}":$right_data;
            $right_data_array = json_decode($right_data, true);
            
            $left_data_array_tmp = $left_data_array;
            $right_data_array_tmp = $right_data_array;
            
            $left_pretty_data = json_encode($left_data_array_tmp, JSON_PRETTY_PRINT);
            $right_pretty_data = json_encode($right_data_array_tmp, JSON_PRETTY_PRINT);
            
            if($this->request->data("filterarray")){
                $this->filterArray($right_data_array);
                $this->filterArray($left_data_array);
            }

            $diff = $treewalker->getdiff($left_data_array, $right_data_array, false); // false -> with slashs
            $new_data = array();
            $removed_data = array();
            $edited_data = array();
            foreach ($diff as $type => $data) {
                if ($type === "new") {
                    $new_data["count"] = count($data);
                    $new_data["data"] = $data;
                }
                if ($type === "removed") {
                    $removed_data["count"] = count($data);
                    $removed_data["data"] = $data;
                }
                if ($type === "edited") {
                    $edited_data["count"] = count($data);
                    $edited_data["data"] = $data;
                }
            }
            
            $this->set('left_data',$left_pretty_data);
            $this->set('right_data',$right_pretty_data);
            
            $this->set("new_data",$new_data);
            $this->set("removed_data",$removed_data);
            $this->set("edited_data",$edited_data);
            $this->layout = false;
            $this->render("diff");
        }
		$this->set("jsondiff", true);
		$this->set("subtitle", "JSON Difference");
    }

    protected function filterArray(&$assocarray)
    {
        if (is_array($assocarray)) {
            foreach ($assocarray as $key => $value) {
                if (isset($assocarray[$key])) {
                    if(is_numeric($key)){
                        array_splice($assocarray, 1, count($assocarray));
                    }
                    if (gettype($assocarray[$key]) == "array") {
                        $this->filterArray($assocarray[$key]);
                    }elseif (gettype($assocarray[$key]) == "object") {
                        $this->filterArray((array)$assocarray[$key]);
                    }
                }
            }
        }
    }
    public function prettify(){
        $this->layout = false;
        if($this->request->is("post")){
            $string = $this->request->data('dirtydata');
            $json_array = json_decode($string, true);
            if($json_array !== false && $json_array !== NULL){
                $this->recur_ksort($json_array);
                $pretty_data = json_encode($json_array, JSON_PRETTY_PRINT);
                echo $pretty_data;
            }else{
                echo "";
            }
        }
        die;
    }
    protected function recur_ksort(&$array) {
       foreach ($array as &$value) {
          if (is_array($value)) $this->recur_ksort($value);
       }
       return ksort($array);
    }
    public function exportToExcel(){
        if ($this->request->is("post")) {
            $treewalker = new TreeWalker(array(
                "debug" => true, //true => return the execution time, false => not
                "returntype" => "array")         //Returntype = ["obj","jsonstring","array"]
            );

            $left_data = $this->request->data("left_data");
            $left_data = empty($left_data)?"{}":$left_data;
            $left_data_array = json_decode($left_data, true);
            $right_data = $this->request->data("right_data");
            $right_data = empty($right_data)?"{}":$right_data;
            $right_data_array = json_decode($right_data, true);
            
            $left_data_array_tmp = $left_data_array;
            $right_data_array_tmp = $right_data_array;
            
            $left_pretty_data = json_encode($left_data_array_tmp, JSON_PRETTY_PRINT);
            $right_pretty_data = json_encode($right_data_array_tmp, JSON_PRETTY_PRINT);
            
            if($this->request->data("filterarray")){
                $this->filterArray($right_data_array);
                $this->filterArray($left_data_array);
            }

            $diff = $treewalker->getdiff($left_data_array, $right_data_array, false); // false -> with slashs
            $new_data = array();
            $removed_data = array();
            $edited_data = array();
            foreach ($diff as $type => $data) {
                if ($type === "new") {
                    $new_data["count"] = count($data);
                    $new_data["data"] = $data;
                }
                if ($type === "removed") {
                    $removed_data["count"] = count($data);
                    $removed_data["data"] = $data;
                }
                if ($type === "edited") {
                    $edited_data["count"] = count($data);
                    $edited_data["data"] = $data;
                }
            }
            $fp = fopen(WWW_ROOT . "DiverseReport.csv", "w");
            fputcsv($fp, array("MISSING ELEMENTS IN RIGHT SIDE","Value"));
            fputcsv($fp, array("",""));
            foreach($new_data["data"] as $key => $datum){
                fputcsv($fp, array($key,$datum));
            }
            fputcsv($fp, array("",""));
            fputcsv($fp, array("",""));
            fputcsv($fp, array("",""));
            fputcsv($fp, array("NEW ELEMENTS IN RIGHT SIDE","Value"));
            fputcsv($fp, array("",""));
            foreach($removed_data["data"] as $key => $datum){
                fputcsv($fp, array($key,$datum));
            }
            fputcsv($fp, array("",""));
            fputcsv($fp, array("",""));
            fputcsv($fp, array("",""));
            fputcsv($fp, array("MISMATCHED VALUES","Old Value","New Value"));
            fputcsv($fp, array("",""));
            foreach($edited_data["data"] as $key => $datum){
                fputcsv($fp, array($key,$datum["oldvalue"],$datum["newvalue"]));
            }
            fclose($fp);
            die;
            
        }
    }

}

?>
