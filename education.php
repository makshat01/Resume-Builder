<?php  
    include("includes/includedFiles.php");

    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];
    
?>
    <h1 class="pageHeadingBig">Education</h1>

    <div id="educationContainer">
        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $query = mysqli_query($con, "SELECT education_id FROM education WHERE resume_id='$resume_id'");
                    $education_ids = array();

                    if(mysqli_num_rows($query)){
                        while($row = mysqli_fetch_array($query)){
                            array_push($education_ids, $row['education_id']);
                        }
                    }                

                    $i = 1;

                    foreach($education_ids as $education_id){

                        $education = new Education($con, $education_id);
                        $education_degree = $education->getDegree();
                        $education_institute = $education->getInstitute();
                        $education_start_date = $education->getStartDate();
                        $education_end_date = $education->getEndDate();
                        $education_description = $education->getDescription();

                        echo "
                            <li class='tracklistRow'>
                                <div class='trackCount'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                    <span class='trackName'>$education_degree</span>
                                    <span class='trackName'>$education_institute</span>
                                    <span class='trackName'>$education_start_date</span>
                                    <span class='trackName'>$education_end_date</span>
                                    <span class='trackName'>$education_description</span>
                                </div>
                            </li>
                        ";

                        $i = $i + 1;
                    }
                ?>
            </ul>
        </div>

        <div id="inputContainer">
            <h2>Add a Education</h2>
            <p>
                <label for="educationDegree">Degree</label>
                <input id="educationDegree" name="educationDegree" type="text" placeholder="e.g. B.E." required>
                <label for="educationInstitute">Institute</label>
                <input id="educationInstitute" name="educationInstitute" type="text" placeholder="e.g. D.J.Sanghvi" required>
                <label for="educationStartDate">StartDate</label>
                <input id="educationStartDate" name="educationStartDate" type="text" placeholder="e.g. March 2017" required>
                <label for="educationEndDate">EndDate</label>
                <input id="educationEndDate" name="educationEndDate" type="text" placeholder="e.g. April 2019 or Pursuing" required>
                <label for="educationDescription">Description</label>
                <input id="educationDescription" name="educationDescription" type="text" placeholder="e.g. CGPA ..." required>
            </p>   
            <button type="submit" name="educationButton" onclick="addEducation(<?php echo $resume_id; ?>)">Add Education</button>                
        </div>
    </div>

    <div id="nextContainer">
        <div id="inputContainer">
            <button type="submit" name="nextButton" onclick="openPage('experience.php?')">Next</button>               
        </div>
    </div>
