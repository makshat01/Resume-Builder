<?php  
    include("includes/includedFiles.php");

    
    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];
    
    // include("includes/handlers/skill-handler.php");
?>
    <h1 class="pageHeadingBig">LANGUAGES</h1>

    <div id="languageContainer">
        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $query = mysqli_query($con, "SELECT language_id FROM language WHERE language_id IN (SELECT language_id FROM resume_language WHERE resume_id='$resume_id')");
                    $language_ids = array();

                    if(mysqli_num_rows($query)){
                        while($row = mysqli_fetch_array($query)){
                            array_push($language_ids, $row['language_id']);
                        }
                    }                

                    $i = 1;

                    foreach($language_ids as $language_id){

                        $language = new Language($con, $language_id);
                        $language_name = $language->getName();

                        echo "
                            <li class='tracklistRow'>
                                <div class='trackCount'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                        <span class='trackName'>$language_name</span>
                                </div>
                            </li>
                        ";

                        $i = $i + 1;
                    }
                ?>
            </ul>
        </div>

        <div id="inputContainer">
            <h2>Add a Language</h2>
            <p>
                <label for="languageName">Language</label>
                <input id="languageName" name="languageName" type="text" placeholder="e.g. English" required>
            </p>   
            <button type="submit" name="languageButton" onclick="addLanguage(<?php echo $resume_id; ?>)">Add Language</button>                
        </div>
    </div>

    <div id="nextContainer">
        <div id="inputContainer">
            <button type="submit" name="nextButton" onclick="openPage('education.php')">Next</button>               
        </div>
    </div>