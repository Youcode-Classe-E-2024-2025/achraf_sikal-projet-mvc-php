<?php
/**
 * admin controller
 */
class dashboard extends Controller
{
    public function index(): void 
    {
        $data['title'] = "Dashboard";

        if (!auth::logged_in()) {
            message("please log in");
            redirect("login");
        }
        $this->view('dashboard',$data);
    }
    public function courses($action= null, $id= null): void
    {
        $user_id = Auth::getId();
		$course = new Course();
		$category = new Category();
        if (!auth::logged_in()) {
            message("please log in");
            redirect("login");
        }
        $user_id = auth::getuser_Id();
        $course = new course();
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        if ($action == "add") {
            $category = new category();

            $data['categories'] = $category->findAll("asc");

            if ($_SERVER["REQUEST_METHOD"]== "POST")
            {
                if ($course->validate($_POST)) {
                    $_POST["user_id"] = $user_id;

                    $course->insert($_POST);

                    $row = $course->first(['user_id'=>$user_id]);
                    message("Your course was successfuly created");
                    if ($row) {
                        redirect('admin/courses/');
                    }else {
                        redirect('admin/courses');
                    }
                    
                }
                $data['errors'] = $course->errors;
            }
        }elseif ($action == "delete") {
            $id = trim((string) $_GET['url'],'admin/courses/delete/');
            $course->delete($id);
            redirect('admin/courses');
        }elseif ($action == "edit") 
        {
            if ($_SERVER["REQUEST_METHOD"]== "POST")
            {
                $id = trim((string) $_GET['url'],'admin/courses/edit/');
                ///////////////////////////////////////////// cover image upload star /////////////////////////////////////
                $target_dir = "uploads/courses/img/";
                if(!$_POST["image_link"]==null){
                    $target_file = "../".$target_dir . basename((string) $_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "<script>alert('File is not an image.')</script>";
                        $uploadOk = 0;
                    }

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "<script>alert('Sorry, file already exists.')</script>";
                        $uploadOk = 0;
                    }

                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 8000000) {
                        echo "<script>alert('Sorry, your file is too large the file must not be larger than 8 Mb.')</script>";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg" && $imageFileType !== "gif" ) {
                        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
                        // if everything is ok, try to upload file
                    } elseif (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars( basename( (string) $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                        $_POST['course_image'] = trim(ROOT,'public').$target_dir.$_FILES["fileToUpload"]["name"];
                    } else {
                        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                    }
                }
                ////////////////////////////////////////// cover image upload end /////////////////////////////////////////


                ///////////////////////////////////////////// video upload star /////////////////////////////////////
                $target_dir = "uploads/courses/video/";
                if(isset($_FILES["videoToUpload"])){
                    $target_file = "../".$target_dir . basename((string) $_FILES["videoToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    
                    if ($_FILES["videoToUpload"]["size"] > 300000000) {
                        echo "<script>alert('Sorry, your file is too large the file must not be larger than 300 Mb.')</script>";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($imageFileType !== "mp4" && $imageFileType !== "wav" && $imageFileType !== "av1" && $imageFileType !== "gif" ) {
                        echo "<script>alert('Sorry, only MP4, wav, av1 & GIF files are allowed.')</script>";
                        $uploadOk = 0;
                    }

                    if (file_exists($target_file)) {
                        echo "<script>alert('Sorry, file already exists.')</script>";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
                        // if everything is ok, try to upload file
                    } elseif (move_uploaded_file($_FILES["videoToUpload"]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars( basename( (string) $_FILES["videoToUpload"]["name"])). " has been uploaded.";
                        $_POST['content'] = trim(ROOT,'public').$target_dir.$_FILES["videoToUpload"]["name"];
                    } else {
                        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                    }
                }
                ////////////////////////////////////////// video upload end /////////////////////////////////////////
                $course->update($id, $_POST,'course_id');
                redirect('admin/courses/edit/'.$id);
            }
            //////////////// get courses info ////////////////
            $data['categories'] = $category->findAll("asc");
            $data['row'] = $course->first(['user_id'=>$user_id, 'course_id'=>$id]);
        }
        else {
            //////////////// courses view ////////////////
            $data['rows'] = $course->where(['user_id'=>$user_id]);
        }

        $this->view('admin/courses',$data);
    }
    public function profile($id= null): void 
    {
        $id ??= auth::getuser_Id();
        $user = new user();
        $data['row'] = $row = $user->first(['user_id'=>$id]);
        if (!auth::logged_in()) {
            message("please log in");
            redirect("login");
        }
        if ($_SERVER["REQUEST_METHOD"]== "POST" && $row) {
            $user->update($id, $_POST);
            redirect("admin/profile/".$id);
        }
        
        $data['title'] = "Profile";
        $this->view('admin/profile',$data);
    }
}