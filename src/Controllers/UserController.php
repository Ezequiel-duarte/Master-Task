    <?php
    use App\Models\User;

    class UserController {

        private  $userModel;
        public function __construct($db){
            $this->userModel = new User($db);
        }

        public function index($body){ 
            return getUsers();
        }

        public function show($body,$id) {
        
        }

        public function store($body){

        }

        public function destroy($body, $id){

        }

        public function search($body){

        }

        private function validateAtt(){

        }



    }