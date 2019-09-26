<?php
// Check for POST Variable
if(isset($_POST["msg"])) {
  $msg = $_POST["msg"];
  
  $protocol = 'tcp';
  $get_prot = getprotobyname($protocol);
  if ($get_prot === FALSE) {
    echo 'Ungueltiges Protokoll';
  }
  
  if( ! ($sock = socket_create(AF_INET, SOCK_STREAM, $get_prot)))
  {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Couldn't create socket: [$errorcode] $errormsg \n");
  }
  
  //set reusable
  if ( ! socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1)) { 
    echo socket_strerror(socket_last_error($sock)); 
    exit; 
  }
  
  if ( ! socket_set_option($sock,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>0, "usec"=>1))) { 
    echo socket_strerror(socket_last_error($sock)); 
    exit; 
  }
  
  $port = 5555;
  
  //get the server ip
  if(!($ip = gethostbyname('mz0001.ddns.net'))) {
    $ip = $_SERVER['SERVER_ADDR'];
  }
  
  if(!socket_connect($sock, $ip, $port)){
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Could not CONNECT socket : [$errorcode] $errormsg \n");
    
  }
  
  //######################
  //!!!IMPORTANT!!!
  //the server requires alinebreak to indicate the end of the message
  $msg .= "\n";
  $len = strlen($msg);
  //######################


  //Send the message to the server
  if( ! socket_send ( $sock , $msg , $len , 0))
  {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    die("Could not send data: [$errorcode] $errormsg \n");
  } else {
    //Now receive reply from server
    if(socket_recv ( $sock , $buf , 2045 , MSG_WAITALL ) === FALSE)
    {
      $errorcode = socket_last_error();
      $errormsg = socket_strerror($errorcode);
      die("Could not receive data: [$errorcode] $errormsg \n");
    }
  }
  echo "Server: " . $buf;
  socket_close($sock);
} else {
  echo "No message set!";
}