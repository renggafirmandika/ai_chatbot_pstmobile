<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        // Get the raw POST data
        $rawData = file_get_contents('php://input');
        $requestData = json_decode($rawData, true);
    
        // Extract the intent and parameters from Dialogflow request
        $intent = $requestData['queryResult']['action'];
        $parameters = $requestData['queryResult']['parameters'];
    
        // Your custom logic based on the intent and parameters
        // $fulfillmentText = handleIntent($intent, $parameters);
        $fulfillmentText = handleIntent($intent, $parameters);
    
        // Send the response back to Dialogflow
        $webhookResponse = [
            'fulfillmentText' => $fulfillmentText,
        ];
        // $responseData = [
        //     'fulfillmentMessages' => [$webhookResponse],
        // ];
    
        header('Content-Type: application/json');
        echo json_encode($webhookResponse);
        //error_log('Incoming Request: ' . $rawData);
    }
    
    function handleIntent($intent, $parameters) {
    // Implement your business logic here based on the intent and parameters
    // For example, you can switch on the intent and perform different actions

    switch ($intent) {
        case 'get.data':
            // Handle YourIntentName
            $data = $parameters['data'];
            $location = $parameters['location'];
            $tahun = $parameters['time'][0];
            $tahun = 122;
            $url = "https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/".$location."/var/1026/vervar/13/th/".$tahun."/key/d560dc954c0b8d1f71c2793d021d3f3d/";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($output, TRUE);
            $data = $response["datacontent"];
            $data = array_values($data);
            return $data[0];
            break;
        // Add more cases for other intents

        default:
            // Default response if the intent is not recognized
            return 'Sorry, I didn\'t understand that.';
    }
}
    
?>