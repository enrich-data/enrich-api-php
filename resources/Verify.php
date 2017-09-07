<?php

/*
 * graphmob-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

class GraphmobVerify {
  private function __construct($parent) {
    $this->parent = $parent;
  }

  public function validateEmail($query) {
    return $this->parent->_get("/verify/validate/email", $query);
  }

  public function formatEmail($query) {
    return $this->parent->_get("/verify/format/email", $query);
  }
}

?>
