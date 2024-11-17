<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['installment_value'] = round($data['amount'] / $data['installments'], 2);
        $data['amount_payable'] = $data['amount'] + ($data['amount'] * $data['interest_rate'] / 100);
        $data['status'] = 'pending'; // or approved depending on your business logic
        $data['created_by'] = auth()->id();

        return $data;
    }
}
