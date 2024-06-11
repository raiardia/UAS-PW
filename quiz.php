<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>UAS PEMROGRAMAN WEB</title>
</head>
<body>
    <?php include "layout/header" ?>
		<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	    	<a class="navbar-brand" href="index.php"><span class="flaticon-pawprint-1 mr-2"></span>DOGI FOR US</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="fa fa-bars"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
				<li class="nav-item"><a href="about.php" class="nav-link">About Us</a></li>
				<li class="nav-item"><a href="gallery.php" class="nav-link">Gallery</a></li>
				<li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
				<li class="nav-item active"><a href="quiz.php" class="nav-link">Quiz</a></li>
			</ul>
	      </div>
	    </div>
	  </nav>
<!-- END nav -->
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-end">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Quiz <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-0 bread">Quiz</h1>
          </div>
        </div>
      </div>
    </section>

    <?php
$conn = include "koneksi.php";

if (!$conn instanceof mysqli) {
    die("Failed to connect to the database.");
}

try {
    $sql = "SELECT * FROM pertanyaan ORDER BY RAND() LIMIT 50";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<ol>';
        while ($pertanyaan = $result->fetch_assoc()) {
            echo '<li>';
            echo htmlentities($pertanyaan['deskripsi']);

            $sql2 = "SELECT * FROM jawaban WHERE id_pertanyaan = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("i", $pertanyaan['id']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2 && $result2->num_rows > 0) {
                echo '<ol type="A">';
                while ($jawaban = $result2->fetch_assoc()) {
                    echo '<li>';
                    echo '<input type="radio" name="jawaban[' . $pertanyaan['id'] . ']" value="' . $jawaban['id'] . '"/> ';
                    echo htmlentities($jawaban['deskripsi']);
                    echo '</li>';
                }
                echo '</ol>';
            } else {
                echo "No answers found for question.";
            }

            echo '</li>';
        }
        echo '</ol>';
    } else {
        echo "No questions found.";
    }
} catch (Exception $e) {
    echo "Failed to fetch questions. Error: " . htmlentities($e->getMessage());
}
?>

    
</body>
</html>