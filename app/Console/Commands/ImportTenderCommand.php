<?php

namespace App\Console\Commands;

use App\Services\Import\Tender\ImportTenderService;
use Illuminate\Console\Command;

class ImportTenderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tenders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing latest tenders to database.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $service = resolve(ImportTenderService::class);
        $service->import();
    }
}
