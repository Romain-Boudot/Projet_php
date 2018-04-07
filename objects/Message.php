<?php

class Message {

    private $id;
    private $room;
    private $author;
    private $author_id;
    private $content;
    private $date;

    public function __construct($t_room, $t_id, $t_author, $t_content, $t_date, $t_a_id) {

        $this->id       = $t_id;
        $this->room     = $t_room;
        $this->author   = $t_author;
        $this->content  = $t_content;
        $this->date     = $t_date;
        $this->author_id = $t_a_id;

    }


    public function print_this_message($output_type) {


        $ismine = 0;

        if ($this->author_id == $_SESSION['user']['id']) {
            $ismine = 1;
        }

        if ($output_type == "js") echo "[". $ismine . ",\"";
        echo "<div id='" . $this->id . "' class='container-fluid bg-light p-3 rounded'>";
        echo "<span class='font-weight-light pr-2 text-little'>" . $this->date . "</span>";
        echo "<span class='text-danger border border-bottom-0 border-top-0 border-left-0 border-secondary pr-2 mr-2'>" . $this->author . "</span>";
        echo "<span onblur='on_blur(this)' onkeydown='on_key_press(event, this)' class='editable' id='contentid" . $this->id . "'>" . $this->content . "</span>";

        if ($ismine == 1 || $this->room->get_var('isadmin') == 1) {

            echo "<div onclick='del(\"" . $this->id . "\")' role='button' class='close clickable' aria-label='Close'>";
            echo "<span aria-hidden='true'>&times;</span>";
            echo "</div>";  

        }

        if ($ismine == 1) {

            echo "<div onclick='edit(\"" . $this->id . "\")' role='button' class='close clickable' aria-label='Close'>";
            echo "<span aria-hidden='true' style='font-size:80%;' class='mr-2 fas fa-edit span_text'></span>";
            echo "</div>";  

        }

        echo "</div>";
        echo "<br>";
        if ($output_type == "js") echo "\"]";

    }

    public function delete() {

        if ($this->author_id == $this->room->get_var('user')->get_var('id') || $this->room->get_var('isadmin') == 1) {

            $db = Data_base::db_connexion();

            $statment = $db->prepare("DELETE FROM message WHERE id = :msgid");

            $statment->execute(array(":msgid" => $this->id));

        }

    }
  
};

?>