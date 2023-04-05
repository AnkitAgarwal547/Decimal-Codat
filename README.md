
# Codat Integration in PHP

A brief description of Codat Integration in PHP






## Description of Repository

This repository contains code for extracting data using the Codat API's, using the cURL. Here are the details of how the code works:



## Usage


The code can be used for the following operations:

1. Create Account: The code create the account in codat.

2. Check Company Status: The code check the status of the company.

3. Get Invoices: The code get the invoices.

4. Get Payments: The code get the Payments.

5. Get Purchase Orders: The code get the Purchase Orders.

6. Get Bills: The code get the Bills.

7. Get billPayments: The code get the BillPayments.

8. Get Tax Rates: The code get the Tax Rates.

9. Get Account Transactions: The code get the Account Transactions.

10. Get Company Data: The code get the company info.

11. Get Commerce Orders: The code get the Commerce Orders.

12. Get Commerce Payments: The code get the Commerce Payments.

13. Get Commerce Products: The code get the Commerce Products.

14. Get Commerce Transactions: The code get the Commerce Transactions.

15. Get Commerce Location: The code get the Commerce Location.

16. Get Enhanced Profit And Loss: The code get the Enhanced Profit And Loss.

17. Get Enhanced Balance Sheet: The code get the Enhanced Balance Sheet.

18. Get Assess Commerce Data: The code get the Assess Commerce Data.

19. Get Assess Marketing Data: The code get the Assess Marketing Data.

20. Export Data: The code Export the data.

21. Export Audit Data: The code Export Audit Data.


Codat Integration
This repository contains code for extracting data using the Codat API's, using the cURL. The code performs the following operations:

Usage
The code can be used for the following operations:

Create Account: The code create the account in codat.

Check Company Status: The code check the status of the company.

Get Invoices: The code get the invoices.

Get Payments: The code get the Payments.

Get Purchase Orders: The code get the Purchase Orders.

Get Bills: The code get the Bills.

Get billPayments: The code get the BillPayments.

Get Tax Rates: The code get the Tax Rates.

Get Account Transactions: The code get the Account Transactions.

Get Company Data: The code get the company info.

Get Commerce Orders: The code get the Commerce Orders.

Get Commerce Payments: The code get the Commerce Payments.

Get Commerce Products: The code get the Commerce Products.

Get Commerce Transactions: The code get the Commerce Transactions.

Get Commerce Location: The code get the Commerce Location.

Get Enhanced Profit And Loss: The code get the Enhanced Profit And Loss.

Get Enhanced Balance Sheet: The code get the Enhanced Balance Sheet.

Get Assess Commerce Data: The code get the Assess Commerce Data.

Get Assess Marketing Data: The code get the Assess Marketing Data.

Export Data: The code Export the data.

Export Audit Data: The code Export Audit Data.


## Procedure
The following is the procedure followed by the code:

1. Create a class: The code uses the cURL to get the data from the api. By creating class and its function we can call according to our need and don't repeat the code.

2. Create a function to get the particular api data: The code extracts the data according to the api end point.

## Implementation

## Codat.php
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


## CodatMaster.php
    require 'Codat.php';

    function createCodatAccount($data,$uri)
    {    
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri,"POST",$data);
			
        $codat_client_id = $response['data']['id'];
    }

    function checkStatus($codat_client_id)
    {

        //extracting the status of the codat client ID
        $uri = "/companies/$codat_client_id";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri,"GET");

        if($response['success'] == true)
        {
            if(!array_key_exists("results",$response['data'])){
                if ($response['data']['dataConnections'][0]['status'] === "Linked" ){
                    return array('success' => 'true','code' => 200, 'status' => $response['data']['dataConnections'][0]['status'], 'message' => 'Status Updated to Linked','data'=> $response['data']);
                }
            }else
            {
                return array('success' => 'true','code' => 200, 'status' => $response['data']['results'][0]['dataConnections'][0]['status'], 'message' => 'Status Confirmed as Pending','data'=> $response['data']);
            }
        }
    }

    function getInvoices($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/invoices?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);
    
    }

    function getPayments($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/payments?page=1&pageSize=1";
       
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    }

    function getCodatPurchaseOrder($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/purchaseOrders?page=1&pageSize=1";
       
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    
    } 

    function getCodatBills($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/bills?page=1&pageSize=1";
        
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    }

    function getCodatBillpayment($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/billPayments?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    } 

    function getCodatTax_Rates($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/taxRates?page=1&pageSize=1";
        
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);
    }

    function getCodatAccount_transactions($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');

        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Accounting"){
                $connection_id = $a['id'];
            }
        }
        

        $uri = "/companies/".$codat_client_id."/connections/".$connection_id."/data/accountTransactions?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);
    }

    function getCodatAccountingCompany($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/info";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    }

    function getCommerce_Orders($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Commerce"){
                $connection_id = $a['id'];
            }
        }
        

        $uri = "/companies/".$codat_client_id."/connections/".$connection_id."/data/commerce-orders?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    } 

    function getCommerce_Payments($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Commerce"){
                $connection_id = $a['id'];
            }
        }
        

        $uri = "/companies/".$codat_client_id."/connections/".$connection_id."/data/commerce-payments?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    }

    function getCommerce_Products($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Commerce"){
                $connection_id = $a['id'];
            }
        }
        

        $uri = "/companies/".$codat_client_id."/connections/".$connection_id."/data/commerce-products?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    } 

    function getCommerce_Transactions($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Commerce"){
                $connection_id = $a['id'];
            }
        }
        

        $uri = "/companies/".$codat_client_id."/connections/".$connection_id."/data/commerce-transactions?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    } 

    function getCommerce_Location($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Commerce"){
                $connection_id = $a['id'];
            }
        }

        $uri = "/companies/".$codat_client_id."/connections/".$connection_id."/data/commerce-locations?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        print_r($response);

    } 

    function getCodatAccessprofit_loss_data($codat_client_id, $periodLength, $periodsToCompare, $startMonth)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Accounting"){
                $connection_id = $a['id'];
            }
        }

        $uri = "/data/companies/".$codat_client_id."/connections/".$connection_id."/assess/enhancedProfitAndLoss?reportDate=$startMonth&periodLength=$periodLength&numberOfPeriods=$periodsToCompare&includeDisplayNames=true&showInputValues=true";

        
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');

        print_r($response);                                                                  
    }

    function getCodatassess_commerce_data($codat_client_id, $startMonth, $endMonth,$periodsToCompare)
    {

        $uri = "/companies/".$codat_client_id."/connections";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');

        foreach($response['data']['results'] as $a){
            if($a['sourceType'] == "Commerce"){
                $connection_id = $a['id'];
            }
        }


        $uri = "/data/companies/".$codat_client_id."/connections/".$connection_id."/assess/commerceMetrics/revenue?reportDate=$endMonth&periodLength=1&numberOfPeriods=$periodsToCompare&periodUnit=Month&includeDisplayNames=true";

        
        
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');

        print_r($response);                                                
    }

    function startCodatExportData($codat_client_id)
    {

        $uri ="/companies/".$codat_client_id."/data/excel";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'POST');
        echo json_encode($response);
    }

    function exportAuditData($codat_client_id){

        $uri ="/data/companies/".$codat_client_id."/assess/excel?reportType=audit";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'POST');
        echo json_encode($response);
    }
