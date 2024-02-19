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
We will start by first adding the Deserialization Attack application:
![add_app](https://github.com/markyu0401/Deserialization-Attack/assets/60618569/16e609c9-5446-4c6c-b70a-c7885dff74d9)
Next, click the View link to go to the application-specific page and start the application containers:
![start](https://github.com/markyu0401/Deserialization-Attack/assets/60618569/5c4b954a-7cf9-42e7-9e89-bc724233a1f3)
Once all the containers have started, launch the hacker and victim’s web interfaces in separate browser tabs by clicking the icon next to the container’s name:
