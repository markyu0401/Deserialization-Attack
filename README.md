# Deserialization Attack
By Qingchen Yu, Zhenyu Wen <br>
A building-in-progress project for Wen<br>

## Description of the attack
Serialization is the process of turning some object into a data format that can be restored later.
People often serialize objects in order to save them to storage, or to send as part of
communications. In php, the code looks like this: serialize(mixed $value): string

Deserialization is the reverse of that process, taking data structured from some format, and
rebuilding it into an object. Today, the most popular data format for serializing data is JSON.
Before that, it was XML. In php, the code looks like this:
unserialize(string $data, array $options = []): mixed

## Target Audience

### Instructors
Suppose you are an instructor teaching cybersecurity concerts. In that case, you can use this example to provide hands-on experience with deserialization, demonstrating how to take data structured from some format and
rebuild it into an object. <be>

### Students
If you are a student in cybersecurity class, you can get further practical experience with how deserialization/serialization is used to prevent attacks. <br>
## Design and Architecture
This demonstration uses two Docker containers, one each for attacker, victim, and secure. Attacker functions by using 'gobuster' to attack the victim and secure, the host of a website, the website secure is protected. <be>

## Installation and Usage
The recommended approach to running this set of containers is on CHEESEHub, a web platform for cybersecurity demonstrations. CHEESEHub provides the necessary resources for orchestrating and running containers on demand. In order to set up this application to be run on CHEESEHub, an application specification needs to be created that configures the Docker image to be used, memory and CPU requirements, and, the ports to be exposed for each of the three containers. The JSON spec for this SSH Honeypot demonstration can be found here.

CHEESEHub uses Kubernetes to orchestrate its application containers. You can also run this application on your own Kubernetes installation. For instructions on setting up a minimal Kubernetes cluster on your local machine, refer to Minikube.

Before being able to run on either CHEESEHub or Kubernetes, Docker images need to be built for the three application containers. <be>

### Installation
To Build The Container
```
Docker build -t <victim image tag of your choice> .
Docker build -t <secure image tag of your choice> .
Docker build -t <attacker image tag of your choice> .
```
After images are built, containers have to run in a certain condition
```
Docker run -d -p 80:80 <image tag name>
Docker run -d -p 443:443 <image tag name>
Docker run -d -p 6080:80 <image tag name>
```
### Usage
1. On the attacker-10 vm, open a terminal. To access the attacker-10 vm, on your browser,
   enter the address http://attacker_ip to access the VNC session. You may run ``` docker inspect          <image tag name> ``` to find the container's IP address.

2. Enter the command apt update -y && apt upgrade -y && apt install
   gobuster -y to install a tool called gobuster.

3. Then on the victim-11 vm, open a terminal, type the command
   ```
   sudo apt-get update
   sudo apt-get install net-tools
   ```
   then type the command ifconfig to check the IP of the server.

4. On the attacker-10 vm, open firefox browser, or install any browser you like. Enter
   http://victim_ip to the URL bar to access the VNC session

5. Try going through the website like a normal user, is there anywhere you can exploit,
   anything you can enter?

6. Then, on the attacker vm. use the command gobuster -w
   /wordlist/wordlist_php http://victim_ip to list the directory and hidden
   file on the webserver. Feel free to try other web enumeration tools, and use different
   wordlist as well.

7. After running the gobuster rto enumerate the hidden file on the webserver, you will find a
   new file called debug.php running on the website. To open debug.php, use the command
   http://victim_ip/debug.php

8. Now you have found the debug.php, it’s a mistake made by the developer. To access the
   source code of debug.php, you can enter the URL: viewsource:http://192.168.0.11/debug.php?              read=debug.php to view the source code of the
   debug.php.
