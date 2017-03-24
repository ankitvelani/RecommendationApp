 
<?php
$querytext = str_replace(',', ' , ', $keywords);
$querytext = str_replace(' ', '%20', $keywords);


$urls = "http://ieeexploreapi.ieee.org/api/v1/search/articles?querytext=$querytext&format=json&apikey=tk943w3rjxbjq2wnk8c849q4";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $urls);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result, $assoc = TRUE);
//print_r($result['articles'][0]);
//print_r(json_encode($result['articles'][0]));
?>
<div class="container">

    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <h2> Hi <?= $username; ?> !! ,Welcome to Aasha <small class="h6"><a href="?/logout">sign out</a></small></h2>
        <i> keywords : <?= $keywords; ?> </i>
        <br><br>
        <?php
        foreach ($result['articles'] as $article) {
            ?>  
            <div>
                <h4><a href="http://ieeexplore.ieee.org/document/<?= $article['article_number'] ?>" target='_new'><?= $article['publication_title']; ?></a></h4>
                <p>
                      <?= isset($article['abstract']) == TRUE ? substr($article['abstract'], 0, (strlen($article['abstract'])) / 2) : ""; ?>
                     
                    <br>
                    <br>
                </p>
            </div>
    <?php
}
?>

    </div>

    <div class="col-sm-2">
        <div class="gap-50"></div>
        <p class="page-header">Recommend Articles</p>
        <ul>
        <?php
            foreach ($paperDetail as $paper) {
        ?>
            <li class="h6"><a href="http://ieeexplore.ieee.org/document/<?=$paper['PaperID'];?>" target='_new'><?=$paper['Title'];?></a></li>
                <br>
        <?php
            }
        ?>
        </ul>
 

    </div>
</div>