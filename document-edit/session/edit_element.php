<?php  require_once('../../private/initialize.php');

if(isset($_POST['tool_top_pos'])){
     $tool_id = $_POST['tool_id'];
     $element = DocumentResource::find_by_tool_id($tool_id);
     $args = [
          'tool_pos_top' => $_POST['tool_top_pos'],
          'tool_pos_left' => $_POST['tool_left_pos'],
     ];
     $element->merge_attributes($args);
     $result = $element->save();
}

if(isset($_POST['edit_text'])){
     $tool_id = $_POST['tool_id'];
     $textArea = TextAreaDetails::find_by_tool($tool_id);
     $data = [
          'text_value' => $_POST['text_value'],
     ];
     $textArea->merge_attributes($data);
     // pre_r($textArea);
     $result = $textArea->save();
     if($result == true){
          exit(json_encode(['success' => true]));
     }
}

if(isset($_POST['resize'])){
     $tool_id = $_POST['tool_id'];
     $element = DocumentResource::find_by_tool_id($tool_id);
     $args = [
          'tool_width' => $_POST['tool_width'],
          'tool_height' => $_POST['tool_height'],
     ];
     $element->merge_attributes($args);
     $result = $element->save();
     if($result == true){
          exit(json_encode(['success' => true, 'tool_width' => $_POST['tool_width'], 'tool_height' => $_POST['tool_height'] ]));
     }
     // pre_r($element);
}

// if($_POST['tool_text'] == "Textarea"){
//      $textArea = TextAreaDetails::find_by_tool_id($tool_id);
//      $data = [
//           'text_value' => $_POST['text_value'],
//      ];
//      $textArea->merge_attributes($data);
//      $result = $textArea->save();
// }

?>