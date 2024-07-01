<?php
interface Observer {
    public function update($data);
}

class Subject {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function notify($data) {
        foreach ($this->observers as $observer) {
            $observer->update($data);
        }
    }
}
?>
