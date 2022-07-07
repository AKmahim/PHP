

<?php 

	@include 'config.php';

	$msg = '';
	$file_formate_error = '';
	if(isset($_POST['submit'])){
		$name = $_POST['name'];
		$bio = $_POST['bio'];

		if(!empty($name) || !empty($bio) || !empty($_FILES['pic']['name'])){

			//get file info
			$fileName = basename($_FILES['pic']['name']);
			$fileType = pathinfo($fileName,PATHINFO_EXTENSION);

			//allow certain file formates
			$allowTypes = array('jpg','jpeg','png','gif');
			if(in_array($fileType, $allowTypes)){
				$image = $_FILES['pic']['tmp_name'];
				$imgContent = addslashes(file_get_contents($image));

				$insert = "INSERT INTO data (name,bio,pic) VALUES ('$name','$bio','$imgContent') ";
				$upload = mysqli_query($conn,$insert);
				if($upload){
					$msg = "Data upload successfully";
				}
				else{
					$msg = "Data could not upload";
				}

			}
			else{
				$file_formate_error = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
			}
		}
		else{
			$msg = "Please fill out all data.";
		}
	}

?>








<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD application using php</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

	<div class="container">
		<div class="mb-3 mt-3">
			<h2 class="text-danger"><?php echo $msg ; ?></h2>
		</div>
		<div class="form_container">
			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" >


				<div class="mb-3 mt-3">
					<label class="form-label">Name:</label>
					<input type="text" name="name" class="form-control" >

				</div>
				<div class="mb-3 mt-3">
					<label class="form-label">Bio</label>
					<input type="text" name="bio" class="form-control">
				</div>
				<div class="mb-3 mt-3">
					<label class="form-label">Upload Profile pic</label>
					<h3 class="text-danger"> 
					<?php 
						echo $file_formate_error;
					 ?>
					  </h3>
					<input type="file" name="pic" class="form-control">
					
				</div>

				<input type="submit" name="submit" class="btn btn-primary">
			</form>
		</div>
	</div>


	<div class="container pt-5 mt-3 bg-faded">
		<?php 
		$query = "SELECT * FROM data";
		$result =  mysqli_query($conn,$query);


		?>
		<?php while($row = mysqli_fetch_assoc($result)) { ?>
		<div class="mb-3 mt-3">
			<h1><?php echo $row['name'];?></h1>
		</div>
		<div class="mb-3 mt-3">
			<h1><?php echo $row['bio'];?></h1>
		</div>
		<div class="mb-3 mt-3">
			<img src="data:pic/jpg;charset=utf8;base64,<?php echo base64_encode($row['pic']); ?>" class="rounded" style="width:300px;height: 300px;">
		</div>

	<?php } ?>
	</div>

















	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>