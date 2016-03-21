 <?php        
        
        //Varibles for connecting to the database NEED TO BE CHANGED TO SUIT CONFIG
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "login";

        // DEFAULT VARIBLES COMPANY ID AND TEAM ID NEEDS TO BE CHANGED 
        $company_id = 1;
        $teamid = 1;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        //BURNOUT SQL QUERY Takes the avg burnout score from the burnout table and saves it as an array
        //SQL QUERY 
        $sql_burnout = "SELECT avg(burnout_score) AS avg_burnout, date_created_at FROM burnout_score WHERE company_id = '". $company_id. "' AND team_id ='". $teamid. "' AND date_created_at BETWEEN CURDATE() - INTERVAL 35 DAY AND CURDATE() GROUP BY DATE_FORMAT(date_created_at,'%d-%m-%Y')";
        //Sets the result of the SQL query into a varible
        $result_burnout = $conn->query($sql_burnout);
        $burnout = array();

        //Fetches sql result and stores it in an array.
        $burnout = mysqli_fetch_all( $result_burnout, MYSQLI_ASSOC);
        
        //FULFILMENT SQL QUERY Takes the avg fulfilment score from the fulfilment table and saves it as an array
        //SQL QUERY
        $sql_fulfilment = "SELECT avg(fulfilment_score) AS avg_fulfilment, date_created_at FROM fulfilment_score WHERE company_id = '". $company_id. "' AND team_id ='". $teamid. "' AND date_created_at BETWEEN CURDATE() - INTERVAL 35 DAY AND CURDATE() GROUP BY DATE_FORMAT(date_created_at,'%d-%m-%Y')";
        //Sets the result of the SQL query into a varible
        $result_fulfilment = $conn->query($sql_fulfilment);
        $fulfilment = array();

        //Fetches sql result and stores it in an array.
        $fulfilment = mysqli_fetch_all( $result_fulfilment, MYSQLI_ASSOC);

        //BRAND SQL QUERY Takes the avg brand score from the burnout table and saves it as an array
        //SQL QUERY
        $sql_brand = "SELECT avg(brand_score) AS avg_brand, date_created_at FROM brand_score WHERE company_id = '". $company_id. "'  AND team_id ='". $teamid. "'  AND date_created_at BETWEEN CURDATE() - INTERVAL 35 DAY AND CURDATE() GROUP BY DATE_FORMAT(date_created_at,'%d-%m-%Y')";
        //Sets the result of the SQL query into a varible
        $result_brand = $conn->query($sql_brand);
        $brand = array();

        //Fetches sql result and stores it in an array.
        header('Content-Type: application/json');
        $brand = mysqli_fetch_all( $result_brand, MYSQLI_ASSOC);

       
        
        //MERGES ALL result_ARRAYS INTO ONE JSON variable
        $result = array_merge($burnout, $fulfilment, $brand);
        $result_json = json_encode($result);
       
        
       //CLOSES CONN
        $conn->close();

?>S