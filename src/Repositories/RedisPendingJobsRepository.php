<?php

namespace Laravel\Horizon\Repositories;

use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Illuminate\Redis\Connections\Connection;
use Laravel\Horizon\Contracts\PendingJobsRepository;

class RedisPendingJobsRepository implements PendingJobsRepository
{
    /**
     * The Redis connection instance.
     *
     * @var \Illuminate\Contracts\Redis\Factory
     */
    public $redis;

    public function __construct(RedisFactory $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Delete the jobs with the given IDs
     *
     * @param array $ids
     * @return void
     */
    public function deleteByIds(array $ids): void
    {
        $jobs = $this->connection()->pipeline(function ($pipe) use ($ids) {
            foreach ($ids as $id) {
                $pipe->hmget($id, ['id', 'status']);
            }
        });

        collect($jobs)
            ->filter(function (array $job) {
                return $job['status'] === 'pending';
            })->each(function (array $job) {
                $this->deleteJob($job['id']);
            });
    }

    /**
     * Delete the job with the given ID
     *
     * @param string $id
     * @return void
     */
    private function deleteJob($id): void
    {
        $this->connection()->pipeline(function ($pipe) use ($id) {

            $pipe->del($id);
            $pipe->zrem('pending_jobs', $id);
        });
    }

    /**
     * Get the Redis connection instance.
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    protected function connection(): Connection
    {
        return $this->redis->connection('horizon');
    }
}
