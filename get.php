<?php
	
	ini_set("memory_limit", "1000M");
	$post = json_decode(file_get_contents('php://input'), 1);

	if(!empty($post) || !empty($_GET['prre']))
	{
	    include "config.php";

	    $custom = $post['custom'];

		$ads = [];
		if(file_exists("update.txt")) $ads = json_decode(file_get_contents("update.txt"), 1);
    
		if(count($ads) > 0)
		{
			$newAds = [[
				"uid",
				"url",
				"deal_type",
				"realestate_type",
				"site",
				"broker",
				"phone_number",
				"address",
				"coordinates",
				"price",

				"currency",
				"description",
				"condition",
				"from_owner",
				"images",
				"reserved_1",
				"reserved_2",
				"reserved_3",
				"reserved_4",
				"reserved_5",

				"reserved_6",
				"reserved_7",
				"reserved_8",
				"reserved_9",
				"reserved_10",
				"reserved_11",
				"attr_garage_type",
				"attr_house_build_type",
				"attr_sharehouse_build_type",
				"attr_total_area",

				"attr_living_space",
				"attr_kitchen_area",
				"attr_plot_ground_area",
				"attr_share_houses_ground_area",
				"attr_house_ground_area",
				"attr_sharehouse_rooms",
				"attr_house_rooms",
				"attr_rooms",
				"attr_floor",
				"attr_total_floors",

				"attr_business_type",
				"attr_wc_house",
				"attr_build_material",
				"attr_with_furniture",
				"attr_passenger_lifts",
				"attr_cargo_lifts",
				"attr_seiling_height",
				"attr_fire_extinguishing_system",
				"attr_water_supply",
				"attr_alarm_system",

				"attr_lighting",
				"attr_electricity",
				"attr_sewerage",
				"attr_heating",
				"attr_garbage_chute",
				"attr_loggias",
				"attr_balconies",
				"attr_plot_detail_plans",
				"attr_energy_efficiency_class",
				"attr_cadastral",
				"attr_built_year",
				"attr_сommunal_payments"
			]];
		    
		    $forNum = 0;
		    foreach($ads as $ad)
		    {
		    	$newImgs = "";
		    	for($i = 1; $i < 6; $i++)
		    	{
		    		$img = "imgs/".$ad["oid"]."-".$i.".jpeg";
		    		if(file_exists($img))
		    		{
		    			$newImgs .= $botUrl.$img."\n";
		    		}
		    	}
		    	// $adImg = getArr($ad['images']);
		    	// $newImgs = "";
		    	// foreach($adImg as $img)
		    	// {
		    	// 	$newImgs .= "https://cdn.esoft.digital/12801024".$img."\n";
		    	// 	$newImgs .= $img."\n";
		    	// }
		    	// $newImgs = preg_replace("/\n$/", "", $newImgs);
		    	//$ad["phone_number"] = "+".$ad["phone_number"];
		    	$ad["uid"] = preg_replace("/bel/", "msk", $ad["uid"]);
				$newAds[] = [
					$ad["uid"], $ad["url"], $ad["deal_type"], $ad["realestate_type"], $ad["site"], $ad["broker"], $ad["phone_number"], $ad["address"], $ad["coordinates"], $ad["price"], $ad["currency"], $ad["description"], $ad["condition"], $ad["from_owner"], $newImgs, $ad["reserved_1"], $ad["reserved_2"], $ad["reserved_3"], $ad["reserved_4"], $ad["reserved_5"], $ad["reserved_6"], $ad["reserved_7"], $ad["reserved_8"], $ad["reserved_9"], $ad["reserved_10"], $ad["reserved_11"], $ad["attr_garage_type"], $ad["attr_house_build_type"], $ad["attr_sharehouse_build_type"], $ad["attr_total_area"], $ad["attr_living_space"], $ad["attr_kitchen_area"], $ad["attr_plot_ground_area"], $ad["attr_share_houses_ground_area"], $ad["attr_house_ground_area"], $ad["attr_sharehouse_rooms"], $ad["attr_house_rooms"], $ad["attr_rooms"], $ad["attr_floor"], $ad["attr_total_floors"], $ad["attr_business_type"], $ad["attr_wc_house"], $ad["attr_build_material"], $ad["attr_with_furniture"], $ad["attr_passenger_lifts"], $ad["attr_cargo_lifts"], $ad["attr_seiling_height"], $ad["attr_fire_extinguishing_system"], $ad["attr_water_supply"], $ad["attr_alarm_system"], $ad["attr_lighting"], $ad["attr_electricity"], $ad["attr_sewerage"], $ad["attr_heating"], $ad["attr_garbage_chute"], $ad["attr_loggias"], $ad["attr_balconies"], $ad["attr_plot_detail_plans"], $ad["attr_energy_efficiency_class"], $ad["attr_cadastral"], $ad["attr_built_year"], $ad["attr_сommunal_payments"]
				];

				$forNum++;
		    }
		    
			$file = date("dmY_His").".csv";
			csv($newAds, $file);
			$resFile = $botUrl.$file;

			$json = [
				"event" => [
					"type" => "source",
					"object" => [
						"url" => $resFile
					]
				]
			];

			post($whUrl, $json);
		}
	}

?>