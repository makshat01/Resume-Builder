<?php

    include("includes/config.php");
    include("includes/classes/User.php");
    include("includes/classes/Skill.php");
    include("includes/classes/Achievement.php");
    include("includes/classes/Website.php");
    include("includes/classes/Language.php");
    include("includes/classes/Education.php");
    include("includes/classes/Experience.php");

    if(isset($_GET['userLoggedInId'])){
        $userLoggedIn = new User($con, $_GET['userLoggedInId']);
    }
    else{
        echo "User name variable not passed into the page.";
    }

    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/html2canvas.esm.js"></script>
    <script src="assets/js/html2canvas.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <title>Document</title>
</head>
<body>
<div style="background-color:white;">
      <center>
        <button style="ali" onclick="generatePdf()">Generate PDF</button>
      </center>
  </div>
<?php

echo "<style>
    p {
        font-size: 17px;
        margin-top: 0;
        margin-bottom: 0;
    }

    h2{
        font-size: 20px;
        font-weight: 600;
    }

    .address {
        max-width: 180px;
    }

</style>
";

?>

<div id="pdfContents">
            <p><?php echo $userLoggedIn->getName(); ?></p>

            <p class="address"><?php echo $userLoggedIn->getAddress(); ?></p>

            <p><?php echo $userLoggedIn->getContact(); ?></p>

            <p><?php echo $userLoggedIn->getEmail(); ?></p>

            <?php
            $query = mysqli_query($con, "SELECT skill_id FROM skill WHERE resume_id='$resume_id'");
            $skill_ids = array();

            if(mysqli_num_rows($query)){
                echo "<h1 dir='ltr' >Skills</h1>";
                while($row = mysqli_fetch_array($query)){
                    array_push($skill_ids, $row['skill_id']);
                }
            }
            echo "<ul>";                
            foreach($skill_ids as $skill_id){

                $skill = new Skill($con, $skill_id);
                $skill_name = $skill->getName();

                echo "
                    <li>$skill_name</li>
                ";
            }
            echo "</ul>";
            ?>

            <?php
                $query = mysqli_query($con, "SELECT experience_id FROM experience WHERE resume_id='$resume_id'");
                $experience_ids = array();

                if(mysqli_num_rows($query)){
                    echo "<h1 dir='ltr' >Experience</h1>";
                    while($row = mysqli_fetch_array($query)){
                        array_push($experience_ids, $row['experience_id']);
                    }
                }                               
                foreach($experience_ids as $experience_id){

                    $experience = new Experience($con, $experience_id);
                    $experience_title = $experience->getTitle();
                    $experience_start_date = $experience->getStartDate();
                    $experience_end_date = $experience->getEndDate();
                    $experience_description = $experience->getDescription();

                    echo "
                    <h2 dir='ltr'>$experience_title</h2>
                    <h3 dir='ltr'>$experience_start_date - $experience_end_date</h3>
                    <p>$experience_description<p>
                    ";
                }

                ?>

                <?php
                $query = mysqli_query($con, "SELECT education_id FROM education WHERE resume_id='$resume_id'");
                $education_ids = array();

                if(mysqli_num_rows($query)){
                    echo "<h1 dir='ltr' >Education</h1>";
                    while($row = mysqli_fetch_array($query)){
                        array_push($education_ids, $row['education_id']);
                    }
                }

                foreach($education_ids as $education_id){

                    $education = new Education($con, $education_id);
                    $education_degree = $education->getDegree();
                    $education_institute = $education->getInstitute();
                    $education_start_date = $education->getStartDate();
                    $education_end_date = $education->getEndDate();
                    $education_description = $education->getDescription();

                    echo "
                        <h2 dir='ltr'>$education_institute - $education_degree</h2>
                        <h3 dir='ltr'>$education_start_date - $education_end_date</h3>
                        <p>$education_description<p>
                    ";
                }
                ?>

                <?php
                $query = mysqli_query($con, "SELECT achievement_id FROM achievement WHERE resume_id='$resume_id'");
                $achievement_ids = array();

                if(mysqli_num_rows($query)){
                    echo "<h1 dir='ltr' >Achievements</h1>";
                    while($row = mysqli_fetch_array($query)){
                        array_push($achievement_ids, $row['achievement_id']);
                    }
                }

                echo "<ul>";
                foreach($achievement_ids as $achievement_id){

                    $achievement = new Achievement($con, $achievement_id);
                    $achievement_name = $achievement->getName();

                    echo "
                        <li>$achievement_name</li>
                    ";
                }
                echo "</ul>";
                    
                ?>
</div>    
</body>
<script>
    function generatePdf() {  
      const filename  = "<?php echo $userLoggedIn->getName(); ?>'s Resume.pdf";

      html2canvas(document.querySelector('#pdfContents')).then(canvas => {
        let pdf = new jsPDF('p', 'mm', 'a4');
        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 211, 298);
        pdf.save(filename);
      });
    }
  </script>
</html>

