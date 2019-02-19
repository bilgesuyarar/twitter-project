<?php
class ShareModel extends Model{
	public function Index(){
        //select all posts to be showed by publish date
        $this->query('SELECT * FROM shares ORDER BY share_date DESC');
        $this->execute();
        $rows = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
	}
  
	public function add(){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if($post['submit']){
            //check if all fields are filled
			if($post['share_title'] == '' || $post['share_content'] == '' ){
				Messages::setMsg('Please Fill In All Fields', 'error');
				return;
			}
			//add to database
			$this->query('INSERT INTO shares (share_title, share_content, username, user_id) VALUES(:share_title, :share_content, :username, :user_id)');
			$this->bind(':share_title', $post['share_title']);
			$this->bind(':share_content', $post['share_content']);
			$this->bind(':user_id', $_SESSION['user_data']['user_id']);
			$this->bind(':username', $_SESSION['user_data']['username']);
			$this->execute();
			// check if its added to database
			if($this->dbh->lastInsertId()){
				header('Location: '.ROOT_URL.'shares');
			}
		}
		return;
	}
}