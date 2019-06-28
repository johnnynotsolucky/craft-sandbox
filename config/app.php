<?php

use Craft;
use yii\log\Logger as YiiLogger;
use samdark\log\PsrTarget;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use modules\sitemodule\Module;
use modules\sitemodule\RequestIdProcessor;

$logger = new Logger('website');
$stream = new StreamHandler(Craft::getAlias('@storage/logs/web.log'));
$stream->setFormatter(new JsonFormatter());

$logger->pushHandler($stream);

$requestIdProcessor = new RequestIdProcessor();
$logger->pushProcessor($requestIdProcessor);

$logger->pushProcessor(function ($record) {
    unset($record['context']['trace']);
    unset($record['context']['memory']);

    return $record;
});

$logLevels = [
    YiiLogger::LEVEL_INFO,
    YiiLogger::LEVEL_WARNING,
];

if (YII_DEBUG) {
    $logLevels = array_merge($logLevels, [
        // TODO
    ]);
}

return [
    'modules' => [
        'site-module' => [
            'class' => \modules\sitemodule\Module::class,
            'requestIdProcessor' => $requestIdProcessor,
        ],
    ],
    'bootstrap' => ['site-module'],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => PsrTarget::class,
                    'logger' => $logger,
                    'levels' => [YiiLogger::LEVEL_ERROR],
                    'logVars' => [],
                    'addTimestampToContext' => true,
                ],
                // Split the targets to specifically exclude classes which spam the logs, while
                // ensuring errors thrown in those classes are still logged.
                [
                    'class' => PsrTarget::class,
                    'logger' => $logger,
                    'levels' => $logLevels,
                    'except' => [
                        'yii\base\View::renderFile',
                        'yii\db\Command::*',
                        'yii\db\Connection::*'
                    ],
                    'logVars' => [],
                    'addTimestampToContext' => true,
                ],
            ],
        ],
    ],
];
