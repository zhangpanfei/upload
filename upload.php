<?php

set_time_limit(0);
$path = __DIR__.'/upload';

try {
  if (!$_FILES['file']) {
    exit(json_encode(['code'=>1,'msg'=>'none file']));
  }

  if (!is_dir($path)) {
    mkdir($path);
  }

  $tmp_name = "{$path}/{$_POST['id']}_{$_POST['name']}";
  file_put_contents($tmp_name, file_get_contents($_FILES['file']['tmp_name']), FILE_APPEND | LOCK_EX);
  unlink($_FILES['file']['tmp_name']);

  if ($_POST['end']==1) {
    $name = $path .'/'. $_POST['name'];
    if (file_exists($name)) {
      $name = substr($name,0,strrpos($name,'.')) .time(). substr($name,strrpos($name,'.'));
    }
    rename($tmp_name,$name);
  }
  // sleep(2);
  echo json_encode([
    'code' => 0,
    'msg' => 'ok'
  ]);
} catch (Exception $e) {
  echo json_encode([
    'code' => 1,
    'msg' => $e->getMessage()
  ]);
}

