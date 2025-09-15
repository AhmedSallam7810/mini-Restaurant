<?php

namespace App\Console\Commands;

use App\Services\MenuService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResetDailyMenuAvailability extends Command
{

    protected $signature = 'menu:reset-daily-availability';


    protected $description = 'Reset daily availability';

    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        parent::__construct();
        $this->menuService = $menuService;
    }


    public function handle(): int
    {

        try {
            $this->menuService->resetDailyAvailability();

            return Command::SUCCESS;
        } catch (\Exception $e) {

            return Command::FAILURE;
        }
    }
}
