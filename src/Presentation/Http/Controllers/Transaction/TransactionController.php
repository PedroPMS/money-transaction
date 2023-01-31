<?php

namespace MoneyTransaction\Presentation\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use MoneyTransaction\Domain\Services\Transaction\CreateTransaction;
use MoneyTransaction\Presentation\Http\Requests\Transaction\CreateTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(private readonly CreateTransaction $createTransaction)
    {
    }

    /**
     * Create transaction
     *
     * Create transaction
     *
     * @response 204
     *
     * @group Transaction
     */
    public function store(CreateTransactionRequest $request): Response
    {
        $this->createTransaction->dispatchTransactionCreate(
            $request->input('payer_id'),
            $request->input('payee_id'),
            $request->input('value')
        );

        return response()->noContent();
    }
}
