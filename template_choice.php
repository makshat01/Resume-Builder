<?php


    include("includes/includedFiles.php");


?>

<div class="gridViewContainer">
    <h1 class="pageHeadingBig">TEMPLATES</h1>            
        <div class='gridViewItem'>
            <span role='link' tabindex='0' onclick="templatePreview( 'template1', userLoggedInId)">
                <img src='assets/images/artwork/resume_template.png'>

                <div class='gridViewInfo'>
                    TEMPLATE 1
                </div>
            </span>
        </div>
        <div class='gridViewItem'>
            <span role='link' tabindex='0' onclick="templatePreview( 'template2', userLoggedInId)">
                <img src='assets/images/artwork/resume_template.png'>

                <div class='gridViewInfo'>
                    TEMPLATE 2
                </div>
            </span>
        </div>
        <div class='gridViewItem'>
            <span role='link' tabindex='0' onclick=''>
                <img src='assets/images/artwork/resume_template.png'>

                <div class='gridViewInfo'>
                    TEMPLATE 3
                </div>
            </span>
        </div>
</div>