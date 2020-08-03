<?php

require_once './vendor/autoload.php';

use Report\Report;
use Report\Command\CustomerReportEUR;
use Report\Command\CustomerReportGBP;
use Report\Command\CustomerReportUSD;
use Report\Helper\ParseTransactionCsv;
use Report\Model\TransactionRepository;
use Report\Service\CurrencyExchange;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();
$containerBuilder->register('application', Application::class);
$containerBuilder->register('exchange', CurrencyExchange::class);
$containerBuilder
    ->register('parser.csv', ParseTransactionCsv::class)
    ->addArgument(__DIR__.DIRECTORY_SEPARATOR.'data.csv')
;

$containerBuilder
    ->setDefinition(TransactionRepository::class,
        (new Definition(TransactionRepository::class))
            ->setArgument(0, $containerBuilder->get('parser.csv'))
    )
;

$containerBuilder
    ->register('report', Report::class)
    ->addArgument(new Reference(TransactionRepository::class))
    ->addArgument(new Reference('exchange'))
;

$containerBuilder
    ->register('command.report.eur.customer', CustomerReportEUR::class)
    ->addArgument(new Reference('report'))
;
$containerBuilder
    ->register('command.report.usd.customer', CustomerReportUSD::class)
    ->addArgument(new Reference('report'))
;
$containerBuilder
    ->register('command.report.gbp.customer', CustomerReportGBP::class)
    ->addArgument(new Reference('report'))
;

$application = $containerBuilder->get('application');

$application->add($containerBuilder->get('command.report.eur.customer'));
$application->add($containerBuilder->get('command.report.usd.customer'));
$application->add($containerBuilder->get('command.report.gbp.customer'));

//$application->setDefaultCommand($command->getName(), true);

$application->run();
