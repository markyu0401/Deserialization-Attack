# Deserialization Attack
By Qingchen Yu, Zhenyu Wen <br>
A building-in-progress project for Wen<br>

##Demostration of the attack
##Target Audience
###Instructors
Suppose you are an instructor teaching cybersecurity concerts. In that case, you can use this example to provide hands-on experience with deserialization, demonstrating how to take data structured from some format and
rebuild it into an object. <br>
###Students
If you are a student in cybersecurity class, you can get further practical experience with how deserialization/serialization is used to prevent attacks. <br>
## Design and Architecture
This demonstration uses two Docker containers, one each for attacker, victim, and secure. Attacker functions by using 'gobuster' to attack the victim and secure, the host of a website, the website secure is protected. <br>
## Installation and Usage
The recommended approach to running this set of containers is on CHEESEHub, a web platform for cybersecurity demonstrations. CHEESEHub provides the necessary resources for orchestrating and running containers on demand. In order to set up this application to be run on CHEESEHub, an application specification needs to be created that configures the Docker image to be used, memory and CPU requirements, and, the ports to be exposed for each of the three containers. The JSON spec for this SSH Honeypot demonstration can be found here.

CHEESEHub uses Kubernetes to orchestrate its application containers. You can also run this application on your own Kubernetes installation. For instructions on setting up a minimal Kubernetes cluster on your local machine, refer to Minikube.

Before being able to run on either CHEESEHub or Kubernetes, Docker images need to be built for the three application containers. <br>
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
