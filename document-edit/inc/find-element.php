<?php  require_once('../../private/initialize.php');
       session_start();
       if(isset($_POST['findSignature'])){
            $findSignature = SignatureDetail::find_by_user_ids($user_id);
            if(empty($findSignature)){
                exit(json_encode(['success' => true]));
            }else{
                exit(json_encode(['success' => false])); 
            }
       }

       if(isset($_POST['findElement'])){
           $path = 'upload/';
           $output = '<table class="table table-bordered">';
           $output .= '<tbody>';
           foreach($_SESSION["docu_edit"] as $keys => $values)
            {
               
                if($values["tool_id"] == $_POST["tool_id"])
                {
                    $name = $_POST["name"];
                    $user_id = $loggedInAdmin->id ?? 0;
                    $category = $_POST["category"];
                    // if($name == 'Sign'){
                        $tools = SignatureDetail::find_by_element(['user_id' => $user_id, 'category' => $category ]);
                        // pre_r($tools);
                        foreach($tools as $tool){
                            // $_SESSION["docu_edit"][$keys]['filename'] = $tool->filename;
                $output .= '<tr>';
                $output .= '<td><input type="radio" name="sign" class="form-check-input choose" id="select-img'.$keys.'" data-id="'.$keys.'"></td>';
                $output .= '<td><label class="form-check-label" for="select-img'.$keys.'" id="signature-img'.$keys.'"><img class="" src="'.$path.$tool->filename.'"></label></td>';
                $output .= '</td>';
                $output .= '</tr>';
                        // }
                        
                        // exit(json_encode(['img' => ]));
                    }
                    
                    // pre_r($_SESSION["docu_edit"]);
                    // unset($_SESSION["docu_edit"][$keys]);
                }
                
            }
            $output .= '</tbody>';
            $output .= '</table>';

            $data = array(
                'details'		=>	$output,
                // 'total_item'		=>	$total_item,
                // 'total_price'		=>	 number_format($total_price, 2),
                
            );	

            echo json_encode($data);
       }
        
    ?>