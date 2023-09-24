  <?php
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
      $data = json_decode(file_get_contents('messages.json'), true) ?: [];
      $data[] = $message;
      file_put_contents('messages.json', json_encode($data));
  }
  
  ?>
  
