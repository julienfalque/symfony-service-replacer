# Symfony Service Replacer

Provides a way to replace services in a Symfony Dependency Injection Container at runtime for testing purposes.

## Installation

Install the package using Composer:

```console
$ composer require --dev julienfalque/symfony-service-replacer
```

Then enable the bundle in your Symfony application:

```php
<?php // config/bundles.php

return [
    // ...
    JulienFalque\SymfonyServiceReplacer\Bridge\Symfony\Bundle::class => ['test' => true],
];
```

The bundle decorates Symfony's test container (`test.service_container`) so make sure it is available by enabling
`FrameworkBundle`'s test mode:

```yaml
# config/packages/test/framework.yaml
framework:
  test: true
```

## Usage

To make a service replaceable at runtime, add the `replaceable` tag to it:

```yaml
# config/services.yaml
services:
  replaceable_service:
    # ...
    tags: [replaceable]
```

Each tagged service is decorated with a proxy that forwards calls to the original service and returns their results
unchanged. Tagged services don't need to be public to be replaced.

At runtime, the test container (`test.service_container`) now allows you to use the `set()` method to replace your
service and the `restore()` method to use the original service again:

```php
$service = $container->get('replaceable_service');

echo "{$service->foo()}\n";

$container->get('test.service_container')->set('replaceable_service', new class() {
    public function foo(): string
    {
        return 'Bar';
    }
});

echo "{$service->foo()}\n";

$replacer->restore('replaceable_service');

echo "{$service->foo()}\n";
```

Assuming that the original service's method returns `"Foo"`, this will output:

```
Foo
Bar
Foo
```
