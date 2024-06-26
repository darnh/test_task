<?php

namespace App\Services\Tender;

use App\Components\TenderApi;
use Illuminate\Support\Facades\Log;

class TenderService
{
    public function __construct
    (
        protected TenderApi $tenderApi
    )
    {
    }

    public function all(): array
    {
        try {

            $response = $this->tenderApi->client->request('GET', 'tenders?descending=1');

            $tenders = json_decode($response->getBody()->getContents(), true);

            if((isset($tenders['error']) && $tenders['error']) || empty($tenders['data'])) {

                Log::error('Failed to fetch tenders.', [
                    'response' => $tenders ?? '',
                ]);

                return [
                    'error' => true,
                    'message' => 'Failed to fetch tenders',
                    'response' => $tenders ?? '',
                ];
            }

            return $tenders['data'];

        } catch (\Exception $e) {

            Log::error('Error while fetching tenders: ' . $e->getMessage(), [
                'response' => $response ?? '',
            ]);

            return [
                'error' => true,
                'message' =>  $e->getMessage(),
                'response' => $response ?? '',
            ];
        }
    }

    public function getTenderById(string $tenderId): array
    {
        try {

            $response = $this->tenderApi->client->request('GET', 'tenders/' . $tenderId);

            $tender = json_decode($response->getBody()->getContents(), true);

            if((isset($tender['error']) && $tender['error']) || empty($tender['data'])) {

                Log::error('Failed to fetch tender by id.', [
                    'response' => $tender ?? '',
                ]);

                return [
                    'error' => true,
                    'message' => 'Failed to fetch tender by id',
                    'response' => $tender ?? '',
                ];
            }

            return $tender['data'];

        } catch (\Exception $e) {

            Log::error('Error while fetching tender: ' . $e->getMessage(), [
                'response' => $response ?? '',
            ]);

            return [
                'error' => true,
                'message' =>  $e->getMessage(),
                'response' => $response ?? '',
            ];
        }
    }
}
