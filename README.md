# Deserialization Attack
By Zhenyu Wen, Qingchen Yu <br>

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
rebuild it into an object. <br>

### Students 
If you are a student in cybersecurity class, you can get further practical experience with how deserialization/serialization is used to prevent attacks. <br>
## Design and Architecture
This demonstration uses three Docker containers, one each for attacker, victim, and secure. Attacker functions by using 'gobuster' to attack the victim and secure, the host of a website, the website secure is protected. <br>

## Installation and Usage
The recommended approach to running this set of containers is on CHEESEHub, a web platform for cybersecurity demonstrations. CHEESEHub provides the necessary resources for orchestrating and running containers on demand. In order to set up this application to be run on CHEESEHub, an application specification needs to be created that configures the Docker image to be used, memory and CPU requirements, and, the ports to be exposed for each of the three containers. 

CHEESEHub uses Kubernetes to orchestrate its application containers. You can also run this application on your own Kubernetes installation. For instructions on setting up a minimal Kubernetes cluster on your local machine, refer to Minikube.

Before being able to run on either CHEESEHub or Kubernetes, Docker images need to be built for the three application containers. <br>

### Installation
To Build The Container
```
docker build -t <victim image tag of your choice> .
docker build -t <secure image tag of your choice> .
docker build -t <attacker image tag of your choice> .
```
After images are built, containers have to run in a certain condition
```
docker run -d -p 80:80 <image tag name>
docker run -d -p 443:443 <image tag name>
docker run -d -p 6080:80 <image tag name>
```
### Usage
CHEESEHub has the instructions provided by the SEED Project. The user will have to compile the programs available and figure out how to carry out the steps in the instructions. 
