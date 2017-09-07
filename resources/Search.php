<?php

/*
 * graphmob-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

class GraphmobSearch {
  private function __construct($parent) {
    $this->parent = $parent;
  }

  public function lookupCompanies($query, $page_number = 1) {
    return $this->parent->_get(
      "/search/lookup/companies/".$page_number, $query
    );
  }

  public function lookupEmails($query, $page_number = 1) {
    return $this->parent->_get(
      "/search/lookup/emails/".$page_number, $query
    );
  }

  public function suggestCompanies($query, $page_number = 1) {
    return $this->parent->_get(
      "/search/suggest/companies/".$page_number, $query
    );
  }
}

?>
