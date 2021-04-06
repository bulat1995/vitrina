<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\Models\User;
use App\Models\Role;

use Tests\Traits\UserTrait;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use UserTrait;

}
