<?php
	include "config.php";
	
	$allIds = json_decode(file_get_contents("allIds.txt"), 1);

	if(!empty($allIds))
	{
		if(!file_exists("checkedIds.txt")) file_put_contents("checkedIds.txt", "");

		$chIds = getArr(file_get_contents("checkedIds.txt"));

		$is = false;
		foreach($allIds as $aId)
		{
			if(!in_array($aId, $chIds))
			{
				// if(preg_match("/-1$/", $aId))
				// {
					$is = true;
					echo $aId;
					$chIds[] = $aId;
					file_put_contents("checkedIds.txt", implode("\n", $chIds));
					break;
				// }
			}
		}

		if(!$is)
		{
			// file_put_contents("checkedIds.txt", "");
		}
	}

?>