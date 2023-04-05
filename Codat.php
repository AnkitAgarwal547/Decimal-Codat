<?php

class CODAT
{
    private $api_url = 'https://api.codat.io';

    private $header = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Basic #############################################'
    );

    public function CODATProcessApi($uri, $method, $data = null)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_url . $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $this->header,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);


        if ($err) {
            return array('success' => "false", 'message' => "cURL Error #:" . $err);
        } else {

            return $this->processCpResponse(json_decode($response, true), $responseCode);

        }
    }

    public function processCpResponse($responseData, int $responseCode)
    {
        $issueCodes = 'Server Error';
        $outcome = 'Something Went Wrong!!';


        if (is_array($responseData)) {
            if ($responseCode == 200) {

                return array('success' => 'true', 'code' => $responseCode, 'data' => $responseData);
            } else {

                return array('success' => 'false', 'code' => $responseCode, 'message' => ($responseData['error'] ?? $responseData['type'] ?? $outcome));
            }
        }

        return array('success' => 'false', 'code' => 500, 'message' => $outcome . ' - ' . $issueCodes);
    }
}

?>