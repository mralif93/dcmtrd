<?php

namespace App\Imports;

use App\Imports\RatingsImport;
use App\Imports\IssuanceImport;
use App\Imports\LatestTradingImport;
use App\Imports\AdditionalInfoImport;
use App\Imports\SecurityInformationImport;
use App\Imports\ProfitPaymentDetailsImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BondImport implements WithMultipleSheets
{
    protected $securityImport;

    public function __construct()
    {
        $this->securityImport = new SecurityInformationImport();
    }

    public function sheets(): array
    {
        return [
            0 => $this->securityImport, 
            1 => new LatestTradingImport($this->securityImport), 
            2 => new RatingsImport($this->securityImport), 
            3 => new ProfitPaymentDetailsImport($this->securityImport), 
            4 => new IssuanceImport($this->securityImport), 
            5 => new AdditionalInfoImport($this->securityImport), 
        ];
    }
}