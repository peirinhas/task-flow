<?php

declare(strict_types=1);

namespace TaskFlow\Shared\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * Kernel class that boots the Symfony framework and configures services and routes.
 *
 * This class is responsible for configuring the application container and routing.
 * It uses Symfony's MicroKernelTrait to simplify the boot process.
 *
 * @category Symfony
 * @package  TaskFlow\Shared\Infrastructure\Symfony
 * @author   Your Name <your.email@example.com>
 * @license  MIT
 * @link     https://your.project.link
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * {@inheritdoc}
     *
     * Returns the project directory path.
     *
     * @return string The project directory path.
     */
    public function getProjectDir(): string
    {
        return __DIR__ . '/../../../..';
    }

    /**
     * {@inheritdoc}
     *
     * Builds the container with any necessary configuration.
     *
     * @param ContainerBuilder $container The container builder.
     */
    public function build(ContainerBuilder $container): void
    {
        // Builds the container with any necessary configuration.
    }

    /**
     * {@inheritdoc}
     *
     * Boot the application by calling the parent boot method.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Configures the services container by importing YAML files.
     *
     * @param ContainerConfigurator $container The container configurator instance.
     *
     */
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../../../../config/{packages}/*.yaml');
        $container->import('../../../../config/{packages}/' . $this->getEnvironment() . '/*.yaml');
        $container->import('../../../../config/services.yaml');
        $container->import('../../../../config/{services}/*.yaml');
        $container->import('../../../../config/{services}_' . $this->getEnvironment() . '.yaml');
    }

    /**
     * Configures the routes by importing the YAML route files.
     *
     * @param RoutingConfigurator $routes The routing configurator instance.
     *
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../../../../config/{routes}/' . $this->getEnvironment() . '/*.yaml');
        $routes->import('../../../../config/{routes}/*.yaml');

        if (is_file(dirname(__DIR__, 4) . '/config/routes.yaml')) {
            $routes->import('../../../../config/routes.yaml');
        }
    }
}
