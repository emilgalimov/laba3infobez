<?php

main();
function main(){
    $permissionKeys=[0=>'NONCONFIDENTIAL',1=> 'CONFIDENTIAL', 2=>'SECRET', 'TOPSECRET'];
    $files=[
            'file1'=>'NONCONFIDENTIAL',
            'file2'=>'CONFIDENTIAL',
            'file3'=>'SECRET',
            'file4'=>'TOPSECRET',
        ];
    session_start();
    if (!isset($_SESSION['users'])){
    $_SESSION['users']=[
        'admin'=>'TOPSECRET',
        'User1'=>'CONFIDENTIAL',
        'User2'=>'NONCONFIDENTIAL',
        'User3'=>'SECRET',
        'Guest'=>'NONCONFIDENTIAL'
    ];
} 
if(!$_GET){
    echo('<form method="GET">
    <input type="textfield" name="user">
    <input type="submit">
    </form>');
}else{
    if(isset($_GET['lower'])){
        $_SESSION['users'][$_GET['user']]= $permissionKeys[array_search($_SESSION['users'][$_GET['user']],$permissionKeys)-1];
        return;
    }

    if(!isset($_GET['file'])){
        foreach($files as $name=>$file){
            echo ('<a href=/?user='.$_GET['user'].'&file='.$name.'&action=write>'.$name.' write</a> <a href=/?user='.$_GET['user'].'&file='.$name.'&action=read>'.$name.' read</a> <br>');
        }
        if(array_search($_SESSION['users'][$_GET['user']],$permissionKeys)>0){
            echo ('<a href=/?user='.$_GET['user'].'&lower=lower>make '.$_SESSION['users'][$_GET['user']].' lower</a> <br>');
        }
    }else{
        $bigger=array_search($files[$_GET['file']],$permissionKeys) < array_search($_SESSION['users'][$_GET['user']],$permissionKeys);
        $equal=array_search($files[$_GET['file']],$permissionKeys) == array_search($_SESSION['users'][$_GET['user']],$permissionKeys);
        //var_dump($bigger);
        // var_dump(array_search($files[$_GET['file']],$permissionKeys));
        //var_dump(array_search($_SESSION['users'][$_GET['user']],$permissionKeys));
        echo($files[$_GET['file']].' '.$_GET['file'].'<br>');
        if($_GET['action']=='read') {
            if($bigger || $equal){
                echo('Чтение разрешено');
            }else{
                echo('Чтение запрещено');
            }
        }
        if($_GET['action']=='write'){
            if(!$bigger || $equal){
                echo('запись разрешена');
            }else{
                echo('запись запрещена');
            }
        } 
       
    }

}



}