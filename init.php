<?php

$iran_area = new IRAN('mr_iran');

if (! $iran_area->num()) {
    $iran_area->insert_old_data();
}
