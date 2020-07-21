<?php  
    include("includes/includedFiles.php");

    
    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];
    
    // include("includes/handlers/skill-handler.php");
?>
    <h1 class="pageHeadingBig">SKILL</h1>

    <div id="skillContainer">
        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $query = mysqli_query($con, "SELECT skill_id FROM skill WHERE resume_id='$resume_id'");
                    $skill_ids = array();

                    if(mysqli_num_rows($query)){
                        while($row = mysqli_fetch_array($query)){
                            array_push($skill_ids, $row['skill_id']);
                        }
                    }                

                    $i = 1;

                    foreach($skill_ids as $skill_id){

                        $skill = new Skill($con, $skill_id);
                        $skill_name = $skill->getName();

                        echo "
                            <li class='tracklistRow'>
                                <div class='trackCount'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                    <span class='trackName'>$skill_name</span>
                                </div>
                                <div class='trackOptions'>
                                    <img class='optionButton' src='assets/images/icons/minus-1.png' onclick='deleteSkill($skill_id, $resume_id)'>
                                </div>
                            </li>
                        ";

                        $i = $i + 1;
                    }
                ?>
            </ul>
        </div>

        <div id="inputContainer">
            <h2>Add a Skill</h2>
            <p>
                <label for="skillName">Skill</label>
                <input id="skillName" name="skillName" type="text" placeholder="e.g. Python" required>
            </p>   
            <button type="submit" name="skillButton" onclick="addSkill(<?php echo $resume_id; ?>)">Add Skill</button>                
        </div>
    </div>

    <div id="nextContainer">
        <div id="inputContainer">   
            <button type="submit" name="nextButton" onclick="openPage('achievement.php?')">Next</button>               
        </div>
    </div>