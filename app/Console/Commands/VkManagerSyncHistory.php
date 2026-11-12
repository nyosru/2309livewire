<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\VkManagerSnapshotSyncService;
use Illuminate\Console\Command;
use RuntimeException;

class VkManagerSyncHistory extends Command
{
    protected $signature = 'vk-manager:sync-history {user_id : Laravel user ID for the VK account owner}';

    protected $description = 'Import complete current friends, followers, and outgoing requests into VK manager history';

    public function handle(VkManagerSnapshotSyncService $sync): int
    {
        $owner = User::query()->find($this->argument('user_id'));
        if (! $owner) {
            $this->error('The selected Laravel user was not found.');

            return self::FAILURE;
        }

        try {
            $result = $sync->sync($owner, 'vk_api_full_snapshot');
        } catch (RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info(sprintf(
            'Snapshot recorded for VK ID %s: %d friends, %d followers, %d outgoing requests, %d status changes, %d old memberships closed.',
            $owner->vk_id,
            $result['friends'],
            $result['followers'],
            $result['outgoing_requests'],
            $result['changed'],
            $result['staled'],
        ));

        return self::SUCCESS;
    }
}
