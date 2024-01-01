<?php

namespace Core;

class DebugBar {
    protected $messages = [];
    protected $timers = [];

    public function startTimer($name, $description = null) {
        $this->timers[$name] = [
            'start' => microtime(true),
            'description' => $description
        ];
    }

    public function stopTimer($name) {
        if (!isset($this->timers[$name])) {
            return;
        }

        $this->timers[$name]['end'] = microtime(true);
    }

    public function addMessage($message, $type = 'info') {
        $this->messages[] = [
            'type' => $type,
            'message' => $message,
            'time' => microtime(true)
        ];
    }

    public function render() {
        // Render the debug information as HTML
        $output = '<div id="debugbar">';
        foreach ($this->messages as $message) {
            $output .= "<div class='message {$message['type']}'>{$message['message']}</div>";
        }
        foreach ($this->timers as $name => $timer) {
            if (isset($timer['end'])) {
                $duration = round(($timer['end'] - $timer['start']) * 1000, 2);
                $output .= "<div class='timer'>Timer '{$name}' ({$timer['description']}): {$duration} ms</div>";
            }
        }
        $output .= '</div>';

        return $output;
    }
}
