<?php

namespace App\Console\Commands;

use App\Services\EventService;
use Illuminate\Console\Command;

class DeleteOverOneYearEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:delete-over-one-year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete events that are over one year';

    /** @var EventService */
    private $eventService;

    /**
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        // 調用父類的構造函數
        parent::__construct();

        // 設置指令的屬性
        $this->eventService = $eventService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->eventService->deleteOverOneYearEvents();

        $this->info('成功刪除超過一年的活動資料');

        return Command::SUCCESS;
    }
}
