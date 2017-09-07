<?php

/*
 * graphmob-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

class GraphmobEnrich {
  public function __construct($parent) {
    $this->parent = $parent;
  }

  public function person($query) {
    return $this->parent->_get("/enrich/person", $query);
  }

  public function company($query) {
    return $this->parent->_get("/enrich/company", $query);
  }

  public function network($query) {
    return $this->parent->_get("/enrich/network", $query);
  }
}

?>
