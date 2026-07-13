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

class SavingsAccount extends Account {
    const MIN_BALANCE = 500.00;
    const INTEREST_RATE = 0.05; // 5% per period

    public function withdraw($amount) {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Withdrawal amount must be positive.");
        }
        if ($this->getBalance() - $amount < self::MIN_BALANCE) {
            throw new Exception("Withdrawal denied: minimum savings balance is " . self::MIN_BALANCE);
        }
        $this->balance = $this->getBalance() - $amount;
        return $this->balance;
    }

    public function applyInterest() {
        $interest = $this->getBalance() * self::INTEREST_RATE;
        $this->deposit($interest);
        return $interest;
    }
}

class CurrentAccount extends Account {
    const OVERDRAFT_LIMIT = 10000.00;

    public function withdraw($amount) {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Withdrawal amount must be positive.");
        }
        if ($this->getBalance() - $amount < -self::OVERDRAFT_LIMIT) {
            throw new Exception("Withdrawal denied: overdraft limit exceeded.");
        }
        $this->balance = $this->getBalance() - $amount;
        return $this->balance;
    }

    public function applyInterest() {
        return 0; // current accounts earn no interest
    }
}
?>
