<?php

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use App\Image\Drawer;
use App\Image\Driver\GdDriver;
use App\Image\Config\Validator;
use App\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;

$container = new ContainerBuilder();

$container->register('image.config.validator', Validator::class);
$container->register('image.driver', GdDriver::class);
$container->register('image.drawer', Drawer::class)
          ->setArguments([new Reference('image.driver')]);

$container->register('context', RequestContext::class);

$container->register('matcher', UrlMatcher::class)
          ->setArguments([
              include __DIR__ . '/routes.php',
              new Reference('context')
            ]);

$container->register('request_stack', RequestStack::class);

$container->register('controller_resolver', ControllerResolver::class)
          ->setArguments([$container]);

$container->register('argument_resolver', ArgumentResolver::class);

$container->register('listener.router', RouterListener::class)
          ->setArguments([new Reference('matcher'), new Reference('request_stack')]);

$container->register('listener.exception', ExceptionListener::class)
          ->setArguments(['App\\Controller\\ExceptionController::handle']);

$container->register('dispatcher', EventDispatcher::class)
          ->addMethodCall('addSubscriber', [new Reference('listener.router')])
          ->addMethodCall('addSubscriber', [new Reference('listener.exception')]);

$container->register('http_kernel', HttpKernel::class)
          ->setArguments([
              new Reference('dispatcher'),
              new Reference('controller_resolver'),
              new Reference('request_stack'),
              new Reference('argument_resolver')
            ]);

$container->register('http_cache', HttpCache::class)
          ->setArguments([
              new Reference('http_kernel'),
              new Store(__DIR__ . '/../cache')
            ]);

return $container;
