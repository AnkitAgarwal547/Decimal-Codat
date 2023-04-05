<?php

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
        return $response;
    
    }

    function getPayments($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/payments?page=1&pageSize=1";
       
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        return $response;

    }

    function getCodatPurchaseOrder($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/purchaseOrders?page=1&pageSize=1";
       
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        return $response;

    
    } 

    function getCodatBills($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/bills?page=1&pageSize=1";
        
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        return $response;

    }

    function getCodatBillpayment($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/billPayments?page=1&pageSize=1";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        return $response;

    } 

    function getCodatTax_Rates($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/taxRates?page=1&pageSize=1";
        
        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        return $response;
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
        return $response;
    }

    function getCodatAccountingCompany($codat_client_id)
    {

        $uri = "/companies/".$codat_client_id."/data/info";

        $codatObject = new CODAT;
        $response = $codatObject->CODATProcessApi($uri, 'GET');
        return $response;

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
        return $response;

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
        return $response;

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
        return $response;

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
        return $response;

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
        return $response;

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

        return $response;                                                                  
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

        return $response;                                                
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

?>