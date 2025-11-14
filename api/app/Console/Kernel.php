<?php

use App\Console\Commands\UserCrudCommand;

class Kernel
{
    protected $commands = [
        UserCrudCommand::class,
    ];
}
