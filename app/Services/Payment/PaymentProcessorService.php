<?php

namespace App\Services\Payment;

use App\Interfaces\Payment\PaymentProcessInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentProcessorService extends BaseService
{
    protected $paymentGateway;

    public function __construct(PaymentProcessInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function handle()
    {
        try {
            $this->paymentGateway->payment($this->data->amount);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
