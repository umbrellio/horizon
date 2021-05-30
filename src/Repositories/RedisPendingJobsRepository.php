<?php

namespace Laravel\Horizon\Repositories;

use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Illuminate\Redis\Connections\Connection;
use Laravel\Horizon\Contracts\PendingJobsRepository;

class RedisPendingJobsRepository implements PendingJobsRepository
{
    /**
     * @var RedisFactory
     */
    public $redis;

    public function __construct(RedisFactory $redis)
    {
        $this->redis = $redis;
    }

    public function deleteByIds(array $ids): void
    {
        $jobs = $this->connection()->pipeline(function ($pipe) use ($ids) {
            foreach ($ids as $id) {
                $pipe->hmget($id, ['id', 'name', 'status']);
            }
        });

        collect($jobs)
            ->filter(function (array $job) {
                return $job['status'] === 'pending';
            })->each(function (array $job) {
                $this->deleteJob($job['id'], $job['name']);
            });
    }

    private function deleteJob(string $id, string $name): void
    {
        $pendingIndexKey = 'pending_jobs:' . config('horizon.prefix_index') . $name;

        $this->connection()->pipeline(function ($pipe) use ($id, $pendingIndexKey) {

            $pipe->del($id);
            $pipe->zrem('pending_jobs', $id);
            $pipe->zrem($pendingIndexKey, $id);
        });
    }

    protected function connection(): Connection
    {
        return $this->redis->connection('horizon');
    }
}
