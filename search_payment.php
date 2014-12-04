<?php
       if (isset($_POST["_eventId_confirmation"])) { 
        
        require_once "lib/mercadopago.php";
    
        $clientid = $_SESSION['user'];
        $clientsecret = $_SESSION['pass'];
    
        $mp = new MP($clientid ,$clientsecret);
       
       $date1=implode("-",array_reverse(explode("/",$_POST['date1'])));;
       $date2=implode("-",array_reverse(explode("/",$_POST['date2'])));;
        
        $filters = array(
            "range" => "date_created",  
            "begin_date" => $date1 . "T00:00:00Z",
            "end_date" => $date2."T23:59:00Z"
        );
       
        
        // Search payment data according to filters
        $searchResult = $mp->search_payment($filters,0,1000);
        
        /* echo "<pre>";
        print_r($searchResult);
        echo "</pre>"; */
        
        // Show payment information
        ?>   
       
       <a href="#" class="export">Export Table</a>                
       <table class="ch-datagrid-controls" id="table_collections" >
            <tr>
            
              <th scope="col">Payment Id</th>
              <th scope="col">Order</th>
              <th scope="col">Date created</th>
              <th scope="col">Date approved</th>
              <th scope="col">Money release date</th>
              <th scope="col">Payer email</th>
              <th scope="col">Transaction amount</th>
              <th scope="col">Total paid amount</th>
              <th scope="col">Mercadopago fee</th>
              <th scope="col">Net received amount</th>
              <th scope="col">Finance fee</th>
              <th scope="col">Coupon amount</th>
              <th scope="col">Status</th>
              <th scope="col">Status detail</th>
              <th scope="col">Cardholder - name</th>
              <th scope="col">Cardholder -  number</th>
              <th scope="col">Last four digits</th>
              <th scope="col">Payment method</th>
              <th scope="col">Installments</th>

              
            
            </tr>
            <?php
            foreach ($searchResult["response"]["results"] as $payment) {
                ?>
                <tr>
                    <td><?php echo $payment["collection"]["id"]; ?></td>
                    <td><?php echo $payment["collection"]["external_reference"]; ?></td>
                    <td><?php echo formatdataout($payment["collection"]["date_created"]); ?></td>
                    <td><?php echo formatdataout($payment["collection"]["date_approved"]); ?></td>
                    <td><?php echo formatdataout($payment["collection"]["money_release_date"]); ?></td>
                    <td><?php echo $payment["collection"]["payer"]["email"]; ?></td>
                    <td><?php echo $payment["collection"]["transaction_amount"]; ?></td>
                    <td><?php echo $payment["collection"]["total_paid_amount"]; ?></td>
                    <td><?php echo $payment["collection"]["mercadopago_fee"]; ?></td>
                    <td><?php echo $payment["collection"]["net_received_amount"]; ?></td>
                    <td><?php echo $payment["collection"]["finance_fee"]; ?></td>
                    <td><?php echo $payment["collection"]["coupon_amount"]; ?></td>
                    <td><?php echo $payment["collection"]["status"]; ?></td>
                    <td><?php echo $payment["collection"]["status_detail"]; ?></td>
                    <td><?php echo $payment["collection"]["cardholder"]["name"]; ?></td>
                    <td><?php echo $payment["collection"]["cardholder"]["identification"]["number"]; ?></td>
                    <td><?php echo $payment["collection"]["last_four_digits"]; ?></td>
                    <td><?php echo $payment["collection"]["payment_method_id"]; ?></td>
                    <td><?php echo $payment["collection"]["installments"]; ?></td>

                    
                </tr>
                <?php
            }
            
            
       }
       
       
       function formatdataout($data){
              
             $time = substr($data,strrpos($data,"T"),strlen($data));
             $time = str_replace ("T", " ", $time);
             $time = substr($time,0,strrpos($time,"."));

             $data2= substr($data,0,strrpos($data,"T"));
              
             $data2 = implode("/",array_reverse(explode("-",$data2)));

             return $data2 . " " . $time ;
              
              
              
       }
       
       
       
       
       
       
       
       
            ?>
    
            
        </table>
