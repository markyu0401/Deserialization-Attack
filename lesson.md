---
title: "Deserialization/Serialization Attack"
teaching: 3
exercises: 30
questions:
- "What is deserialization/serialization?"
- "What are the php magic methods?"
- "What are the countermeasures?"
objectives:
- "Describe deserialization attacks."
- "Understand simple exploit."
- "Write code that avoid deserialization attacks."
---


## What is deserialization/serialization?

Serialization is the process of turning some object into a data format that can be restored later.
People often serialize objects in order to save them to storage, or to send as part of
communications. In php, the code looks like this: serialize(mixed $value): string

Deserialization is the reverse of that process, taking data structured from some format, and
rebuilding it into an object. Today, the most popular data format for serializing data is JSON.
Before that, it was XML. In php, the code looks like this:
unserialize(string $data, array $options = []): mixed
![demodiagram](https://github.com/markyu0401/Deserialization-Attack/assets/60618569/e9ac88ff-50bb-4e5e-802b-989fb8f7e830)

## What are the php magic methods?

In PHP, magic methods are special methods that allow you to define custom behavior for certain
actions or events that occur on an object. These methods are automatically called by PHP based
on specific naming conventions, and they override the default behavior of PHP for those actions.

For example, __sleep() is a magic method in PHP that is called automatically when the
serialize() function is called on an object. PHP checks if the class of the object being serialized
has a method named __sleep(). If such a method exists, it is executed before the serialization
process starts. This allows you to define custom logic to prepare the object for serialization, such
as cleaning up sensitive data or performing additional data manipulation.
![deserphp](https://github.com/markyu0401/Deserialization-Attack/assets/60618569/3e84e433-2db1-477f-8e19-357c0508fa42)

The code defines a PHP class called "test" using the "class" keyword. The class has a single
method called "__sleep()". The "__sleep()" method is a magic method in PHP that is
automatically called when you try to serialize an object of this class using the "serialize()"
function.
![desersleep](https://github.com/markyu0401/Deserialization-Attack/assets/60618569/bea89035-748a-4d46-ae38-448ebcfdb8ac)

Within the "__sleep()" method, the code echoes the string "__sleep method called" using the
"echo" statement. This string will be printed when the "__sleep()" method is executed during
serialization.

The "__sleep()" method also returns an empty array using "return array();". In PHP, the purpose
of the "__sleep()" method is to allow you to specify which properties of an object should be
serialized. By returning an array of property names from "__sleep()", you can selectively choose
which properties should be included in the serialized representation of the object. In this case, an
empty array is returned, which means no properties will be serialized. You don’t need to pay
much attention to this property as it does not relate to the attack explained today
"serialize($new_test);"

The "serialize()" function is called with "$new_test" as an argument, which serializes the object
into a string representation. During serialization, PHP automatically calls the "__sleep()" method
of the "test" class, which echoes the string "__sleep method called" and returns an empty array.

## What are the countermeasures?

1. Input Validation: Validate and sanitize all input data, especially data that is being
deserialized. Implement strict input validation to ensure that only expected data types and
formats are accepted. Discard or reject any unexpected or malicious data during
deserialization.

2. Implement Access Controls: Implement access controls and permissions to restrict the
deserialization process to authorized users or systems. Limit the privileges of the
deserialized objects to the minimum necessary for their intended use.

3. Use Secure Serialization Methods: Use secure serialization methods, such as PHP's
"json_encode()" and "json_decode()" functions, which are less prone to deserialization
vulnerabilities compared to other serialization methods like "serialize()" and
"unserialize()".

### Demonstration

The demonstration on CHEESEHub illustrates an SSH Honeypot by using two machines; a server and client. The server utilizes a modified version of the
OpenSSH library obtained from the [LongTail Project's GitHub](https://github.com/wedaa/LongTail-Log-Analysis). SSH connections to the server can still be
made on the non-standard port number 49000. The *rsyslog* utility is used to log these messages to the standard /var/log/messages file.

We validate the SSH Honeypot from the client in the following way:

1. The client attempts to SSH to the server using the username *test* and the standard port 22 and port 2222. Even with the correct SSH password,
we will notice that SSH access is denied. At the same time, we will see these SSH attempts logged in /var/log/messages on the server.
2. The client will then use the right non-standard port, 49000 and be able to SSH to the server successfully.

> ## Getting Started
>
> You will need to create an account on [CHEESEHub](https://www.hub.cheesehub.org) to work through this exercise.
> Each container in this demonstration has a web interface and is accessible through your web browser, no other special software
> is needed.
{: .callout}

We will start by first adding the SSH Honeypot application:

![Add SSH Honeypot]({{ page.root }}/fig/honeypot/catalog.png)

Next, click the *View* link to go to the application-specific page and start the application containers:

![Start Containers]({{ page.root }}/fig/honeypot/containers.png)

> ## Container Launch Errors
>
> If a container fails to start, you will see a flashing warning icon next to the container's name. Take a look at the logs to
> determine the cause of failure and try deleting the application and restarting.
{: .callout}

Once all the containers have started, you should notice a green status bar indicating success:

![Launch Succeeded]({{ page.root }}/fig/honeypot/launched.png)

We will use the console interface to enter commands for the server and client. Clicking the icon in the *Console* column for
the two containers should launch a new browser tab with an embedded terminal window:

![Open Console]({{ page.root }}/fig/honeypot/console.png)

We will start with the server. Let's determine the IP address of the server since it is needed to SSH to it from the client. At
the terminal prompt, type *ifconfig*:

~~~
# ifconfig
~~~
{: .language-bash}

~~~
eth0: flags=4163<UP,BROADCAST,RUNNING,MULTICAST> mtu 1376
	inet 10.32.0.9 netmask 255.240.0.0 broadcast 10.47.255.255
	...
~~~
{: .output}

Make a note of the *inet* address returned on your terminal. Next, we will start tracking the messages being logged to study SSH
connections being attempted from the client. At the server terminal prompt type:

To find the IP address of the server, use the *ifconfig* command at the server terminal:

~~~
# tail -f /var/log/messages
~~~
{: .language-bash}

~~~
2020-05-04T18:17:11.164928+00:00 snlzfj-honeypotserver-f8df2 sshd-22[60]: ...
2020-05-04T18:17:11.172877+00:00 snlzfj-honeypotserver-f8df2 sshd-2222[62]: ...
~~~
{: .output}

Ignore these initial errors being reported in the log file. The *tail* command will not return; instead as new messages are logged to
this file, they will appear at the bottom of the terminal window.

Next, we will switch to the client terminal. We will first attempt to SSH to the server as the *term* user using the standard SSH port, 22.
At the client's terminal prompt type:

~~~
# ssh term@10.32.0.9
~~~
{: .language-bash}

~~~
The authenticity of host '10.32.0.9 (10.32.0.9)' can't be established.
ECDSA key fingerprint is SHA256....
Are you sure you want to continue connecting (yes/no)?
~~~
{: .output}

> ## Server IP address
>
> Make sure to use the right server IP address instead of 10.32.0.9 above
{: .callout}

At the prompt, type *yes* to continue connecting. When prompted for the password, we will try using both the correct password
(*term*) and other random passwords:

~~~
term@10.32.0.9's password:
Permission denied, please try again.
term@10.32.0.9's password:
Permission denied, please try again.
term@10.32.0.9's password:
term@10.32.0.9: Permission denied (password, keyboard-interactive).
~~~
{: .language-bash}

Irrespective of the password entered, permission will always be denied for each of the three attempts provided.
Repeat this experiment with a different SSH port, 2222. At the client terminal, type:

~~~
# ssh -p 2222 term@10.32.0.9
~~~
{: .language-bash}

~~~
term@10.32.0.9's password:
~~~
{: .output}

Again, irrespective of the password entered (correct or incorrect), permission will always be denied in this case as well.

We will next check to see how these SSH attempts have been logged on the server. On the server's terminal, inspect the
messages being displayed on the terminal window:

~~~
# 2020-05-04T18:18:56.649082+00:00 snlzfj-honeypotserver-f8df2 sshd-2222[80]: IP: 10.32.0.7 Pass2222Lo
g: Username: term Password term
# 2020-05-04T18:18:56.649111+00:00 snlzfj-honeypotserver-f8df2 sshd-2222[80]: Failed password for term
 from 10.32.0.7 port 43484 ssh2
 # 2020-05-04T18:18:57.310475+00:00 snlzfj-honeypotserver-f8df2 sshd-2222[80]: IP: 10.32.0.7 Pass2222Lo
 g: Username: term Password foo
 ...
~~~
{: .language-bash}

Note that we can determine the IP address of the client and the username and password that was used in each of the SSH attempts
from the client.

Finally we will validate that we can still SSH to the server. At the client prompt, try to SSH using the correct higher port number, 49000:

~~~
# ssh -p 49000 term@10.32.0.9
~~~
{: .language-bash}

~~~
The authenticity of host '10.32.0.9 (10.32.0.9)' can't be established.
ECDSA key fingerprint is SHA256....
Are you sure you want to continue connecting (yes/no)?
~~~
{: .output}

Use the right password, *term* this time. You should be dropped into a shell on the server machine:

~~~
term@10.32.0.9's password:
term@snlzfj-honeypotserver-f8df2:~$
~~~
{: .language-bash}

> ## SSH honeypot
>
> In this lesson, we demonstrated how a SSH Honeypot can be used to track brute force attacks on a SSH port. The attacker can be fooled into thinking
that they simply have the wrong password by having the standard SSH port seemingly operate as usual. Analysis of the passwords can reveal leaks or even
the strategies employed by the attacker to generate random passwords.
{: .callout}

{% include links.md %}
