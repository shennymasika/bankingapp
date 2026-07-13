<?php
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
