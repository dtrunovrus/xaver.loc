<?php

require_once './FirePhpCore/FirePHP.class.php';

function autoLoadClasses($class) {
    require_once './' . $class . '.php';
}

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info) {
    // Если использовалась @, ничего не делать.
    if (!error_reporting())
        return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>";
    print_r($info);
    echo "</pre>";
    exit();
}

function myLogger($db, $sql, $caller)
{  
  $firePHP = FirePHP::getInstance(true);
  $firePHP->setEnabled(true);

  if (isset($caller['file']))
  {
     $firePHP->group("at ".$caller['file'].' line '.$caller['line']);
     $firePHP->log($sql);
     $firePHP->groupEnd();
  }
}

?>