<h1 align="center">Supports</h1>

[![Linter Status](https://github.com/supen/supports/workflows/Linter/badge.svg)](https://github.com/supen/supports/actions) 
[![Tester Status](https://github.com/supen/supports/workflows/Tester/badge.svg)](https://github.com/supen/supports/actions) 
[![Latest Stable Version](https://poser.pugx.org/supen/supports/v/stable)](https://packagist.org/packages/supen/supports)
[![Total Downloads](https://poser.pugx.org/supen/supports/downloads)](https://packagist.org/packages/supen/supports)
[![Latest Unstable Version](https://poser.pugx.org/supen/supports/v/unstable)](https://packagist.org/packages/supen/supports)
[![License](https://poser.pugx.org/supen/supports/license)](https://packagist.org/packages/supen/supports)


handle with array/config/log/guzzle etc.

## About log

### Register

#### Method 1

A application logger can extends `Supen\Supports\Log` and modify `createLogger` method, the method must return instance of `Monolog\Logger`.

```PHP
use Supen\Supports\Log;
use Monolog\Logger;

class APPLICATIONLOG extends Log
{
    /**
     * Make a default log instance.
     *
     * @author supen <supen.huang@qq.com>
     *
     * @return Logger
     */
    public static function createLogger()
    {
        $handler = new StreamHandler('./log.log');
        $handler->setFormatter(new LineFormatter("%datetime% > %level_name% > %message% %context% %extra%\n\n"));

        $logger = new Logger('supen.private_number');
        $logger->pushHandler($handler);

        return $logger;
    }
}
```

#### Method 2

Or, just init the log service with:

```PHP
use Supen\Supports\Log;

protected function registerLog()
{
    $logger = Log::createLogger($file, $identify, $level);

    Log::setLogger($logger);
}
```

### Usage

After registerLog, you can use Log service:

```PHP
use Supen\Supports\Log;

Log::debug('test', ['test log']);
```
