<?php

function fetchYTchannelVideos($maxcount, $channelid)
{
	$getytdata = file_get_contents("https://www.youtube.com/feeds/videos.xml?channel_id=".$channelid);

	$videofeed = simplexml_load_string($getytdata);	

	$counter = 0;
	foreach($videofeed->entry as $videodata)
	{
		if ($counter < $maxcount)
		{
			$link = $videodata->link;
			$attrs = $link->attributes();
			$vidaddress = (string) $attrs->href;
			
			$date = (string) $videodata->published;
			
			$medianamespace = $videodata->children('media', TRUE);

			$title = (string) $medianamespace->group->title; 
			$description = (string) $medianamespace->group->description;
			$thumbnail = (string) $medianamespace->group->thumbnail->attributes()->url;
			$views = (string) $medianamespace->group->community->statistics->attributes()->views;
			
			?> 

					<div  id="<?php echo $counter; ?>" class="ytboxbg">

					<a data-rokbox href="<?php echo $vidaddress; ?>" title="<?php echo $title; ?>">

					<div>
					<div style="float: left; width: 310px; height: 182px; border-radius: 5px 5px 0px 0px; border-right: 2px solid black; background: url('<?php echo $thumbnail; ?>'); background-size: 100% 100%;" class="vidthumb"> </div>

					<div class="vidtext"><br /><span id="title<?php echo $counter; ?>" style="font-size: 22px;"><?php echo $title; ?></span><span id="otherstuff<?php echo $counter; ?>"> <p></p> <b>uploaded:</b> <?php echo substr($date,0,10); ?> <b> views: </b> <?php echo $views; ?><br /><span style="" ><?php echo substr($description,0,218); ?>...</span></span></div>
					</div>

					</a>
					</div>
					<br>

			<?php
		}
		$counter++;
	}
}

?>