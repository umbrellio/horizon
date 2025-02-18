<?php

namespace Laravel\Horizon;

use Laravel\Horizon\Repositories\RedisIndexedJobsRepository;
use Laravel\Horizon\Repositories\RedisPendingJobsRepository;
use Laravel\Horizon\Repositories\RedisStatisticsRepository;

trait ServiceBindings
{
    /**
     * All of the service bindings for Horizon.
     *
     * @var array
     */
    public $serviceBindings = [
        // General services...
        AutoScaler::class,
        Contracts\HorizonCommandQueue::class => RedisHorizonCommandQueue::class,
        Listeners\TrimRecentJobs::class,
        Listeners\TrimFailedJobs::class,
        Listeners\TrimMonitoredJobs::class,
        Listeners\TrimIndexJobs::class,
        Lock::class,
        Stopwatch::class,

        // Repository services...
        Contracts\JobRepository::class => Repositories\RedisJobRepository::class,
        Contracts\MasterSupervisorRepository::class => Repositories\RedisMasterSupervisorRepository::class,
        Contracts\MetricsRepository::class => Repositories\RedisMetricsRepository::class,
        Contracts\ProcessRepository::class => Repositories\RedisProcessRepository::class,
        Contracts\SupervisorRepository::class => Repositories\RedisSupervisorRepository::class,
        Contracts\TagRepository::class => Repositories\RedisTagRepository::class,
        Contracts\WorkloadRepository::class => Repositories\RedisWorkloadRepository::class,
        Contracts\IndexedJobsRepository::class => RedisIndexedJobsRepository::class,
        Contracts\StatisticsRepository::class => RedisStatisticsRepository::class,
        Contracts\PendingJobsRepository::class => RedisPendingJobsRepository::class,
    ];
}
