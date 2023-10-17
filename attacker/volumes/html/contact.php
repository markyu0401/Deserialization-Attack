<?php



$name = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) ? $_POST['name'] : '';

$email = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) ? $_POST['email'] : '';

$comment = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) ? $_POST['comment'] : '';



// Give out error message if no POST request is detected

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo('Error: No POST request detected.');

    exit;

}



// Flag to indicate which method it uses. If POST set it to 1

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $post = 1;

}



// Simple server-side validation for POST data, of course, you should validate the email

$errors = array();

if (!$name) {

    $errors[] = 'Please enter your name.';

}

if (!$email) {

    $errors[] = 'Please enter your email.';

}

if (!$comment) {

    $errors[] = 'Please enter your message.';

}



// If the errors array is empty, send the mail

if (empty($errors)) {

    $new_customer = new customer;

    $new_customer->name = $name;

    $new_customer->email = $email;

    $new_customer->comment = $comment;

    $temp = serialize($new_customer);

} else {

    // Display the error messages

    for ($i = 0; $i < count($errors); $i++) {

        echo $errors[$i] . '<br/>';

    }

    echo '<a href="index.html">Back</a>';

    exit;

}



class customer

{

    public $name;

    public $email;

    public $comment;



    public function __sleep()

    {

        // Write the content to file once the object is serialized

        $filename = $this->name . '_' . $this->email;

        file_put_contents("./user_info/$filename", $this->comment, FILE_USE_INCLUDE_PATH);

    }

}



?>
