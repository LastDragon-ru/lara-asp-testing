# (Laravel) Testing Helpers 🐝

This package provides various useful asserts for [PHPUnit](https://phpunit.de/) and better solution for HTTP tests - testing HTTP response has never been so easy! And this not only about `TestResponse` but any PSR response 😎

[include:exec]: <../../dev/artisan lara-asp-documentator:requirements>
[//]: # (start: 876a9177c0e8e3722ac84e8f3888245fc9070a64a87dedfe7c9d9ba2a13b374b)
[//]: # (warning: Generated automatically. Do not edit.)

# Requirements

| Requirement  | Constraint          | Supported by |
|--------------|---------------------|------------------|
|  PHP  | `^8.3` |   `HEAD ⋯ 5.0.0`   |
|  | `^8.2` |   `HEAD ⋯ 2.0.0`   |
|  | `^8.1` |   `HEAD ⋯ 2.0.0`   |
|  | `^8.0` |   `4.6.0 ⋯ 2.0.0`   |
|  | `^8.0.0` |   `1.1.2 ⋯ 0.12.0`   |
|  | `>=8.0.0` |   `0.11.0 ⋯ 0.4.0`   |
|  | `>=7.4.0` |   `0.3.0 ⋯ 0.1.0`   |
|  Laravel  | `^11.0.0` |   `HEAD ⋯ 6.2.0`   |
|  | `^10.34.0` |   `HEAD ⋯ 6.2.0`   |
|  | `^10.0.0` |   `6.1.0 ⋯ 2.1.0`   |
|  | `^9.21.0` |   `5.6.0 ⋯ 5.0.0-beta.1`   |
|  | `^9.0.0` |   `5.0.0-beta.0 ⋯ 0.12.0`   |
|  | `^8.22.1` |   `3.0.0 ⋯ 0.2.0`   |
|  | `^8.0` |  `0.1.0`   |
|  PHPUnit  | `^11.0.0` |   `HEAD ⋯ 6.2.0`   |
|  | `^10.1.0` |   `HEAD ⋯ 6.0.0`   |

[//]: # (end: 876a9177c0e8e3722ac84e8f3888245fc9070a64a87dedfe7c9d9ba2a13b374b)

[include:template]: ../../docs/Shared/InstallationDev.md ({"data": {"package": "testing"}})
[//]: # (start: 9c57d43303e5ef82308c0c83e328e2a47be808a50cd12d6fc5bcfd9229e2fa7c)
[//]: # (warning: Generated automatically. Do not edit.)

# Installation

> [!NOTE]
>
> The package intended to use in dev.

```shell
composer require --dev lastdragon-ru/lara-asp-testing
```

[//]: # (end: 9c57d43303e5ef82308c0c83e328e2a47be808a50cd12d6fc5bcfd9229e2fa7c)

# Usage

> [!IMPORTANT]
>
> By default, package overrides scalar comparator to make it strict! So `assertEquals(true, 1)` is `false`.

In the general case, you just need to update `tests/TestCase.php` to include most important things, but you also can include only desired features, please see related traits and extensions below.

[include:example]: ./docs/Examples/TestCase.php
[//]: # (start: d64050243e2262fdd649a43b4d5b7f9784ba701372776c15d760357c38e581e1)
[//]: # (warning: Generated automatically. Do not edit.)

```php
<?php declare(strict_types = 1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use LastDragon_ru\LaraASP\Testing\Assertions\Assertions;
use LastDragon_ru\LaraASP\Testing\Concerns\Concerns;

abstract class TestCase extends BaseTestCase {
    use Assertions;         // Added
    use Concerns;           // Added
    use CreatesApplication;
}
```

[//]: # (end: d64050243e2262fdd649a43b4d5b7f9784ba701372776c15d760357c38e581e1)

# Comparators

> [!TIP]
>
> Should be registered before test, check/use [built-in traits](./src/Concerns).

## [`DatabaseQueryComparator`](./src/Comparators/DatabaseQueryComparator.php)

[include:docblock]: ./src/Comparators/DatabaseQueryComparator.php
[//]: # (start: 7a62eb5ab5b51b15a59381fa5096469c57dcc949fdd58877a499377d9bf38783)
[//]: # (warning: Generated automatically. Do not edit.)

Compares two `LastDragon_ru\LaraASP\Testing\Database\QueryLog\Query`.

We are performing following normalization before comparison to be more precise:

* Renumber `laravel_reserved_*` (it will always start from `0` and will not contain gaps)
* Format the query by [`doctrine/sql-formatter`](https://github.com/doctrine/sql-formatter) package

[//]: # (end: 7a62eb5ab5b51b15a59381fa5096469c57dcc949fdd58877a499377d9bf38783)

## [`EloquentModelComparator`](./src/Comparators/EloquentModelComparator.php)

[include:docblock]: ./src/Comparators/EloquentModelComparator.php
[//]: # (start: 742d5ba3dd2046d479175b032d84d30a4df86f84392aaf531a00a6734f096a5d)
[//]: # (warning: Generated automatically. Do not edit.)

Compares two Eloquent Models.

The problem is models after creating from the factory and selecting from
the database may have different types for the same properties. For example,
`factory()->create()` will set `key` as `int`, but `select` will set it to
`string` and (strict) comparison will fail. This comparator normalizes
properties types before comparison.

[//]: # (end: 742d5ba3dd2046d479175b032d84d30a4df86f84392aaf531a00a6734f096a5d)

## [`ScalarStrictComparator`](./src/Comparators/ScalarStrictComparator.php)

[include:docblock]: ./src/Comparators/ScalarStrictComparator.php
[//]: # (start: 3880fe84d738503ce8fff5b3ea187ef860c1d6bf96ce2347e9dc1daeb78f9815)
[//]: # (warning: Generated automatically. Do not edit.)

Makes comparison of scalars strict.

[//]: # (end: 3880fe84d738503ce8fff5b3ea187ef860c1d6bf96ce2347e9dc1daeb78f9815)

# Extensions

## PHPUnit `TestCase`

### [`RefreshDatabaseIfEmpty`](./src/Database/RefreshDatabaseIfEmpty.php) 💀

[include:docblock]: ./src/Database/RefreshDatabaseIfEmpty.php
[//]: # (start: 8a2c47eb73624557058f09279338b44619ddc48d2bd07d975721ad9383bd1df3)
[//]: # (warning: Generated automatically. Do not edit.)

The trait is very similar to standard `Illuminate\Foundation\Testing\RefreshDatabase` but there is one
difference: it will refresh the database only if it is empty. This is very
useful for local testing and allow significantly reduce bootstrap time.

[//]: # (end: 8a2c47eb73624557058f09279338b44619ddc48d2bd07d975721ad9383bd1df3)

```php
<?php declare(strict_types = 1);

namespace Tests;

use LastDragon_ru\LaraASP\Testing\Database\RefreshDatabaseIfEmpty;
use LastDragon_ru\LaraASP\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;
    use RefreshDatabaseIfEmpty;

    protected function shouldSeed() {
        return true;
    }
}
```

### [`WithTempDirectory`](./src/Utils/WithTempDirectory.php)

[include:docblock]: ./src/Utils/WithTempDirectory.php
[//]: # (start: 78a4084c4d654afec0aa0997e7db4c9d90c1ea9c9d56013b4c7b76212e2a25d2)
[//]: # (warning: Generated automatically. Do not edit.)

Allows to create a temporary directory. The directory will be removed
automatically after script shutdown.

[//]: # (end: 78a4084c4d654afec0aa0997e7db4c9d90c1ea9c9d56013b4c7b76212e2a25d2)

### [`WithTempFile`](./src/Utils/WithTempFile.php)

[include:docblock]: ./src/Utils/WithTempFile.php
[//]: # (start: 996fe2b95b3b243907ca30266266354dc6cf1609b6186cad7418b27f92e292a2)
[//]: # (warning: Generated automatically. Do not edit.)

Allows to create a temporary file. The file will be removed automatically
after script shutdown.

[//]: # (end: 996fe2b95b3b243907ca30266266354dc6cf1609b6186cad7418b27f92e292a2)

### [`WithTestData`](./src/Utils/WithTestData.php)

[include:docblock]: ./src/Utils/WithTestData.php
[//]: # (start: ca67a4f998b93fa54ef80b687ed7b9c81c10001161d64282afde47d9b923665f)
[//]: # (warning: Generated automatically. Do not edit.)

Allows to get instance of `LastDragon_ru\LaraASP\Testing\Utils\TestData` (a small helper to load data
associated with test)

[//]: # (end: ca67a4f998b93fa54ef80b687ed7b9c81c10001161d64282afde47d9b923665f)

## Laravel `TestCase`

### [`WithTranslations`](./src/Utils/WithTranslations.php)

[include:docblock]: ./src/Utils/WithTranslations.php
[//]: # (start: 0e8393713b25b89be1ee5c685bf900c5886a18a09f340b910b310e5026c4af1f)
[//]: # (warning: Generated automatically. Do not edit.)

Allows to replace translation strings for Laravel.

[//]: # (end: 0e8393713b25b89be1ee5c685bf900c5886a18a09f340b910b310e5026c4af1f)

### [`Override`](./src/Concerns/Override.php)

[include:docblock]: ./src/Concerns/Override.php
[//]: # (start: 0d844e46d631c5ddcead26ce0fe232ee3894cd4c98a426394ba836bbed51bbc2)
[//]: # (warning: Generated automatically. Do not edit.)

Similar to `Illuminate\Foundation\Testing\Concerns\InteractsWithContainer` but will mark test as failed if
override was not used while test (that helps to find unused code).

[//]: # (end: 0d844e46d631c5ddcead26ce0fe232ee3894cd4c98a426394ba836bbed51bbc2)

## Eloquent Model Factory

### [`FixRecentlyCreated`](./src/Database/Eloquent/Factories/FixRecentlyCreated.php)

[include:docblock]: ./src/Database/Eloquent/Factories/FixRecentlyCreated.php
[//]: # (start: 064636127cefc5b4434785c3b9caa626aa8210d13353719070e53b480f4ec6b5)
[//]: # (warning: Generated automatically. Do not edit.)

After creating the model will have `wasRecentlyCreated = true`, in most
cases this is unwanted behavior, this trait fixes it.

[//]: # (end: 064636127cefc5b4434785c3b9caa626aa8210d13353719070e53b480f4ec6b5)

### [`WithoutModelEvents`](./src/Database/Eloquent/Factories/WithoutModelEvents.php)

[include:docblock]: ./src/Database/Eloquent/Factories/WithoutModelEvents.php
[//]: # (start: 18945dddaa888ad73a3bd3eb516b4aa1b74cdce6c2c112ae691ce5f0196b1e03)
[//]: # (warning: Generated automatically. Do not edit.)

Disable models events during make/create.

[//]: # (end: 18945dddaa888ad73a3bd3eb516b4aa1b74cdce6c2c112ae691ce5f0196b1e03)

# Mixins

## `\Illuminate\Testing\TestResponse`

| Name                                                                        | Description                                                    |
|-----------------------------------------------------------------------------|----------------------------------------------------------------|
| [`assertThat()`](./docs/Assertions/AssertThatResponse.md)                   | Asserts that response satisfies given constraint.              |
| [`assertContentType()`](./docs/Assertions/AssertThatResponse.md)            | Asserts that a response has a specified content type.          |
| [`assertStatusCode()`](./docs/Assertions/AssertThatResponse.md)             | Asserts that a response has a specified status code.           |
| [`assertJsonMatchesSchema()`](./docs/Assertions/AssertJsonMatchesSchema.md) | Asserts that a response contains JSON that matches the schema. |
| [`assertXmlMatchesSchema()`](./docs/Assertions/AssertXmlMatchesSchema.md)   | Asserts that a response contains XML that matches the schema.  |

# Assertions

[include:document-list]: ./docs/Assertions
[//]: # (start: 86d73ad55f2c494dfe35350837400088c82dfa7457eafd0d30392ba96bbbdc9a)
[//]: # (warning: Generated automatically. Do not edit.)

## `assertDatabaseQueryEquals`

Asserts that SQL Query equals SQL Query.

[Read more](<docs/Assertions/AssertDatabaseQueryEquals.md>).

## `assertJsonMatchesSchema`

Asserts that JSON matches [schema](https://json-schema.org/). Validation based on the [Opis JSON Schema](https://github.com/opis/json-schema) package.

[Read more](<docs/Assertions/AssertJsonMatchesSchema.md>).

## `assertPsrResponse`

Asserts that PSR Response satisfies given constraint (we have a lot of built-in [constraints](../../src/Constraints/Response) and [responses](../../src/Responses), but, of course, you can create a custom).

[Read more](<docs/Assertions/AssertPsrResponse.md>).

## `assertQueryLogEquals`

Asserts that `QueryLog` equals `QueryLog`.

[Read more](<docs/Assertions/AssertQueryLogEquals.md>).

## `assertScheduled`

Asserts that Schedule contains task.

[Read more](<docs/Assertions/AssertScheduled.md>).

## `assertScoutQueryEquals`

Asserts that Scout Query equals Scout Query.

[Read more](<docs/Assertions/AssertScoutQueryEquals.md>).

## `assertThatResponse` 💀

Asserts that PSR Response satisfies given constraint (we have a lot of built-in [constraints](../../src/Constraints/Response) and [responses](../../src/Responses), but, of course, you can create a custom).

[Read more](<docs/Assertions/AssertThatResponse.md>).

## `assertXmlMatchesSchema`

Asserts that XML matches schema [XSD](https://en.wikipedia.org/wiki/XML_Schema_(W3C)) or [Relax NG](https://en.wikipedia.org/wiki/RELAX_NG). Validation based on the standard methods of [`DOMDocument`](https://www.php.net/manual/en/class.domdocument.php) class.

[Read more](<docs/Assertions/AssertXmlMatchesSchema.md>).

[//]: # (end: 86d73ad55f2c494dfe35350837400088c82dfa7457eafd0d30392ba96bbbdc9a)

# Laravel Response Testing

What is wrong with the [Laravel approach](https://laravel.com/docs/http-tests)? Well, there are two big problems.

## Where is the error?

You never know why your test failed and need to debug it to find the reason. Real-life example:

```php
<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(IndexController::class)]
class IndexControllerTest extends TestCase {
    public function testIndex() {
        $this->get('/')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json');
    }
}
```

<details>
<summary>assertOk() failed</summary>

```text
Testing started at 15:46 ...
PHPUnit 9.5.0 by Sebastian Bergmann and contributors.

Random Seed:   1610451974


Expected status code 200 but received 500.
Failed asserting that 200 is identical to 500.
 vendor/laravel/framework/src/Illuminate/Testing/TestResponse.php:186
 app/Http/Controllers/IndexControllerTest.php:16



Time: 00:01.373, Memory: 26.00 MB
```

</details>

<details>
<summary>assertHeader() failed</summary>

```text
Testing started at 17:57 ...
PHPUnit 9.5.0 by Sebastian Bergmann and contributors.

Random Seed:   1610459878


Header [Content-Type] was found, but value [text/html; charset=UTF-8] does not match [application/json].
Failed asserting that two values are equal.
Expected :'application/json'
Actual   :'text/html; charset=UTF-8'
<Click to see difference>

 vendor/laravel/framework/src/Illuminate/Testing/TestResponse.php:229
 app/Http/Controllers/IndexControllerTest.php:18



Time: 00:01.082, Memory: 24.00 MB


FAILURES!
Tests: 1, Assertions: 3, Failures: 1.

Process finished with exit code 1
```

</details>

> Expected status code 200 but received 500.

Hmmm, 500, probably this is php error? Why? Where? 😰

Compare with:

```php
<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use LastDragon_ru\LaraASP\Testing\Constraints\Response\ContentTypes\JsonContentType;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Response;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\Ok;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(IndexController::class)]
class IndexControllerTest extends TestCase {
    public function testIndex() {
        $this->get('/')->assertThat(new Response(
            new Ok(),
            new JsonContentType()
        ));
    }
}
```

<details>
<summary>assertThat() failed</summary>

```text
PHPUnit 9.5.0 by Sebastian Bergmann and contributors.

Random Seed:   1610461475


Failed asserting that GuzzleHttp\Psr7\Response Object &000000001ef973410000000013328b0b (
    'reasonPhrase' => 'Internal Server Error'
    'statusCode' => 500
    'headers' => Array &0 (
        'cache-control' => Array &1 (
            0 => 'no-cache, private'
        )
        'date' => Array &2 (
            0 => 'Tue, 12 Jan 2021 14:24:36 GMT'
        )
        'content-type' => Array &3 (
            0 => 'text/html; charset=UTF-8'
        )
    )
    'headerNames' => Array &5 (
        'cache-control' => 'cache-control'
        'date' => 'date'
        'content-type' => 'content-type'
        'set-cookie' => 'Set-Cookie'
    )
    'protocol' => '1.1'
    'stream' => GuzzleHttp\Psr7\Stream Object &000000001ef972d20000000013328b0b (
        'stream' => resource(846) of type (stream)
        'size' => null
        'seekable' => true
        'readable' => true
        'writable' => true
        'uri' => 'php://temp'
        'customMetadata' => Array &6 ()
    )
) has Status Code is equal to 200.

<!doctype html>
<html class="theme-light">
<!--
Error: Call to undefined function App\Http\Controllers\dview() in file app/Http/Controllers/IndexController.php on line 7

#0 vendor/laravel/framework/src/Illuminate/Routing/Controller.php(54): App\Http\Controllers\IndexController-&gt;index()
#1 vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php(45): Illuminate\Routing\Controller-&gt;callAction()
#2 vendor/laravel/framework/src/Illuminate/Routing/Route.php(254): Illuminate\Routing\ControllerDispatcher-&gt;dispatch()
#3 vendor/laravel/framework/src/Illuminate/Routing/Route.php(197): Illuminate\Routing\Route-&gt;runController()
#4 vendor/laravel/framework/src/Illuminate/Routing/Router.php(692): Illuminate\Routing\Route-&gt;run()
#5 vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(128): Illuminate\Routing\Router-&gt;Illuminate\Routing\{closure}()
#6 vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(41): Illuminate\Pipeline\Pipeline-&gt;Illuminate\Pipeline\{closure}()
#7 vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): Illuminate\Routing\Middleware\SubstituteBindings-&gt;handle()
#8 vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/VerifyCsrfToken.php(78): Illuminate\Pipeline\Pipeline-&gt;Illuminate\Pipeline\{closure}()
...


Time: 00:01.356, Memory: 28.00 MB


FAILURES!
Tests: 1, Assertions: 1, Failures: 1.

Process finished with exit code 1
```

</details>

## Reusing the test code is problematic

In most real applications you have multiple roles (eg `guest`, `user`, `admin`), guards, and policies. Very difficult to test all of them and usually you need create many `testRouteIsNotAvailableForGuest()`, `testRouteIsAvailableForAdminOnly()`, etc with a lot of boilerplate code. Also, often you cannot reuse that (boilerplate) code and must write it again and again. That is really annoying.

Resolving this problem is very simple. First, we need to create classes for the required Responses (actually package already provides few most [used responses](./src/Responses/Laravel) 🙄). Let's start with a simple JSON response:

```php
<?php declare(strict_types = 1);

namespace Tests\Responses;

use LastDragon_ru\LaraASP\Testing\Constraints\Response\ContentTypes\JsonContentType;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Response;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\Ok;

class JsonResponse extends Response {
    public function __construct() {
        parent::__construct(
            new Ok(),
            new JsonContentType(),
        );
    }
}
```

Next, lets add JSON Validation Error:

```php
<?php declare(strict_types = 1);

namespace Tests\Responses;

use LastDragon_ru\LaraASP\Testing\Constraints\Json\JsonMatchesSchema;
use LastDragon_ru\LaraASP\Testing\Constraints\Json\JsonSchema;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Body;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\ContentTypes\JsonContentType;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Response;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\UnprocessableEntity;
use LastDragon_ru\LaraASP\Testing\Utils\WithTestData;

class ValidationErrorResponse extends Response {
    use WithTestData;

    public function __construct() {
        parent::__construct(
            new UnprocessableEntity(),
            new JsonContentType(),
            new Body([
                new JsonMatchesSchema(new JsonSchema(self::getTestData(self::class)->file('.json'))),
            ]),
        );
    }
}
```

Finally, the test:

```php
<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Responses;
use Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(IndexController::class)]
class IndexControllerTest extends TestCase {
    public function testIndex() {
        $this->getJson('/')->assertThat(new ValidationErrorResponse());
    }

    public function testTest() {
        $this->getJson('/test')->assertThat(new ValidationErrorResponse());
    }
}
```

The same test with default assertions may look something like this:

```php
<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(IndexController::class)]
class IndexControllerTest extends TestCase {
    public function testIndex() {
        $this->getJson('/')
            ->assertStatus(422)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    public function testTest() {
        $this->getJson('/test')
            ->assertStatus(422)
            ->assertHeader('Content-Type', 'application/json')
            ->assertJsonStructure([
                'message',
                'errors',
            ]);;
    }
}
```

Feel the difference 😉

# PSR Response Testing

Internally package uses `PSR-7` so you can test any `Psr\Http\Message\ResponseInterface` 🤩

```php
<?php declare(strict_types = 1);

use LastDragon_ru\LaraASP\Testing\Assertions\ResponseAssertions;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\ContentTypes\JsonContentType;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Response;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\Ok;
use PHPUnit\Framework\TestCase;

class ResponseInterfaceTest extends TestCase {
    use ResponseAssertions;

    public function testResponse() {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = null;

        self::assertThatResponse($response, new Response(
            new Ok(),
            new JsonContentType(),
        ));
    }
}
```

# Data Providers on steroids

There is another cool feature that allows us to test a lot of use cases without code duplication - the [`CompositeDataProvider`](./src/Providers/CompositeDataProvider.php). It's merging multiple provides into one in the following way:

```text
Providers:
[
    ['expected a', 'value a'],
    ['expected final', 'value final'],
]
[
    ['expected b', 'value b'],
    ['expected c', 'value c'],
]
[
    ['expected d', 'value d'],
    ['expected e', 'value e'],
]

Merged:
[
    '0 / 0 / 0' => ['expected d', 'value a', 'value b', 'value d'],
    '0 / 0 / 1' => ['expected e', 'value a', 'value b', 'value e'],
    '0 / 1 / 0' => ['expected d', 'value a', 'value c', 'value d'],
    '0 / 1 / 1' => ['expected e', 'value a', 'value c', 'value e'],
    '1'         => ['expected final', 'value final'],
]
```

So we can organize our tests like this:

```php
<?php declare(strict_types = 1);

namespace Tests\Feature;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\Response;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\NotFound;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\Ok;
use LastDragon_ru\LaraASP\Testing\Constraints\Response\StatusCodes\Unauthorized;
use LastDragon_ru\LaraASP\Testing\Providers\ArrayDataProvider;
use LastDragon_ru\LaraASP\Testing\Providers\CompositeDataProvider;
use LastDragon_ru\LaraASP\Testing\Providers\DataProvider as DataProviderContract;
use LastDragon_ru\LaraASP\Testing\Providers\ExpectedFinal;
use LastDragon_ru\LaraASP\Testing\Responses\Laravel\Json\ValidationErrorResponse;
use PHPUnit\Framework\Attributes\DataProvider;use Tests\TestCase;

class ExampleTest extends TestCase {
    // <editor-fold desc="Prepare">
    // =========================================================================
    public function setUp(): void {
        parent::setUp();

        Route::get('/users/{user}', function (User $user) {
            return $user->email;
        })->middleware(['auth', SubstituteBindings::class]);

        Route::post('/users/{user}', function (Request $request, User $user) {
            $user->email = $request->validate([
                'email' => 'required|email',
            ]);

            return $user->email;
        })->middleware(['auth', SubstituteBindings::class]);
    }
    // </editor-fold>

    // <editor-fold desc="Tests">
    // =========================================================================
    #[DataProvider('dataProviderGet')]
    public function testGet(Response $expected, Closure $actingAs = null, Closure $user = null): void {
        $user = $user ? $user()->getKey() : 0;

        if ($actingAs) {
            $this->actingAs($actingAs());
        }

        $this->getJson("/users/{$user}")->assertThat($expected);
    }

    #[DataProvider('dataProviderUpdate')]
    public function testUpdate(Response $expected, Closure $actingAs = null, Closure $user = null, array $data = []) {
        $user = $user ? $user()->getKey() : 0;

        if ($actingAs) {
            $this->actingAs($actingAs());
        }

        $this->postJson("/users/{$user}", $data)->assertThat($expected);
    }

    // </editor-fold>

    // <editor-fold desc="DataProvider">
    // =========================================================================
    public static function dataProviderGet(): array {
        return (new CompositeDataProvider(
            self::getUserDataProvider(),
            self::getModelDataProvider(),
        ))->getData();
    }

    public static function dataProviderUpdate(): array {
        return (new CompositeDataProvider(
            self::getUserDataProvider(),
            self::getModelDataProvider(),
            new ArrayDataProvider([
                'no email'      => [
                    new ValidationErrorResponse(['email' => null]),
                    [],
                ],
                'invalid email' => [
                    new ValidationErrorResponse([
                        'email' => 'The email must be a valid email address.',
                    ]),
                    [
                        'email' => '123',
                    ],
                ],
                'valid email'   => [
                    new Ok(),
                    [
                        'email' => 'test@example.com',
                    ],
                ],
            ])
        ))->getData();
    }
    // </editor-fold>

    // <editor-fold desc="Shared">
    // =========================================================================
    protected static function getUserDataProvider(): DataProviderContract {
        return new ArrayDataProvider([
            'guest'         => [
                new ExpectedFinal(new Unauthorized()),
                null,
            ],
            'authenticated' => [
                new Ok(),
                function () {
                    return User::factory()->create();
                },
            ],
        ]);
    }

    protected static function getModelDataProvider(): DataProviderContract {
        return new ArrayDataProvider([
            'user not exists' => [
                new ExpectedFinal(new NotFound()),
                null,
            ],
            'user exists'     => [
                new Ok(),
                function () {
                    return User::factory()->create();
                },
            ],
        ]);
    }
    // </editor-fold>
}
```

Enjoy 😸

# Mocking properties (Mockery) 🧪

> [!IMPORTANT]
>
> Working prototype for [How to mock protected properties? (#1142)](https://github.com/mockery/mockery/issues/1142). Please note that implementation relies on Reflection and internal Mockery methods/properties.

[include:docblock]: ./src/Mockery/MockProperties.php ({"summary": false})
[//]: # (start: 998fe7ccccc11e3c54b93f9d6ea507c288be425a1dc4eca1cf5abe09d77c572e)
[//]: # (warning: Generated automatically. Do not edit.)

Limitations/Notes:

* Readonly properties should be uninitialized.
* Private properties aren't supported.
* Property value must be an object.
* Property must be used while test.
* Property can be mocked only once.
* Objects without methods will be marked as unused.

[//]: # (end: 998fe7ccccc11e3c54b93f9d6ea507c288be425a1dc4eca1cf5abe09d77c572e)

[include:example]: ./docs/Examples/MockProperties.php
[//]: # (start: 412cdd988d467ebb6083e17127a01aae689692590c8bf6273d2f3073cbf068cd)
[//]: # (warning: Generated automatically. Do not edit.)

```php
<?php declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
// phpcs:disable PSR1.Classes.ClassDeclaration

namespace LastDragon_ru\LaraASP\Testing\Docs\Examples\MockProperties;

use LastDragon_ru\LaraASP\Testing\Mockery\MockProperties;
use Mockery;

class A {
    public function __construct(
        protected readonly B $b,
    ) {
        // empty
    }

    public function a(): void {
        $this->b->b();
    }
}

class B {
    public function b(): void {
        echo 1;
    }
}

$mock = Mockery::mock(A::class, MockProperties::class);
$mock
    ->shouldUseProperty('b')
    ->value(
        Mockery::mock(B::class), // or just `new B()`.
    );

$mock->a();
```

[//]: # (end: 412cdd988d467ebb6083e17127a01aae689692590c8bf6273d2f3073cbf068cd)

# Custom Test Requirements

Unfortunately, PHPUnit doesn't allow to add/extend existing requirements and probably will not:

> I do not think that additional attributes for test requirements should be added. After all, the existing ones are only convenient syntax sugar. Simply check your custom requirements in a before-test method and call `markTestSkipped()` when they are not met.
> [©](https://github.com/sebastianbergmann/phpunit/issues/5674#issuecomment-1899839119) @sebastianbergmann

The extension listen several events and checks all attributes of test class/method which are implements [`Requirement`](./src/PhpUnit/Requirements/Requirement.php). If the requirements don't meet, the test will be marked as skipped. Please note that at least one "before" hook will be executed anyway (PHPUnit emits events after hook execution).

You need to [register extension](https://docs.phpunit.de/en/main/extending-phpunit.html#registering-an-extension-from-a-composer-package) first:

```xml
<extensions>
    <bootstrap class="LastDragon_ru\LaraASP\Testing\Requirements\PhpUnit\Extension"/>
</extensions>
```

And then

```php
<?php declare(strict_types = 1);

use LastDragon_ru\LaraASP\Testing\Requirements\Requirements\RequiresComposerPackage;
use PHPUnit\Framework\TestCase;

class SomePackageTest extends TestCase {
    #[RequiresComposerPackage('some/package')]
    public function testSomePackage(): void {
        // .....
    }
}
```

[include:file]: ../../docs/Shared/Upgrading.md
[//]: # (start: e9139abedb89f69284102c9112b548fd7add07cf196259916ea4f1c98977223b)
[//]: # (warning: Generated automatically. Do not edit.)

# Upgrading

Please follow [Upgrade Guide](UPGRADE.md).

[//]: # (end: e9139abedb89f69284102c9112b548fd7add07cf196259916ea4f1c98977223b)

[include:file]: ../../docs/Shared/Contributing.md
[//]: # (start: 057ec3a599c54447e95d6dd2e9f0f6a6621d9eb75446a5e5e471ba9b2f414b89)
[//]: # (warning: Generated automatically. Do not edit.)

# Contributing

This package is the part of Awesome Set of Packages for Laravel. Please use the [main repository](https://github.com/LastDragon-ru/lara-asp) to [report issues](https://github.com/LastDragon-ru/lara-asp/issues), send [pull requests](https://github.com/LastDragon-ru/lara-asp/pulls), or [ask questions](https://github.com/LastDragon-ru/lara-asp/discussions).

[//]: # (end: 057ec3a599c54447e95d6dd2e9f0f6a6621d9eb75446a5e5e471ba9b2f414b89)
