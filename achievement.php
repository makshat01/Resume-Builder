<?php  
    include("includes/includedFiles.php");

    
    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];
?>
    <h1 class="pageHeadingBig">ACHIEVEMENTS</h1>

    <div id="achievementContainer">
        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $query = mysqli_query($con, "SELECT achievement_id FROM achievement WHERE resume_id='$resume_id'");
                    $achievement_ids = array();

                    if(mysqli_num_rows($query)){
                        while($row = mysqli_fetch_array($query)){
                            array_push($achievement_ids, $row['achievement_id']);
                        }
                    }                

                    $i = 1;

                    foreach($achievement_ids as $achievement_id){

                        $achievement = new Achievement($con, $achievement_id);
                        $achievement_name = $achievement->getName();

                        echo "
                            <li class='tracklistRow'>
                                <div class='trackCount'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                    <span class='trackName'>$achievement_name</span>
                                </div>

                                <div class='trackOptions'>
                                    <img class='optionButton' src='assets/images/icons/more.png' onclick='deleteAchievement($achievement_id, $resume_id)'>
                                </div>
                            </li>
                        ";

                        $i = $i + 1;
                    }
                ?>
            </ul>
        </div>

        <div id="inputContainer">
            <form action="achievement.php" id="achievementForm" method="POST">
                <h2>Add an Achievement</h2>
                <p>
                    <label for="achievementName">Achievement</label>
                    <input id="achievementName" name="achievementName" type="text" placeholder="e.g. First prize in ....." required>
                </p>   
                <button type="submit" name="achievementButton" onclick="addAchievement(<?php echo $resume_id; ?>)">Add Achievement</button>                
            </form>
        </div>
    </div>

    <div id="nextContainer">
        <div id="inputContainer">
                <button type="submit" name="nextButton" onclick="openPage('website.php?')">Next</button>               
        </div>
    </div>