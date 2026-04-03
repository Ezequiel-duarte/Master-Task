    <?php
    use App\Models\User;
    use App\Validation;
    class UserController {

        private  $userModel;
        public function __construct($db){
            $this->userModel = new User($db);
            $this->userValidator = new UserValidator();
        }

        public function index($body){ 
           $result = $this->userModel->getUsers();
           if (!$result) {
                throw new \Exception("Error geting users", 404);
            }
            return $result;
        }

        public function show($body,$id) {
             $this->userValidator->validateId($id); 
            $user = $this->userModel->getUserById($id);
            if (!$user) {
                throw new \Exception("User not found", 500);
            }
            return $user;
        }

        public function store($body){
            $validatedData = $this->userValidator->validateCreate($body);
            $id = $this->userModel->createUser($validatedData);
            if (!$id) {
                throw new \Exception("Error creating user", 500);
            }
            return [
                'message' => 'User created successfully',
                'id' => $id
            ];
        }

        public function destroy($body, $id){
            $this->userValidator->validateId($id);
            $result = $this->userModel->deleteUser($id);
            if (!$result) {
                throw new \Exception("Error deleting user", 500);
            }
            return ['message' => 'User deleted'];
        }

        public function search($body){
           $filtered = $this->userValidator->bValidate($body);
            if (isset($filtered['username'])) {
                return $this->userModel->getUserByName($filtered['username']);
            }
            if (isset($filtered['email'])) {
                return $this->userModel->getUserByEmail($filtered['email']);
            }
            throw new \Exception("Email or name needed", 400);
        }

    }          