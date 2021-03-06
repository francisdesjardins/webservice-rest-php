# webservice-rest-php

A simple REST helper for Fat-Free-Framework

## WIP

Nothing much to say here ... it is a work-in-process ... you will have to figure out how to use it ... but do not worry friends, there are some examples to help you with that in [tests](https://github.com/francisdesjardins/webservice-rest-php/tree/master/tests/www).

## quick and dirty example

### index.php


```php
require_once '../../../vendor/autoload.php';

use FrancisDesjardins\WebService\Rest\Responder\Encoder\NoopResponderEncoder;
use FrancisDesjardins\WebService\Rest\Responder\ErrorResponder;
use FrancisDesjardins\WebService\Rest\Utility;

/** @var Base $fw */
$fw = Base::instance();

//! load globals
$fw->config('../app/globals.ini');

//! load globals (OS specific)
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $fw->config('../app/globals.windows.ini');
} else {
    $fw->config('../app/globals.linux.ini');
}

//! load custom sections
$fw->config('../app/custom.ini');

//! load mappings
$fw->config('../app/maps.ini');

//! global error handler
if (!Utility::instance()->debug()) {
    $fw->set('ONERROR', function (Base $fw) {
        Utility::instance()->flushOutputBuffer();

        $responder = new ErrorResponder($fw);

        $responder->respond(new NoopResponderEncoder());
    });
}

//! run it!
$fw->run();
```

### a mapping

```php
namespace FrancisDesjardins\WebService\Rest\Maps;

use FrancisDesjardins\WebService\Rest\AbstractRest;
use FrancisDesjardins\WebService\Rest\AuditTrait;
use FrancisDesjardins\WebService\Rest\DynamicData;
use FrancisDesjardins\WebService\Rest\ErrorEnum;
use FrancisDesjardins\WebService\Rest\Event\ErrorEvent;
use FrancisDesjardins\WebService\Rest\FatFreeFrameworkTrait;
use FrancisDesjardins\WebService\Rest\Responder\Encoder\GzipResponderEncoder;
use FrancisDesjardins\WebService\Rest\Responder\JSONResponderTrait;
use FrancisDesjardins\WebService\Rest\Security;
use FrancisDesjardins\WebService\Rest\SecurityRule\LocalhostSecurityRule;
use FrancisDesjardins\WebService\Rest\Test\Models\Result\Ok;
use FrancisDesjardins\WebService\Rest\UtilityTrait;

class Example extends AbstractRest
{
    use AuditTrait;
    use FatFreeFrameworkTrait;
    use JSONResponderTrait; // every VERB respond as application/json
    use UtilityTrait;

    // do something before routing
    public function before()
    {
        // ex: allow only localhost access
        Security::instance()->addRule(new LocalhostSecurityRule());

        // ex: audit a token
        if (!self::audit()->uuid(self::fff()->get('PARAMS.uuid'))) {
            // generate a 500 error in the headers and return {error: 5001} to the client
            self::dispatchEvent(new ErrorEvent(ErrorEnum::ERROR500(), 5001));
        }
    }

    // do something on 'GET'
    public function get() {
        // and reply
        $this->setData(new DynamicData(['property1' => 'value1']));
    }

    // do something on 'POST'
    public function post() {
        // retrieve the data; eventually it will be automatic
        $data = self::utility()->convertUnicodeToUTF8(self::fff()->get('BODY'));

        if ($data !== '') {
            // do something
        }

        // and reply
        $this->setData(new Ok());
    }

    // do something after routing
    public function after() {
        // we want every VERB to GZIP the response; can also be set per VERB
        $this->setEncoder(new GzipResponderEncoder());
    }
}
```
