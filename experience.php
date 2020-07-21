<?php  
    include("includes/includedFiles.php");

    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];
    
?>
<h1 class="pageHeadingBig">Experience</h1>

<div id="experienceContainer">
    <div class="tracklistContainer">
        <ul class="tracklist">
            <?php
                $query = mysqli_query($con, "SELECT experience_id FROM experience WHERE resume_id='$resume_id'");
                $experience_ids = array();

                if(mysqli_num_rows($query)){
                    while($row = mysqli_fetch_array($query)){
                        array_push($experience_ids, $row['experience_id']);
                    }
                }                

                $i = 1;

                foreach($experience_ids as $experience_id){

                    $experience = new Experience($con, $experience_id);
                    $experience_title = $experience->getTitle();
                    $experience_start_date = $experience->getStartDate();
                    $experience_end_date = $experience->getEndDate();
                    $experience_description = $experience->getDescription();
                    $experience_company = $experience->getCompany();

                    echo "
                        <li class='tracklistRow'>
                            <div class='trackCount'>
                                <span class='trackNumber'>$i</span>
                            </div>

                            <div class='trackInfo'>
                                <span class='trackName'>$experience_company</span>
                                <span class='trackName'>$experience_title</span>
                                <span class='trackName'>$experience_start_date</span>
                                <span class='trackName'>$experience_end_date</span>
                                <span class='trackName'>$experience_description</span>
                            </div>
                        </li>
                    ";

                    $i = $i + 1;
                }
            ?>
        </ul>
    </div>

    <div id="inputContainer">
        <h2>Add a Experience</h2>
        <p>
            <label for="experienceCompany">Company</label>
            <input id="experienceCompany" name="experienceCompany" type="text" placeholder="e.g.Omic Healthcare" required>
            <label for="experienceTitle">Title</label>
            <input id="experienceTitle" name="experienceTitle" type="text" placeholder="e.g. Full Stack Web Dev" required>
            <label for="experienceStartDate">StartDate</label>
            <input id="experienceStartDate" name="experienceStartDate" type="text" placeholder="e.g. March 2017" required>
            <label for="experienceEndDate">EndDate</label>
            <input id="experienceEndDate" name="experienceEndDate" type="text" placeholder="e.g. April 2019 or Pursuing" required>
            <label for="experienceDescription">Description</label>
            <input id="experienceDescription" name="experienceDescription" type="text" placeholder="e.g. Job Description" required>
        </p>   
        <button type="submit" name="experienceButton" onclick="addExperience(<?php echo $resume_id; ?>)">Add Experience</button>                
    </div>
</div>

<div id="nextContainer">
    <div id="inputContainer">
        <button type="submit" name="nextButton" onclick="openPage('template_choice.php?')">Next</button>               
    </div>
</div>
