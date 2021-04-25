<?php

namespace Api\Services;

interface PlasmaDataService
{

    public function getTotalCount();

    public function getActiveCount();

    public function getAllActiveUsers($type = 'donor', $bloodGroups = [], $gender = null);

    public function getNearbyActiveUsers($cityId, $type = 'donor', $bloodGroups = [], $gender = null);
}