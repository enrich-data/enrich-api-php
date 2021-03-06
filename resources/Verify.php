<?php

/*
 * enrich-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

class VerifyResource {
  public function __construct($parent) {
    $this->parent = $parent;
  }

  public function validateEmail($query) {
    return $this->parent->_get("/verify/validate/email", $query);
  }
}

?>
