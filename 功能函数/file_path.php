  <?php
   function traverse($path = '.') {
    $current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
    while(($file = readdir($current_dir)) !== false) {    //readdir()返回打开目录句柄中的一个条目
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
        if($file == '.' || $file == '..') {
            continue;
        } else if(is_dir($sub_dir)) {    //如果是目录,进行递归
            echo 'Directory ' . $file . ':'."\n";
            traverse($sub_dir);
        } else {    //如果是文件,直接输出
            echo 'File in Directory ' . $path . ': ' . $file . "\n";
        }
    }
  }
  //traverse('./abc');
  function test($path='',$lv=0){
    is_dir($path) or die($path.' not is director');
    $dir=opendir($path);
    while(false!==$file=readdir($dir)){
        $sub_dir=$path.DIRECTORY_SEPARATOR.$file;
        if($file=='.' || $file == '..'){
            continue;
        }else if(is_dir($sub_dir)){
            echo str_repeat('  ',$lv).$file."\n"; 
            test($sub_dir,$lv+1);
        }else{
            echo str_repeat('  ',$lv)."$file\n";
        }
    }
    //return;
  }
  //test('./g');
  function test1($path='',$lv=0){
    file_exists($path) or die($path.' is not find');
    $head=opendir($path) or die('open the dir is error');
    while(false!==$file=readdir($head)){
        $sub_dir=$path.'\\'.$file;
        if($file=='.' || $file=='..'){
            continue;
        }else if(is_dir($sub_dir)){
            echo str_repeat('-',$lv).$file."\n";
            test1($sub_dir,$lv+1);
        }else{
            echo str_repeat('-',$lv).$file."\n";
        }
    }
  }
  //test1('./g');
  //图片转成base64并保存
function  pic($path){
    is_file($path) or die('is not file');
    $file_info=getimagesize($path);
    $file_type=$file_info['mime'];
    //var_export($file_info);
    $file_content=file_get_contents($path);
    $base64_header='data:'.$file_type.';base64,';
    $file_base64=$base64_header.chunk_split(base64_encode($file_content));
    echo '<img src="'.$file_base64.'">';
    $new_name=dirname($path).'/new'.substr($path,strrpos($path,'.'));
    $preg='/^data:(\w+)\/\w+;base64,(.*)/';
    preg_match($preg, $file_base64,$get_arr);
    //var_export($get_arr);
    file_put_contents($new_name, base64_decode($get_arr[2]));
}   
pic('./g/1.jpg');