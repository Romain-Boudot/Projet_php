<?php

class Message {

    private $id;
    private $room_id;
    private $author;
    private $content;
    private $date;


    public function __construct($t_room, $t_id, $t_author, $t_content, $t_date) {

        $this->id       = $t_id;
        $this->room_id  = $t_room;
        $this->author   = $t_author;
        $this->content  = $t_content;
        $this->date     = $t_date;

    }


    public function print_this_message() {

        echo '<div class="container-fluid bg-light p-3 rounded">';
        echo '<span class="font-weight-light pr-2 text-little">' . $this->date . '</span>';
        echo '<span class="text-danger border border-bottom-0 border-top-0 border-left-0 border-secondary pr-2 mr-2">' . $this->author . '</span>';
        echo $this->content;
        echo '</div>';
        echo '<br>';

    }

};

?>