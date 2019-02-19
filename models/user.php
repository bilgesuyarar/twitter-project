<?php
class UserModel extends Model{
	public function register(){
		
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $password = password_hash($post['user_password'] , PASSWORD_BCRYPT, array('cost' => 10));
        
        //check if all the fields are filled correctly
		if($post['submit']){
			if($post['username'] == '' || $post['user_email'] == '' || $post['user_password'] == ''){
				Messages::setMsg('Please Fill In All Fields', 'error');
				return;
			}
            if(strlen($post['username']) < 6){
                Messages::setMsg('Username must contain at least 6 characters', 'error');
                return;
            }
            if(strlen($post['user_password']) < 6){
                Messages::setMsg('Password must contain at least 6 characters', 'error');
                return;
            }
            //add user to database
			$this->query('INSERT INTO users (username, user_email, user_password) VALUES(:username, :user_email, :user_password)');
			$this->bind(':username', $post['username']);
			$this->bind(':user_email', $post['user_email']);
			$this->bind(':user_password', $password);
			$this->execute();
			if($this->dbh->lastInsertId()){
				header('Location: '.ROOT_URL.'users/login');
			}
		}
		return;
	}
    public function login(){
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password = password_hash($post['user_password'] , PASSWORD_BCRYPT, array('cost' => 10));

        if($post['submit']){
            //get user's password from database
            $this->query('SELECT user_password FROM users WHERE username = :username');
            $this->bind(':username', $post['username']);
            $this->execute();
            $user_password = $this->stmt->fetchColumn();
            
            //check if passwords match
            if(password_verify($post['user_password'], $user_password) ){
                
                //fetch user info
                $this->query('SELECT * FROM users WHERE username = ?');
                $this->bind(1, $post['username']);
                $this->execute();
                $row = $this->stmt->fetch(PDO::FETCH_ASSOC);


                    $_SESSION['is_logged_in'] = true;

                    $_SESSION['user_data'] = array (
                        'user_id'    => $row['user_id'],
                        'username'   => $row['username'],
                        'user_email' => $row['user_email']
                    );
                    header("Location: " . ROOT_URL . "shares");
                    Messages::setMsg('Login Successful' , 'success');
            } else {
                Messages::setMsg('Login Failed', 'error');
            }
        }
    }
    
    
    

    

	
}