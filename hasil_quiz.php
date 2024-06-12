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
    // Include database connection
    $pdo = include "koneksi.php";

    // Check if form is submitted
    if (!empty($_POST['jawaban'])) {
        try {
            // Initialize HTML for displaying results
            $html = '<ol>';
            $totalSkor = 0;

            // Loop through submitted answers
            foreach ($_POST['jawaban'] as $idPertanyaan => $idJawaban) {
                // Query to fetch question
                $query = $pdo->prepare("SELECT * FROM pertanyaan WHERE id = :id");
                $query->execute(array("id" => $idPertanyaan));
                $pertanyaan = $query->fetch();

                $html .= '<li>';
                $html .= htmlentities($pertanyaan['deskripsi']);

                // Query to fetch submitted answer
                $query2 = $pdo->prepare("SELECT * FROM jawaban WHERE id = :id AND id_pertanyaan = :id_pertanyaan");
                $query2->execute(array(
                    'id' => $idJawaban,
                    'id_pertanyaan' => $idPertanyaan
                ));
                $jawaban = $query2->fetch();

                if (!$jawaban) {
                    $html .= '<p style="color:red">Salah</p>';
                } else {
                    $html .= '<p>Jawaban: '. $jawaban['deskripsi'].'</p>';
                    if ($jawaban['benar'] == 1) {
                        $html .= '<p style="color:green">Benar</p>';
                        $totalSkor += $pertanyaan['skor'];
                    } else {
                        $html .= '<p style="color:red">Salah</p>';
                    }
                }

                $html .= '</li>';
            }

            $html .= '</ol>';

            // Display total score
            echo '<h1>Selamat Skor Anda: '.$totalSkor.'</h1>';

            // Display detailed answers
            echo '<h2>Detail Hasil Anda</h2>';
            echo $html;

        } catch (Exception $e) {
            echo "Gagal menampilkan hasil. ";
            echo "Error: " . htmlentities($e->getMessage());
        }
    } else {
        echo "<p>Belum ada jawaban yang dikirimkan.</p>";
    }
    ?>
	<?php include "layout/footer" ?>


    
</body>
</html>