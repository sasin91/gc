<?php

namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected function setUpTraits()
    {
        parent::setUpTraits();
        $uses = array_flip(class_uses_recursive(static::class));

        if (isset($uses[DatabaseSetup::class])) {
            $this->setupDatabase();
        }
        
        if (isset($uses[Authentication::class])) {
            $this->setUpAuthentication();
        }
    }

    /**
     * Create the test response instance from the given response.
     *
     * @overrides \Illuminate\Foundation\Testing\Concerns\MakesHttpRequests
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function createTestResponse($response)
    {
        return TestResponse::fromBaseResponse($response);
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }
}
