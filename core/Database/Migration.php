<?php

namespace HRM\Core\Database;

interface Migration {
    public function schema();
    public function run();
}