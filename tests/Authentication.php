<?php

use Laravel\Spark\Spark;


/**
 * Class AuthenticationTestingTrait
 */
trait Authentication
{
    static $usesGenericUser = true;

    /**
     * @return \App\User
     */
    public function user()
    {
        return $this->app['auth']->user();
    }

    protected function setUpAuthentication()
    {
        if (static::$usesGenericUser) {
            $this->be(factory(App\User::class)->create());
        }
    }

    public function asDeveloper(string $email = null)
    {
        $email ?? $email = collect(Spark::$developers)->first();

        $this->be(App\User::whereEmail($email)->firstOrFail());
        return $this;
    }

    public function be(\Illuminate\Contracts\Auth\Authenticatable $user, $driver = null)
    {
        parent::be($user, $driver);
        $this->seeIsAuthenticatedAs($user);

        return $this;
    }
}