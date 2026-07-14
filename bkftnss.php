<?php
function transferFunds(PDO $conn, Account $from, Account $to, $amount, $description = 'Fund transfer') {
    $conn->beginTransaction();
    try {
        $from->withdraw($amount);
        $to->deposit($amount);

        $txn = new Transaction($from->getId(), Transaction::TRANSFER, $amount, $description, $to->getId());
        $reference = $txn->save($conn);

        $conn->commit();
        return $reference;
    } catch (Exception $e) {
        $conn->rollBack();
        throw $e;
    }
}
?>
