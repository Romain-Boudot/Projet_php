<?php

    class Printer {


        const   bootstrap_css   =   '';
    
        const   bootstrap_js    =   '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>' .
                                    '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>' . 
                                    '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>';
    

        
    

        private function show_message($author, $content, $message_date) {
    
            echo '<div class="container-fluid bg-light p-3 rounded">';
            echo '<span class="font-weight-light pr-2 text-little">' . $message_date . '</span>';
            echo '<span class="text-danger border border-bottom-0 border-top-0 border-left-0 border-secondary pr-2 mr-2">' . $author . '</span>';
            echo $content;
            echo '</div>';
    
        }


        public function print_html($target) {

            switch ($target) {
                
                case 'bs_css':
                    echo $this::bootstrap_css;
                    break;
                case 'bs_js':
                    echo $this::bootstrap_js;
                    break;

            }
            
        }


        public function show_room($data) {
        
            if(sizeof($data) > 0) {
    
                if(!is_null($data[0]['name'])) {
                    
                    for($i = 0; $i < sizeof($data); $i++) {
                        
                        if($data[$i]['isadmin'] === "1") {
                            $this->get_admin_room($data[$i]['name'], $data[$i]['author'], " testeuuuuuuu", $data[$i]['rid']);
                        } else if($data[$i]['isvalidate'] === "0") {
                            $this->get_validation_room($data[$i]['name'], $data[$i]['author'], $data[$i]['rid']);
                        } else {
                            $this->get_basic_room($data[$i]['name'], $data[$i]['author'], " testeuuuuuuu", $data[$i]['rid']);
                        }
                        
                    }
                    
                }
    
            } else {
                    
                echo "<div class='jumbotron jumbotron-fluid border border-secondary rounded p-4'>";
                echo "<p class='d-inline'>Vous n'avez accès à aucune salle, mais vous pouvez en créer une !</p>";
                echo "</div>";
                
            }
    
        }

    }

?>