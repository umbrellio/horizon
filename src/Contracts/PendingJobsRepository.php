<?php

namespace Laravel\Horizon\Contracts;

interface PendingJobsRepository
{
    public function deleteByIds(array $ids): void;
}
