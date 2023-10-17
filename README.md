# Wen
a building-in-progress project for Wen
```
Docker build -t <victim image tag of your choice> .
```
```
Docker run -d -p 80:80 <image tag name>
```

```
Docker build -t <secure image tag of your choice> .
```
```
Docker run -d -p 443:443 <image tag name>
```

```
Docker build -t <attacker image tag of your choice> .
```
```
Docker run -d -p 6080:80 <image tag name>
```
