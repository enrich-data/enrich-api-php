<?php

/*
 * enrich-api-php
 *
 * Copyright 2017, Valerian Saliou
 * Author: Valerian Saliou <valerian@valeriansaliou.name>
 */

require __DIR__."/../vendor/autoload.php";

$client = new Enrich();

$client->authenticate(
  "ui_a311da78-6b89-459c-8028-b331efab20d5",
  "sk_f293d44f-675d-4cb1-9c78-52b8a9af0df2"
);

$data = $client->search->lookupCompanies([
  "legal_name" => "Crisp IM, Inc.",
  "founded" => 2015
], 1);

var_dump($data);

?>
