<?php

	include "config.php";

	$allIds = json_decode(file_get_contents('php://input'), 1);

	if(!empty($allIds))
	{
		$isIds = json_decode(file_get_contents("allIds.txt"), 1);

		$newIds = [];
		foreach($allIds as $id)
		{
			$newIds[] = $id['id']."-".$id['type'];
		}

		$delIds = [];
		foreach($isIds as $id)
		{
			if(!in_array($id, $newIds))
			{
				$delIds[] = $id;
			}
		}

		$nUrl = "";
		$json = [
			"event" => [
				"type" => "delete",
				"object" => [
					"uid" => ""
				]
			]
		];
		if(!empty($delIds))
		{
			foreach($delIds as $dId)
			{
				$dId = preg_replace("/-[0-9]+$/", "", $dId);
				$json['event']['object']['uid'] = "msk.etagi.com-".$dId;
				// post($whUrl, $json);
				file_put_contents("dels.txt", $dId."\n", FILE_APPEND);
			}
		}

		file_put_contents("allIds.txt", json_encode($newIds));
	}

?>