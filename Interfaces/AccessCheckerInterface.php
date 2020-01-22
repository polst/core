<?php

namespace BasicApp\Interfaces;

interface AccessCheckerInterface
{

    public function can($permission) : bool;

}