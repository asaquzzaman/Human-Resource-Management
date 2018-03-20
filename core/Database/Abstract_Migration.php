<?php

namespace HRM\Core\Database;

use HRM\Core\Database\Migration;

abstract class Abstract_Migration implements Migration {
    public function run() {
        $this->schema();
    }

    abstract public function schema();
}