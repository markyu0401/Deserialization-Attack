<html>



<body>







<h1>This is the Debug Page</h1>



<p>Dev only</p>



<p>Note to self: use execute to execute file and use read to read file</p>



<?php

// Get user input from HTTP GET request and sanitize it

$read = isset($_GET['read']) ? trim($_GET['read']) : '';

$execute = isset($_GET['execute']) ? trim($_GET['execute']) : '';



// Check if file paths are valid

if (!empty($read) && is_readable($read)) {

  // Read contents of file specified by $read and include file specified by $execute

  echo file_get_contents($read, FILE_USE_INCLUDE_PATH);

} else {

  // Handle invalid input

  echo "Invalid file paths.";

}



if (!empty($execute) && is_readable($execute)) {

  // Read contents of file specified by $read and include file specified by $execute

  include $execute;

} else {

  // Handle invalid input

  echo "Invalid file paths.";

}

?>







</body>



</html>
