<?php  
    include("includes/includedFiles.php");

    
    $user_id = $userLoggedIn->getUserId();

    $query = mysqli_query($con, "SELECT resume_id FROM resume WHERE user_id='$user_id'");
    $resume = mysqli_fetch_array($query);
    $resume_id = $resume['resume_id'];
    
    // include("includes/handlers/skill-handler.php");
?>
    <h1 class="pageHeadingBig">WEBSITES</h1>

    <div id="websiteContainer">
        <div class="tracklistContainer">
            <ul class="tracklist">
                <?php
                    $query = mysqli_query($con, "SELECT website_id FROM website WHERE resume_id='$resume_id'");
                    $website_ids = array();

                    if(mysqli_num_rows($query)){
                        while($row = mysqli_fetch_array($query)){
                            array_push($website_ids, $row['website_id']);
                        }
                    }                

                    $i = 1;

                    foreach($website_ids as $website_id){

                        $website = new Website($con, $website_id);
                        $website_name = $website->getName();
                        $website_url = $website->getURL();

                        echo "
                            <li class='tracklistRow'>
                                <div class='trackCount'>
                                    <span class='trackNumber'>$i</span>
                                </div>

                                <div class='trackInfo'>
                                        <span class='trackName'>$website_name</span>
                                        <span class='trackName'>$website_url</span>
                                </div>
                            </li>
                        ";

                        $i = $i + 1;
                    }
                ?>
            </ul>
        </div>

        <div id="inputContainer">
            <h2>Add a Website</h2>
            <p>
                <label for="websiteName">Website</label>
                <input id="websiteName" name="websiteName" type="text" placeholder="e.g. Github" required>
                <label for="websiteURL">URL</label>
                <input id="websiteURL" name="websiteURL" type="text" placeholder="e.g. github.com" required>
            </p>   
            <button type="submit" name="websiteButton"  onclick="addWebsite(<?php echo $resume_id; ?>)" >Add Website</button>                
        </div>
    </div>

    <div id="nextContainer">
        <div id="inputContainer">
                <button type="submit" name="nextButton" onclick="openPage('language.php?')">Next</button>               
        </div>
    </div>