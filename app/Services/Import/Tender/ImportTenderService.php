<?php

namespace App\Services\Import\Tender;

use App\Models\Tender;
use App\Services\Tender\TenderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportTenderService
{
    public function __construct
    (
        protected TenderService $tenderService
    )
    {

    }

    protected int $tenders = 10;

    public function import(): void
    {
        try {
            $tenders = $this->tenderService->all();

            if (isset($tenders['error']) && $tenders['error']) {
                $this->info('Failed to fetch tenders data. Check the logs for more details.');
                return;
            }

            $latestTenders = array_slice($tenders, 0, $this->tenders);

            $isSaved = $this->saveTenders($latestTenders);

            if(!$isSaved) {
                $this->info('Failed to save tenders. Check the logs for more details.');
                return;
            }

            $this->info('Tenders imported successfully.');

        } catch (\Exception $e) {

            Log::error('Error importing tenders: ' . $e->getMessage());

            $this->info('Failed to import tenders. Check the logs for more details.');
        }
    }
    protected function saveTenders(array $tenders): bool
    {
        DB::beginTransaction();

        try {

            foreach ($tenders as $tender) {


                $tenderData = $this->tenderService->getTenderById($tender['id']);

                if(isset($tenderData['error']) && $tenderData['error']) {
                    throw new \Exception('Failed to fetch tender data for tender with id: ' . $tender['id']);
                }

                $isCreated = Tender::create([
                    'tender_id' => $tenderData['id'],
                    'description' => $tenderData['description'] ?? '',
                    'amount' => $tenderData['value']['amount'],
                    'date_modified' => $tenderData['dateModified'],
                ]);

                if(!$isCreated) {
                    throw new \Exception('Failed to save tender with id: ' . $tender['id'] .
                        '. Tender data for saving: ' . json_encode($tenderData));
                }
            }

            DB::commit();

            return true;

        } catch (\Exception $e) {

            Log::error('Error while saving tenders: ' . $e->getMessage());

            DB::rollBack();

            return false;
        }
    }

    protected function info(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
