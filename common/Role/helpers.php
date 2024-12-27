<?php

use Common\Role\Role;

if (! function_exists('role')) {
    /**
     * Creates a new instance of the Role class.
     */
    function role(string $name): Role
    {
        return new Role($name);
    }
}
