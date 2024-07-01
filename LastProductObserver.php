<?php
class LastProductObserver implements Observer {
    public function update($data) {
        echo "Last product added: $data";
    }
}
?>
