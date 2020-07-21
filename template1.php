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

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Template2</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
  <script src="assets/js/html2canvas.esm.js"></script>
  <script src="assets/js/html2canvas.js"></script>
  <script src="assets/js/html2canvas.min.js"></script>
  <script src="assets/js/script.js"></script>
</head>
<body>
  <style>
          html {
        box-sizing: border-box;
      }
      *, *:before, *:after {
        box-sizing: inherit;
      }

      body {
        font-family: 'Source Sans Pro', sans-serif;
        line-height: 1.5;
        background: #F2F2F2;
        color: #323232;
      }

      img {
        max-width: 100%;
      }

      .icon {
        fill: currentColor;
        display: inline-block;
        font-size: inherit;
        height: 1em;
        overflow: visible;
      }

      a {
        color: #323232;
        text-decoration: none;
      }

      .container {
        /* max-width: 960px;
        margin: 40px auto; */
        padding: 100px;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      section {
        display: grid;
        grid-template-columns: 1fr 4fr;
        grid-gap: 20px;
        padding: 24px 0;
        border-bottom: 1px solid lightgrey;
      }

      section:last-child {
        border-bottom: none;
      }

      .section-title {
        font-weight: bold;
        font-size: 18px;
      }

      /***********************************
      * =Main Info
      ***********************************/

      img.avatar {
        width: 130px;
      }

      .my-name {
        font-size: 48px;
        line-height: 1;
      }

      .my-title {
        font-size: 24px;
        font-weight: 300;
        color: #236FB2;
      }

      .links {
        display: flex;
        margin: 10px 0 20px 0;
      }

      .link-item {
        display: flex;
        align-items: center;
        flex: 1;
      }

      /***********************************
      * =Experience
      ***********************************/

      .job {
        padding-bottom: 24px;
        margin-bottom: 24px;
        border-bottom: 1px solid lightgrey;
        padding-left: 24px;
      }

      .job:last-child {
        border-bottom: none;
      }

      .job-title-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 18px;
      }

      .job-company {
        font-weight: bold;
        line-height: 1.2;
      }

      /***********************************
      * =Skills
      ***********************************/

      .skills-container {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 20px;
        margin-bottom: 24px;
      }

      .skills-container ul {
        margin-left: 20px;
        list-style-type: disc;
      }

      /***********************************
      * =Interests
      ***********************************/

      .interests-container {
        display: flex;
        justify-content: space-between;
      }

      .interests-container img {
        height: 35px;
        opacity: 0.75;
      }

      /***********************************
      * =References
      ***********************************/

      .reference {
        font-size: 18px;
      }

      .reference-details {
        margin-bottom: 20px;
      }

      @media only screen and (max-width : 768px) {
        section {
          grid-template-columns: 1fr;
        }

        .links, .job-title-container {
          flex-direction: column;
        }

        .skills-container {
          grid-template-columns: 1fr 1fr;
        }

        .interests-container {
          flex-wrap: wrap;
          justify-content: flex-start;
        }

        .interests-container img {
          margin-right: 32px;
          margin-bottom: 16px;
        }
      }
  </style>
  <div style="background-color:white;">
      <center>
        <button style="ali" onclick="generatePdf()">Generate PDF</button>
      </center>
  </div>
<div id="pdfContent">
  <div class="container">
      <div style="border-bottom: 1px solid lightgrey;">

        <div class="my-name"><?php echo $userLoggedIn->getName(); ?></div>
        <div class="links">
          <div class="link-item">
            <a><b style="font-weight:bold;">Email</b> : <?php echo $userLoggedIn->getEmail(); ?></a>
          </div>
          <div class="link-item">
            <a><b style="font-weight:bold;">Contact</b> : <?php echo $userLoggedIn->getContact(); ?></a>
          </div>
        </div>
        <div class="links">
        <?php
          $query = mysqli_query($con, "SELECT website_id FROM website WHERE resume_id='$resume_id'");
          $website_ids = array();

          if(mysqli_num_rows($query)){
              while($row = mysqli_fetch_array($query)){
                  array_push($website_ids, $row['website_id']);
              }
          } 
          foreach($website_ids as $website_id){

              $website = new Website($con, $website_id);
              $website_name = $website->getName();
              $website_url = $website->getURL();
              echo "
              <div class='link-item'>
                <a href='$website_url'><b style='font-weight:bold;'>$website_name</b> : $website_url</a>
              </div>
              ";
          }
          ?>
          
        </div>

        <p><b style='font-weight:bold;'>Address</b> : <?php echo $userLoggedIn->getAddress(); ?></p>
      </div>

    <section>
      
      <?php
        $query = mysqli_query($con, "SELECT experience_id FROM experience WHERE resume_id='$resume_id'");
        $experience_ids = array();

        if(mysqli_num_rows($query)){
            echo "<div class='section-title'>Experience</div>";
            while($row = mysqli_fetch_array($query)){
                array_push($experience_ids, $row['experience_id']);
            }
        } 
        echo '<div>';                              
        foreach($experience_ids as $experience_id){

            $experience = new Experience($con, $experience_id);
            $experience_title = $experience->getTitle();
            $experience_start_date = $experience->getStartDate();
            $experience_end_date = $experience->getEndDate();
            $experience_description = $experience->getDescription();
            $experience_company = $experience->getCompany();

            echo "
            <div class='job'>
              <div class='job-title-container'>
                <div>
                  <div class='job-company'>$experience_company</div>
                  <div class='job-title'>$experience_title</div>
                </div>
                <div>
                  $experience_start_date - $experience_end_date
                </div>
              </div>
              <p>$experience_description</p>
            </div>
            ";
        }
        echo "</div>";

        ?>
    </section>

    <section>
      <?php
        $query = mysqli_query($con, "SELECT education_id FROM education WHERE resume_id='$resume_id'");
        $education_ids = array();

        if(mysqli_num_rows($query)){
            echo "<div class='section-title'>Education</div>";
            while($row = mysqli_fetch_array($query)){
                array_push($education_ids, $row['education_id']);
            }
        }
        echo '<div>';                              

        foreach($education_ids as $education_id){

            $education = new Education($con, $education_id);
            $education_degree = $education->getDegree();
            $education_institute = $education->getInstitute();
            $education_start_date = $education->getStartDate();
            $education_end_date = $education->getEndDate();
            $education_description = $education->getDescription();

            echo "
            <div class='job'>
              <div class='job-title-container'>
                <div>
                  <div class='job-company'>$education_institute</div>
                  <div class='job-title'>$education_degree</div>
                </div>
                <div>
                  $education_start_date - $education_end_date
                </div>
              </div>
              <p>$education_description</p>
            </div>
            ";
        }
        echo "</div>";
        ?>
    </section>

    <section>
    <?php
      $query = mysqli_query($con, "SELECT skill_id FROM skill WHERE resume_id='$resume_id'");
      $skill_ids = array();

      if(mysqli_num_rows($query)){
          echo "<div class='section-title'>Skills</div>";
          while($row = mysqli_fetch_array($query)){
              array_push($skill_ids, $row['skill_id']);
          }
      }
      echo "<div>";               
      echo "<div class='skills-container'>";               
      $i = 0; 
      $flag = 0;
      foreach($skill_ids as $skill_id){

        $skill = new Skill($con, $skill_id);
        $skill_name = $skill->getName();

        if($i==0){
          echo "<ul>";
          $flag = 1;
        } 
        echo "
            <li>$skill_name</li>
        ";
        $i = $i + 1;
        if($i==4){
          echo '</ul>';
          $flag = 0;
          $i = 0;
        }
      }
      if($flag == 1){
        echo '</ul>';
      }
      echo "</div>";
      echo "</div>";
    ?>
      
    </section>

    <section>
      <?php
        $query = mysqli_query($con, "SELECT achievement_id FROM achievement WHERE resume_id='$resume_id'");
        $achievement_ids = array();

        if(mysqli_num_rows($query)){
            echo "<div class='section-title'>Achievements</div>";
            while($row = mysqli_fetch_array($query)){
                array_push($achievement_ids, $row['achievement_id']);
            }
        }
        echo "<div>";               
        echo "<div class='skills-container'>";      
        echo "<ul>";
        foreach($achievement_ids as $achievement_id){

            $achievement = new Achievement($con, $achievement_id);
            $achievement_name = $achievement->getName();

            echo "
                <li>$achievement_name</li>
            ";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
      ?>
    </section>

    <section>
      <?php
        $query = mysqli_query($con, "SELECT language_id FROM resume_language WHERE resume_id='$resume_id'");
        $language_ids = array();

        if(mysqli_num_rows($query)){
            echo "<div class='section-title'>Language</div>";
            while($row = mysqli_fetch_array($query)){
                array_push($language_ids, $row['language_id']);
            }
        }
        echo "<div>";               
        echo "<div class='skills-container'>";               
        $i = 0; 
        $flag = 0;
        foreach($language_ids as $skill_id){

          $skill = new Language($con, $skill_id);
          $skill_name = $skill->getName();

          if($i==0){
            echo "<ul>";
            $flag = 1;
          } 
          echo "
              <li>$skill_name</li>
          ";
          $i = $i + 1;
          if($i==4){
            echo '</ul>';
            $flag = 0;
            $i = 0;
          }
        }
        if($flag == 1){
          echo '</ul>';
        }
        echo "</div>";
        echo "</div>";
      ?>
        
    </section>


  </div>
  </div>
  <script>
    function generatePdf() {  
      const filename  = "<?php echo $userLoggedIn->getName(); ?>'s Resume.pdf";

      html2canvas(document.querySelector('#pdfContent'), {scale:2}).then(canvas => {
        let pdf = new jsPDF('p', 'mm', 'a4');
        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 211, 298);
        pdf.save(filename);
      });

      
    }
  </script>
</body>
</html>