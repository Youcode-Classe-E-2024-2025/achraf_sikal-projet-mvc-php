<?php
/**
 * admin controller
 */
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

class dashboard extends Controller
{
    public function index()
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader, [
            'debug' => true
        ]);
        $twigData = ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public'];
        if (isset($_SESSION['USER_DATA'])) {
            $twigData['USER_DATA'] = $_SESSION['USER_DATA'];
        }
        $twig->addExtension(new DebugExtension());
        echo $twig->render('nav.html.twig', $twigData);
        $data['title'] = "Dashboard";
        if (!auth::logged_in()) {
            message("please log in");
            redirect("login");
        }
        $this->view('dashboard',$data);
        return $twig;
    }
    public function article($action= null, $id= null): void
    {
        $twigData = ['ROOT'=>ROOT, 'style'=>'http://localhost/sikal_achraf-youdemy/public'];
        if (isset($_SESSION['USER_DATA'])) {
            $twigData['USER_DATA'] = $_SESSION['USER_DATA'];
        }
        echo $this->index()->render('article.html.twig', $twigData);
        $user_id = Auth::getId();
		$article = new article();
        if (!auth::logged_in()) {
            message("please log in");
            redirect("login");
        }
        $user_id = auth::getid();
        $article = new article();
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        if ($action == "add") {

            if ($_SERVER["REQUEST_METHOD"]== "POST")
            {
                if ($article->validate($_POST)) {
                    $_POST["user_id"] = $user_id;

                    $article->insert($_POST);

                    $row = $article->first(['user_id'=>$user_id]);
                    message("Your article was successfuly created");
                    if ($row) {
                        redirect('admin/article/');
                    }else {
                        redirect('admin/article');
                    }
                    
                }
                $data['errors'] = $article->errors;
            }
        }elseif ($action == "delete") {
            $id = trim((string) $_GET['url'],'admin/article/delete/');
            $article->delete($id);
            redirect('admin/article');
        }elseif ($action == "edit") 
        {
            if ($_SERVER["REQUEST_METHOD"]== "POST")
            {
                $id = trim((string) $_GET['url'],'admin/article/edit/');
                ///////////////////////////////////////////// cover image upload star /////////////////////////////////////
                $target_dir = "uploads/article/img/";
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
                        $_POST['article_image'] = trim(ROOT,'public').$target_dir.$_FILES["fileToUpload"]["name"];
                    } else {
                        echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                    }
                }
                ////////////////////////////////////////// cover image upload end /////////////////////////////////////////


                ///////////////////////////////////////////// video upload star /////////////////////////////////////
                $target_dir = "uploads/article/video/";
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
                $article->update($id, $_POST,'article_id');
                redirect('admin/article/edit/'.$id);
            }
            //////////////// get article info ////////////////
            $data['row'] = $article->first(['user_id'=>$user_id, 'article_id'=>$id]);
        }
        else {
            //////////////// article view ////////////////
            $data['rows'] = $article->where(['user_id'=>$user_id]);
        }
        // $this->view('/../front/article',$data);
    }
    public function profile($id= null): void 
    {
        $id ??= auth::getuser_Id();
        $user = new userModel();
        $data['row'] = $row = $user->first(['id'=>$id]);
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