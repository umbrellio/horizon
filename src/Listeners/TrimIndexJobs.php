<?php

declare(strict_types=1);

namespace Laravel\Horizon\Listeners;

use Carbon\CarbonImmutable;
use Laravel\Horizon\Contracts\JobRepository;
use Laravel\Horizon\Events\MasterSupervisorLooped;

class TrimIndexJobs
{
    /**
     * The last time the recent jobs were trimmed.
     *
     * @var \Carbon\CarbonImmutable
     */
    public $lastTrimmed;

    /**
     * How many minutes to wait in between each trim.
     *
     * @var int
     */
    public $frequency = 5040;

    /**
     * Handle the event.
     *
     * @param \Laravel\Horizon\Events\MasterSupervisorLooped $event
     * @return void
     */
    public function handle(MasterSupervisorLooped $event)
    {
        collect([
            config('horizon.trim.pending'),
            config('horizon.trim.completed'),
            config('horizon.trim.failed'),
        ])->each(function (int $minutes, string $type) {
            $this->runTrim($minutes, $type);
        });
    }

    public function runTrim(int $minutes, string $type): void
    {
        if (!isset($this->lastTrimmed)) {
            $this->frequency = max(1, intdiv($minutes, 12));

            $this->lastTrimmed = CarbonImmutable::now()->subMinutes($this->frequency + 1);
        }

        if ($this->lastTrimmed->lte(CarbonImmutable::now()->subMinutes($this->frequency))) {
            app(JobRepository::class)->trimIndexJobs($type);

            $this->lastTrimmed = CarbonImmutable::now();
        }
    }

}
