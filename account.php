<?php
abstract class Account {
    protected $id;
    protected $accountNumber;
    protected $userId;
    private $balance;
    const STATUS_ACTIVE = 'active';

    public function __construct($accountNumber, $userId, $balance = 0.00) {
        $this->accountNumber = $accountNumber;
        $this->userId = $userId;
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function deposit($amount) {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Deposit amount must be positive.");
        }
        $this->balance += $amount;
        return $this->balance;
    }

    // Every subclass MUST define its own withdrawal rules (polymorphism)
    abstract public function withdraw($amount);

    // Every subclass MUST define how it calculates interest (polymorphism)
    abstract public function applyInterest();
}
?>
