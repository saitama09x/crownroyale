<?php

namespace App\Cells;

class FormField
{

    function textbox($params){

        $is_valid = '';
        $error_msg = '';
        if(isset($params['validator'])){
            if($params['validator']->hasError($params["name"])){
                $is_valid = 'is-invalid';
                $error_msg = $params['validator']->getError($params["name"]);
            }
        }
        
        $value = set_value($params["name"]);
        if(isset($params['value'])){
            $value = set_value($params["name"], $params['value']);
        }

        if($params['validator']->hasError($params["name"])){

            $field = '<div class="form-group">
                <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> ' . $error_msg . '</label><br />
                <label for="'.$params["name"].'">'.$params["label"].'</label>
                <input type="text" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }else{

            $field = '<div class="form-group">          
                 <label for="'.$params["name"].'">'.$params["label"].'</label>      
                <input type="text" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }

        

        return $field;
    }

    function passbox($params){

        $is_valid = '';
        $error_msg = '';
        if(isset($params['validator'])){
            if($params['validator']->hasError($params["name"])){
                $is_valid = 'is-invalid';
                $error_msg = $params['validator']->getError($params["name"]);
            }
        }
        
        $value = set_value($params["name"]);
        if(isset($params['value'])){
            $value = set_value($params["name"], $params['value']);
        }

        if($params['validator']->hasError($params["name"])){

            $field = '<div class="form-group">
                <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> ' . $error_msg . '</label><br />
                <label for="'.$params["name"].'">'.$params["label"].'</label>
                <input type="password" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }else{

            $field = '<div class="form-group">          
                 <label for="'.$params["name"].'">'.$params["label"].'</label>      
                <input type="password" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }

        

        return $field;
    }

    function datebox($params){

        $is_valid = '';
        $error_msg = '';
        if(isset($params['validator'])){
            if($params['validator']->hasError($params["name"])){
                $is_valid = 'is-invalid';
                $error_msg = $params['validator']->getError($params["name"]);
            }
        }
        
        $value = set_value($params["name"]);
        if(isset($params['value'])){
            $value = set_value($params["name"], $params['value']);
        }

        if($params['validator']->hasError($params["name"])){

            $field = '<div class="form-group">
                <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> ' . $error_msg . '</label><br />
                 <label for="'.$params["name"].'">'.$params["label"].'</label>
                <input type="date" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }else{

            $field = '<div class="form-group">    
                <label for="'.$params["name"].'">'.$params["label"].'</label>            
                <input type="date" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }

        

        return $field;
    }


    function select($params){
        
        $is_valid = '';
        $error_msg = '';
        if(isset($params['validator'])){
            if($params['validator']->hasError($params["name"])){
                $is_valid = 'is-invalid';
                $error_msg = $params['validator']->getError($params["name"]);
            }
        }

        $value = set_value($params["name"]);
        if(isset($params['value'])){
            $value = set_value($params["name"], $params['value']);
        }

        $opt = '';
        if(is_array($params['options'])){
            foreach($params['options'] as $o){
                $is_select = '';
                if($value == $o['value']){
                    $is_select = 'selected';
                }

                $opt .= '<option value="' . $o['value'] . '"'.$is_select.'>' . $o['label'] . '</option>';
            }
        }

        if($params['validator']->hasError($params["name"])){

            $field = '<div class="form-group">
                <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> ' . $error_msg . '</label><br />
                <label for="'.$params["name"].'">'.$params["label"].'</label>
                <select class="form-control '.$is_valid.'" name="'.$params["name"].'" id="'.$params["name"].'" aria-label="Floating label select example" aria-label="'.$params["label"].'">                 
                  '.$opt.'               
                </select>
              </div>';

        }
        else
        {

            $field = '<div class="form-group">
                <label for="'.$params["name"].'">'.$params["label"].'</label>
                <select class="form-control '.$is_valid.'" name="'.$params["name"].'" id="'.$params["name"].'" aria-label="Floating label select example" aria-label="'.$params["label"].'">                 
                  '.$opt.'               
                </select>
               
                <div class="invalid-feedback">
                  ' . $error_msg . '
                </div>
              </div>';

        }

        

        return $field;
    }

    function numbox($params){

        $is_valid = '';
        $error_msg = '';
        if(isset($params['validator'])){
            if($params['validator']->hasError($params["name"])){
                $is_valid = 'is-invalid';
                $error_msg = $params['validator']->getError($params["name"]);
            }
        }
        
        $value = set_value($params["name"]);
        if(isset($params['value'])){
            $value = set_value($params["name"], $params['value']);
        }

        if($params['validator']->hasError($params["name"])){

            $field = '<div class="form-group">
                <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> ' . $error_msg . '</label><br />
                <label for="'.$params["name"].'">'.$params["label"].'</label>
                <input type="number" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }else{

            $field = '<div class="form-group">          
                 <label for="'.$params["name"].'">'.$params["label"].'</label>      
                <input type="number" name="'.$params["name"].'" value="'. $value .'"  class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">
                </div>';

        }

        

        return $field;
    }


    function textarea($params){

        $is_valid = '';
        $error_msg = '';
        if(isset($params['validator'])){
            if($params['validator']->hasError($params["name"])){
                $is_valid = 'is-invalid';
                $error_msg = $params['validator']->getError($params["name"]);
            }
        }
        
        $value = set_value($params["name"]);
        if(isset($params['value'])){
            $value = set_value($params["name"], $params['value']);
        }
        
        if($params['validator']->hasError($params["name"])){

            $field = '<div class="form-group">
                <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> ' . $error_msg . '</label><br />
                <label for="'.$params["name"].'">'.$params["label"].'</label>
                <textarea name="'.$params["name"].'" class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">'. $value .'</textarea>
                </div>';

        }else{

            $field = '<div class="form-group">          
                 <label for="'.$params["name"].'">'.$params["label"].'</label>      
                <textarea name="'.$params["name"].'" class="form-control '.$is_valid.'" id="'.$params["name"].'" placeholder="'.$params["label"].'">'. $value .'</textarea>
                </div>';

        }

        

        return $field;
    }

}
