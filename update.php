<?php
	ini_set("memory_limit", "1000M");
	$item = json_decode(file_get_contents('php://input'), 1);

	function base64_to_img($base64_string, $output_file)
	{
		$output_file = "imgs/".$output_file;
	    $ifp = fopen($output_file, "wb");

	    $data = explode(',', $base64_string);

	    fwrite($ifp, base64_decode($data[1]));
	    fclose($ifp);

	    return $output_file;
	}

	if(!empty($item))
	{
		$items = [];
		if(file_exists("update.txt")) $items = json_decode(file_get_contents("update.txt"), 1);

		$newItems = [];
		if(count($items) > 0)
		{
			$isFor = false;
			foreach($items as $im)
			{
				if(!empty($im['images']))
				{
					$imgsArr = explode("\n|-|\n", $im['images']);

					if(count($imgsArr) > 0)
					{
						$forNum = 0;
						foreach($imgsArr as $img)
						{
							if(!empty($img))
							{
								echo $img;
								$forNum++;
								base64_to_img($img, $im['oid']."-".$forNum.".jpeg");
							}
						}
					}
				}

				$im['images'] = "";

				if($item['uid'] == $im['uid'])
				{
					$isFor = true;
					$newItems[] = $item;
					break;
				}
				else $newItems[] = $im;
			}
			if(!$isFor)
			{
				$newItems[] = $item;
			}
		}
		else $newItems = [$item];

		file_put_contents("update.txt", json_encode($newItems));
	}

?>