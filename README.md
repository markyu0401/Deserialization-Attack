# Wen
a building-in-progress project for Wen
installation
```
Docker build -t <victim image tag of your choice> .
Docker build -t <secure image tag of your choice> .
Docker build -t <attacker image tag of your choice> .
```
After images built, containers has to run in certain condition
```
Docker run -d -p 80:80 <image tag name>
Docker run -d -p 443:443 <image tag name>
Docker run -d -p 6080:80 <image tag name>
```
