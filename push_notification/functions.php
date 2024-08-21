<?php

	function FCM($uniqueId, $title, $message, $bigImage, $link, $postId, $fcmServerKey, $fcmNotificationTopic) {

		$data = array(
			'to' => '/topics/' . $fcmNotificationTopic,
			'data' => array(
				'title' => $title,
				'message' => $message,
				'big_image' => $bigImage,
				'link' => $link,
				'post_id' => $postId,
				"unique_id"=> $uniqueId
			)
		);

		$header = array(
			'Authorization: key=' . $fcmServerKey,
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);

		if (curl_errno($ch)) {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}

		curl_close($ch);

		$_SESSION['msg'] = "FCM push notification sent...";
		header('Location:index.php');
		exit; 

	}

	function ONESIGNAL($uniqueId, $title, $message, $bigImage, $link, $postId, $oneSignalAppId, $oneSignalRestApiKey) {

		$content = array("en" =>  $message);

		$fields = array(
			'app_id' => $oneSignalAppId,
			'included_segments' => array('All'),                                            
			'data' => array(
				"foo" => "bar",
				"link" => $link,
				"post_id" => $postId,
				"unique_id" => $uniqueId
			),
			'headings'=> array("en" => $title),
			'contents' => $content,
			'big_picture' => $bigImage,     
			'url' => $link
		);

		$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic '. $oneSignalRestApiKey));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		$_SESSION['msg'] = "OneSignal push notification sent...";
		header('Location:index.php');
		exit;       

	}

?>
