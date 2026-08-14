<?php

class Transaction
{
    const DEPOSIT = 'Deposit';
    const WITHDRAWAL = 'Withdrawal';
    const TRANSFER = 'Transfer';

    private $accountId;
    private $toAccountId;
    private $type;
    private $amount;
    private $description;

    public function __construct(
        $accountId,
        $type,
        $amount,
        $description = '',
        $toAccountId = null
    ) {
        $this->accountId = $accountId;
        $this->toAccountId = $toAccountId;
        $this->type = $type;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function save(PDO $pdo)
    {
        $reference = strtoupper(uniqid('TXN'));

        $stmt = $pdo->prepare("
            INSERT INTO `transaction`
            (
                account_id,
                to_account_id,
                transaction_type,
                amount,
                description,
                reference
            )
            VALUES
            (
                :account_id,
                :to_account_id,
                :transaction_type,
                :amount,
                :description,
                :reference
            )
        ");

        $stmt->execute([
            ':account_id' => $this->accountId,
            ':to_account_id' => $this->toAccountId,
            ':transaction_type' => $this->type,
            ':amount' => $this->amount,
            ':description' => $this->description,
            ':reference' => $reference
        ]);

        return $reference;
    }
}
?>