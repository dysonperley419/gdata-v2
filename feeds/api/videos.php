<?php echo "<?xml version='1.0' encoding='UTF-8'?>";
  $vid = $_GET['vid'];

    include 'cfg.php';
    $request = $lemnobase."videos?part=contentDetails,snippet,statistics&id=".$vid;
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
    };
    
   
    $duration = new DateInterval ($ytdata['items'][0]['contentDetails']['duration']);
    $duration_s = $duration->days * 86400 + $duration->h * 3600 + $duration->i * 60 + $duration->s;
    ?>
        <entry>
            <id><?php echo $shema ?>://<?php echo $insturl?>/feeds/api/videos/<?php echo $vid ?></id>
            <youTubeId id='<?php echo $vid?>'><?php echo $vid?></youTubeId>
            <published><?php echo $ytdata["items"][0]["snippet"]["publishedAt"]?></published>
            <updated><?php echo $ytdata["items"][0]["snippet"]["publishedAt"]?></updated>
            <category scheme="http://gdata.youtube.com/schemas/2007/categories.cat" label="People &amp; Blogs" term="People &amp; Blogs">People &amp; Blogs</category>
            <title type='text'><?php echo $ytdata["items"][0]["snippet"]["title"]?></title>
            <content type='text'><?php echo $ytdata["items"][0]["snippet"]["description"]?></content>
            <link rel="http://gdata.youtube.com/schemas/2007#video.related" href="<?php echo $shema ?>://<?php echo $insturl?>/feeds/api/videos/<?php echo $vid?>/related"/>
            <author>
                <name><?php echo $ytdata["items"][0]["snippet"]["channelTitle"] ?></name>
                <uri>http://gdata.youtube.com/feeds/api/users/<?php echo getUsername($ytdata["items"][0]["snippet"]["channelId"]) ?></uri>
            </author>
            <gd:comments>
                <gd:feedLink href='<?php echo $shema ?>://<?php echo $insturl?>/feeds/api/videos/<?php echo $vid?>/comments' countHint='530'/>
            </gd:comments>
            <media:group>
                <media:category label='People &amp; Blogs' scheme='http://gdata.youtube.com/schemas/2007/categories.cat'>People &amp; Blogs</media:category>
                <media:content url='<?php echo "https://yt2009akivec.onrender.com/channel_fh264_getvideo?v=".$vid ?>' type='video/3gpp' medium='video' expression='full' duration='999' yt:format='3'/>
                <media:description type='plain'><?php echo $ytdata["items"][0]["snippet"]["description"]?></media:description>
                <media:keywords>-</media:keywords>
                <media:player url='http://www.youtube.com/watch?v=<?php echo $vid?>'/>
                <media:thumbnail yt:name='hqdefault' url='http://i.ytimg.com/vi/<?php echo $vid?>/hqdefault.jpg' height='240' width='320' time='00:00:00'/>
                <media:thumbnail yt:name='poster' url='http://i.ytimg.com/vi/<?php echo $vid?>/0.jpg' height='240' width='320' time='00:00:00'/>
                <media:thumbnail yt:name='default' url='http://i.ytimg.com/vi/<?php echo $vid?>/0.jpg' height='240' width='320' time='00:00:00'/>
                <yt:duration seconds='<?php echo $duration_s?>'/>
                <yt:videoid id='<?php echo $vid?>'><?php echo $vid?></yt:videoid>
                <youTubeId id='<?php echo $vid?>'><?php echo $vid?></youTubeId>
                <media:credit role='uploader' name='<?php echo $ytdata["items"][0]["snippet"]["channelTitle"] ?>'><?php echo $ytdata["items"][0]["snippet"]["channelTitle"] ?></media:credit>
            </media:group>
            <gd:rating average='5' max='5' min='1' numRaters='0' rel='http://schemas.google.com/g/2005#overall'/>
            <yt:statistics favoriteCount="0" viewCount="<?php echo $ytdata['items'][0]['statistics']['viewCount'] ?>"/>
            <yt:rating numLikes="<?php echo $ytdata['items'][0]['statistics']['likeCount'] ?>" numDislikes="0"/>
        </entry>
