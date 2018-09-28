<?php
if ($mobile == "1") {
    ?><link rel="stylesheet" type="text/css" href="/css/projects/viewMobile.css"  />
    <link rel="stylesheet" type="text/css" href="/slick/slick.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="/slick/slick.min.js"></script>
    <script type="text/javascript" src="/js/projects/viewMobile.js"></script>
<?php } else {
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link href="/css/projects/view.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/projects/view.js"></script>
<?php } ?>

<?php
$filesArray = array();
foreach ($project->projectFiles as $projectFile)
    $filesArray[] = HelperFunctions::modelToArray($projectFile);
?>
<div id="filesForJS" style='display:none'>
    <?php echo json_encode($filesArray); ?>
</div>
<?php
if ($mobile == "1") {
    ?><div id="headerDummy"></div>
<?php }
?>
<div id="projectDevelopment">
    <div id="projectDevelopmentContainer">
        <div class="centeredContent">

            <?php
            if ($mobile == "1") {
                ?><div class="projectGallery"> 
                <?php
                foreach ($project->projectFiles as $projectFile) {
                    ?><div><img class="projectImages" src="<?php echo $projectFile->url; ?>"/></div>
                    <?php } ?>
                </div>
            <?php } else {
                ?><div id="projectCol1">
                <?php
                $this->renderPartial('/tools/MMGallery', array('files' => array()));
                ?>
                </div><?php } ?>
            <div id="projectCol2">
                <?php
                if ($mobile == "1") {
                    ?><div class="projectInfoDiv">
                        <span class="projectTitle font1">PROYECTO: </span> <span class="projectTitle font7"> <?php echo $project->name; ?></span>
                    </div>
                    <div class="projectInfoDiv">
                        <span class="projectTitle font1">TRABAJO: </span> <span class="projectTitle font7"> <?php echo (string) $category; ?></span>
                    </div>
                    <div class="projectInfoDivLast">
                        <span class="projectTitle font1">DESCRIPCIÓN: </span> <span class="projectTitle font7"> <?php echo $project->description; ?></span>
                    </div>
                <?php } else {
                    ?><div class="projectTitle font1">
                        PROYECTO
                    </div>
                    <div class="projectInfo font7">
                        <?php echo $project->client; ?>
                    </div>
                    <div class="projectTitle font1">
                        TRABAJO
                    </div>
                    <div class="projectInfo font7">
                        <?php echo $project->name; ?>
                    </div>
                    <div class="projectTitle font1">
                        DESCRIPCION
                    </div>
                    <div class="projectInfo font7">
                        <?php
                        $str = $project->description;
                        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
                        $urls = array();
                        $urlsToReplace = array();
                        if (preg_match_all($reg_exUrl, $str, $urls)) {
                            $numOfMatches = count($urls[0]);
                            $numOfUrlsToReplace = 0;
                            for ($i = 0; $i < $numOfMatches; $i++) {
                                $alreadyAdded = false;
                                $numOfUrlsToReplace = count($urlsToReplace);
                                for ($j = 0; $j < $numOfUrlsToReplace; $j++) {
                                    if ($urlsToReplace[$j] == $urls[0][$i]) {
                                        $alreadyAdded = true;
                                    }
                                }
                                if (!$alreadyAdded) {
                                    array_push($urlsToReplace, $urls[0][$i]);
                                }
                            }
                            $numOfUrlsToReplace = count($urlsToReplace);
                            for ($i = 0; $i < $numOfUrlsToReplace; $i++) {
                                $str = str_replace($urlsToReplace[$i], "<a target='_blank' style='color: blue;' href=\"" . $urlsToReplace[$i] . "\">" . $urlsToReplace[$i] . "</a> ", $str);
                            }
                            echo $str;
                        } else {
                            echo $str;
                        }
                        ?>
                    </div>

                    <img class="lineProjectDevelopment" src="/files/layouts/lineProjectDevelopment.png"/><?php } ?>           
            </div>
        </div>
        <div id="fullscreenImageContainer" number="">

            <div id="magnifiedImageContainer" number="">
                <img id="closeIcon" src="/files/layouts/close.png"/>
                <img id="magnifiedImage" src=""/>
            </div>
            <img id="leftArrowGallery" src="/files/layouts/leftArrowGallery.png"/>
            <img id="rightArrowGallery" src="/files/layouts/rightArrowGallery.png"/>
        </div>
    </div>
</div>