# Symfony Service Replacer

Provides a way to replace services in a Symfony Dependency Injection Container at runtime.

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

## Usage

Each service that you want to replace at runtime is decorated with a proxy that acts exactly like the original service.
By default, this proxy forwards calls to the original service and returns their results unchanged. You have to
explicitly mark the services you want to replace with the `replaceable` tag:

```yaml
# config/services.yaml
services:
  replaceable_service:
    # ...
    tags: [replaceable]
```

The `JulienFalque\SymfonyServiceReplacer\ServiceReplacer` public service can be used to replace a service at runtime:

```php
$service = $container->get('replaceable_service');

echo "{$service->foo()}\n";

$replacer = $container->get(JulienFalque\SymfonyServiceReplacer\ServiceReplacer::class);
$replacer->replace('replaceable_service', new class() {
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

The replacer service can also be accessed with its alias `service_replacer`.
