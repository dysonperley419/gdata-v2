<?php echo "<?xml version='1.0' encoding='UTF-8'?>" ;
$query = $_GET['q'];
include 'cfg.php';
$request = $lemnobase."search?part=id,snippet&maxResults=25&type=video&q=".urlencode($query);
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$ytdata = json_decode(curl_exec($ch), true);
curl_close($ch);
  function getUsername($chid) {
      include 'cfg.php';
      $request = "https://www.googleapis.com/youtube/v3/channels?key=".$apikey."&part=snippet&id=".$chid;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $request);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $responsee = json_decode(curl_exec($ch), true);
      curl_close($ch);
      return str_replace('@', '', $responsee["items"][0]["snippet"]["customUrl"]);
    }
?>
<feed>
    <id>http://gdata.youtube.com/feeds/api/videos</id>
    <category scheme='http://schemas.google.com/g/2005#kind' term='http://gdata.youtube.com/schemas/2007#video'/>
    <title type='text'>YouTube Videos</title>
    <logo>http://www.youtube.com/img/pic_youtubelogo_123x63.gif</logo>
    <link rel='alternate' type='text/html' href='http://www.youtube.com'/>
    <link rel='http://schemas.google.com/g/2005#feed' type='application/atom+xml' href='http://gdata.youtube.com/feeds/api/videos'/>
    <link rel='http://schemas.google.com/g/2005#batch' type='application/atom+xml' href='http://gdata.youtube.com/feeds/api/videos/batch'/>
    <author>
      <name>YouTube/yt2009</name>
      <uri>http://www.youtube.com/</uri>
    </author>
    <generator version='2.0' uri='http://gdata.youtube.com/'>YouTube data API</generator>
    <openSearch:totalResults><?php
 echo $ytdata['pageInfo']['totalResults'];
  ?></openSearch:totalResults>
    <openSearch:startIndex>1</openSearch:startIndex>
    <openSearch:itemsPerPage>25</openSearch:itemsPerPage>
<?php
  for ($i=0;$i<25;$i++){
    
    include 'cfg.php';
    $request = $lemnobase."videos?part=contentDetails,statistics&id=".$ytdata["items"][$i]["id"]["videoId"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $request);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    $duration = new DateInterval ($response['items'][0]['contentDetails']['duration']);
    $duration_s = $duration->days * 86400 + $duration->h * 3600 + $duration->i * 60 + $duration->s;
    ?>
        <entry>
            <id><?php echo $shema ?>://<?php echo $insturl?>/feeds/api/videos/<?php echo $ytdata["items"][$i]["id"]["videoId"]?></id>
            <youTubeId id='<?php echo $ytdata["items"][$i]["id"]["videoId"]?>'><?php echo $ytdata["items"][$i]["id"]["videoId"]?></youTubeId>
            <published><?php echo $ytdata["items"][$i]["snippet"]["publishedAt"]?></published>
            <updated><?php echo $ytdata["items"][$i]["snippet"]["publishedAt"]?></updated>
            <category scheme="http://gdata.youtube.com/schemas/2007/categories.cat" label="People &amp; Blogs" term="People &amp; Blogs">People &amp; Blogs</category>
            <title type='text'><?php echo $ytdata["items"][$i]["snippet"]["title"]?></title>
            <content type='text'><?php echo $ytdata["items"][$i]["snippet"]["description"]?></content>
            <link rel="http://gdata.youtube.com/schemas/2007#video.related" href="<?php echo $shema ?>://<?php echo $insturl?>/feeds/api/videos/<?php echo $ytdata["items"][$i]["id"]["videoId"]?>/related"/>
            <author>
                <name><?php echo $ytdata["items"][$i]["snippet"]["channelTitle"] ?></name>
                <uri>http://gdata.youtube.com/feeds/api/users/<?php echo getUsername($ytdata["items"][$i]["snippet"]["channelId"]) ?></uri>
            </author>
            <gd:comments>
                <gd:feedLink href='<?php echo $shema ?>://<?php echo $insturl?>/feeds/api/videos/<?php echo $ytdata["items"][$i]["id"]["videoId"]?>/comments' countHint='530'/>
            </gd:comments>
            <media:group>
                <media:category label='People &amp; Blogs' scheme='http://gdata.youtube.com/schemas/2007/categories.cat'>People &amp; Blogs</media:category>
                <media:content url='https://yt2009akivec.onrender.com/channel_fh264_getvideo?v=<?php echo $ytdata["items"][$i]["id"]["videoId"]?>' type='video/3gpp' medium='video' expression='full' duration='999' yt:format='3'/>
                <media:description type='plain'><?php echo $ytdata["items"][$i]["snippet"]["description"]?></media:description>
                <media:keywords>-</media:keywords>
                <media:player url='http://www.youtube.com/watch?v=<?php echo $ytdata["items"][$i]["id"]["videoId"]?>'/>
                <media:thumbnail yt:name='hqdefault' url='http://i.ytimg.com/vi/<?php echo $ytdata["items"][$i]["id"]["videoId"]?>/hqdefault.jpg' height='240' width='320' time='00:00:00'/>
                <media:thumbnail yt:name='poster' url='http://i.ytimg.com/vi/<?php echo $ytdata["items"][$i]["id"]["videoId"]?>/0.jpg' height='240' width='320' time='00:00:00'/>
                <media:thumbnail yt:name='default' url='http://i.ytimg.com/vi/<?php echo $ytdata["items"][$i]["id"]["videoId"]?>/0.jpg' height='240' width='320' time='00:00:00'/>
                <yt:duration seconds='<?php echo $duration_s?>'/>
                <yt:videoid id='<?php echo $ytdata["items"][$i]["id"]["videoId"]?>'><?php echo $ytdata["items"][$i]["id"]["videoId"]?></yt:videoid>
                <youTubeId id='<?php echo $ytdata["items"][$i]["id"]["videoId"]?>'><?php echo $ytdata["items"][$i]["id"]["videoId"]?></youTubeId>
                <media:credit role='uploader' name='<?php echo $ytdata["items"][$i]["snippet"]["channelTitle"] ?>'><?php echo $ytdata["items"][$i]["snippet"]["channelTitle"] ?></media:credit>
            </media:group>
            <gd:rating average='5' max='5' min='1' numRaters='0' rel='http://schemas.google.com/g/2005#overall'/>
            <yt:statistics favoriteCount="0" viewCount="<?php echo $response['items'][0]['statistics']['viewCount'] ?>"/>
            <yt:rating numLikes="<?php echo $response['items'][0]['statistics']['likeCount'] ?>" numDislikes="0"/>
        </entry>
        
    <?php }; ?>
</feed>