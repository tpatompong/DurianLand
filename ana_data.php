<?php 
    $user_id = $_SESSION['user_login'];
        $sql = "SELECT * FROM activity WHERE id = $user_id ORDER BY atv_date DESC LIMIT 5";
        $query = $conn->query($sql);
        $stmt1 = $conn->prepare("SELECT st_per, en_per FROM per WHERE id = :user_id AND cur_per = '1'");
        $stmt1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1->execute();
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $exp = "SELECT SUM(money) FROM activity WHERE id = :user_id 
                AND add_type NOT IN ('ขายผลผลิต', 'อื่นๆ')";          
        $add = "SELECT SUM(money) FROM activity WHERE id = :user_id 
                AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')";                      

        $stmt2_exp = $conn->prepare($exp);
        $stmt2_add = $conn->prepare($add);

        $stmt2_exp->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt2_add->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt2_exp->execute();
        $stmt2_add->execute();      
        if ($stmt1->rowCount() > 0) {

        // 2
            $chart_exp_query = "SELECT add_type, SUM(money) as total_money FROM activity WHERE id = :user_id
                    AND add_type NOT IN ('ขายผลผลิต', 'อื่นๆ') 
                    AND atv_date BETWEEN :st_per AND :en_per
                    GROUP BY add_type";

            $chart_add_query = "SELECT add_type, SUM(money) as total_money FROM activity WHERE id = :user_id
                                AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')
                                AND atv_date BETWEEN :st_per AND :en_per
                                GROUP BY add_type";
        
            $stmt_chart_exp = $conn->prepare($chart_exp_query);
            $stmt_chart_add = $conn->prepare($chart_add_query);
        
            $stmt_chart_exp->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt_chart_exp->bindParam(':st_per', $row['st_per']);
            $stmt_chart_exp->bindParam(':en_per', $row['en_per']);
            
            $stmt_chart_add->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt_chart_add->bindParam(':st_per', $row['st_per']);
            $stmt_chart_add->bindParam(':en_per', $row['en_per']);
            
            $stmt_chart_exp->execute();
            $stmt_chart_add->execute();
           
            $chart_exp_data = $stmt_chart_exp->fetchAll(PDO::FETCH_ASSOC);
            $chart_add_data = $stmt_chart_add->fetchAll(PDO::FETCH_ASSOC);

         } else {
            $exp = "SELECT SUM(money) FROM activity WHERE id = :user_id 
                    AND add_type NOT IN ('ขายผลผลิต', 'อื่นๆ')";
            $add = "SELECT SUM(money) FROM activity WHERE id = :user_id 
                    AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')";
                
            $stmt2_exp = $conn->prepare($exp);
            $stmt2_add = $conn->prepare($add);

            $stmt2_exp->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt2_add->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            //
            $chart_exp_query = "SELECT add_type, SUM(money) as total_money FROM activity WHERE id = :user_id
            AND add_type NOT IN ('ขายผลผลิต', 'อื่นๆ') GROUP BY add_type";

            $chart_add_query = "SELECT add_type, SUM(money) as total_money FROM activity WHERE id = :user_id
                                AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ') GROUP BY add_type";
                
            $stmt3_exp = $conn->prepare($chart_exp_query);
            $stmt3_add = $conn->prepare($chart_add_query);

            $stmt3_exp->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt3_add->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        }  
        $stac = $conn->prepare("SELECT * FROM activity WHERE id = :user_id  AND add_type NOT IN ('ขายผลผลิต', 'อื่นๆ')");
        $stac->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stac->execute();

        $stac2 = $conn->prepare("SELECT * FROM activity WHERE id = :user_id  AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')");
        $stac2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stac2->execute();
        if ($stac->rowCount() > 0 && $stac2->rowCount() > 0){               
        $expc = "SELECT SUM(money) FROM activity WHERE id = :user_id 
                AND add_type NOT IN ('ขายผลผลิต', 'อื่นๆ') 
                AND YEAR(atv_date) = YEAR(CURDATE());";
        $addc = "SELECT SUM(money) FROM activity WHERE id = :user_id 
                AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')
                AND YEAR(atv_date) = YEAR(CURDATE());";
        $stmt1_expc = $conn->prepare($expc);
        $stmt1_addc = $conn->prepare($addc);
        $stmt1_expc->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1_addc->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1_expc->execute();
        $stmt1_addc->execute();
        $sumexpc = $stmt1_expc->fetchColumn();
        $sumaddc = $stmt1_addc->fetchColumn();
        $sumc = $sumaddc - $sumexpc;
        $stmt2_exp->execute();
        $stmt2_add->execute();
        $sumexp = $stmt2_exp->fetchColumn();
        $sumadd = $stmt2_add->fetchColumn();
        $sum = $sumadd - $sumexp;           
        $cc = $conn->prepare("SELECT st_per, en_per FROM per WHERE id = :user_id AND cur_per = '1'");
        $cc->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $cc->execute();
        $add_p = ($sumaddc/$sumadd)*100;  
        $exp_p = ($sumexpc/$sumexp)*100; 
        $sum_p = ($sumc/$sum)*100;   
        }            
        else{
                $add_p = 0;  
                $exp_p = 0; 
                $sum_p = 0;   
        }
        global $sumexp, $sumadd, $sum ,$sumexpc ,$sumaddc,$sumc,$add_p, $exp_p, $sum_p ,$query;
        //for line chart
        $line_exp_query = "SELECT COALESCE(SUM(activity.money), 0) AS total_money,months.month 
        FROM (SELECT 1 AS month
                UNION SELECT 2
                UNION SELECT 3
                UNION SELECT 4
                UNION SELECT 5
                UNION SELECT 6
                UNION SELECT 7
                UNION SELECT 8
                UNION SELECT 9
                UNION SELECT 10
                UNION SELECT 11
                UNION SELECT 12) AS months
                LEFT JOIN activity ON months.month = MONTH(activity.atv_date) AND activity.id = $user_id AND activity.add_type 
                NOT IN ('ขายผลผลิต', 'อื่นๆ') AND YEAR(activity.atv_date) = YEAR(CURDATE()) GROUP BY months.month";

         $line_add_query = "SELECT COALESCE(SUM(activity.money), 0) AS total_money,months.month 
         FROM (SELECT 1 AS month
                 UNION SELECT 2
                 UNION SELECT 3
                 UNION SELECT 4
                 UNION SELECT 5
                 UNION SELECT 6
                 UNION SELECT 7
                 UNION SELECT 8
                 UNION SELECT 9
                 UNION SELECT 10
                 UNION SELECT 11
                 UNION SELECT 12) AS months
                 LEFT JOIN activity ON months.month = MONTH(activity.atv_date) AND activity.id = $user_id AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')
                AND YEAR(activity.atv_date) = YEAR(CURDATE()) GROUP BY months.month";

        $stmt_line_exp = $conn->prepare($line_exp_query);
        $stmt_line_add = $conn->prepare($line_add_query);
        $stmt_line_exp->execute();
        $stmt_line_add->execute();
        $line_exp_data = $stmt_line_exp->fetchAll(PDO::FETCH_ASSOC);
        $line_add_data = $stmt_line_add->fetchAll(PDO::FETCH_ASSOC);           
        //for line chart avg
        $line_exp_avg = "SELECT COALESCE(avg(activity.money), 0) AS total_money,months.month 
        FROM (SELECT 1 AS month
                UNION SELECT 2
                UNION SELECT 3
                UNION SELECT 4
                UNION SELECT 5
                UNION SELECT 6
                UNION SELECT 7
                UNION SELECT 8
                UNION SELECT 9
                UNION SELECT 10
                UNION SELECT 11
                UNION SELECT 12) AS months
                LEFT JOIN activity ON months.month = MONTH(activity.atv_date) AND activity.id = $user_id AND activity.add_type 
                NOT IN ('ขายผลผลิต', 'อื่นๆ') AND YEAR(activity.atv_date) != YEAR(CURDATE()) GROUP BY months.month";

         $line_add_avg = "SELECT COALESCE(avg(activity.money), 0) AS total_money,months.month 
         FROM (SELECT 1 AS month
                 UNION SELECT 2
                 UNION SELECT 3
                 UNION SELECT 4
                 UNION SELECT 5
                 UNION SELECT 6
                 UNION SELECT 7
                 UNION SELECT 8
                 UNION SELECT 9
                 UNION SELECT 10
                 UNION SELECT 11
                 UNION SELECT 12) AS months
                 LEFT JOIN activity ON months.month = MONTH(activity.atv_date) AND activity.id = $user_id AND (add_type = 'ขายผลผลิต' OR add_type = 'อื่นๆ')
                AND YEAR(activity.atv_date) != YEAR(CURDATE()) GROUP BY months.month";

        $avg_line_exp = $conn->prepare($line_exp_avg);
        $avg_line_add = $conn->prepare($line_add_avg);
        $avg_line_exp->execute();
        $avg_line_add->execute();
        $avg_expdata = $avg_line_exp->fetchAll(PDO::FETCH_ASSOC);
        $avg_adddata = $avg_line_add->fetchAll(PDO::FETCH_ASSOC);           
        //end line chart

        //for check >avg
        $result_exp_greater_than_avg = [];
        $result_add_greater_than_avg = [];
        $exp_greater_values = [];  
        $add_greater_values = [];  

        $month_names = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม',
        ];

        foreach ($line_exp_data as $exp_row) {
        $month = $exp_row['month'];
        $exp_value = $exp_row['total_money'];
        $avg_value = 0; 

        foreach ($avg_expdata as $avg_row) {
                if ($avg_row['month'] == $month) {
                $avg_value = $avg_row['total_money'];
                break;
                }
        }

        if ($exp_value > $avg_value) {
                $result_exp_greater_than_avg[] = [
                'month' => $month,
                'exp_value' => $exp_value,
                'avg_value' => $avg_value,
                ];
                $month_name = $month_names[$month];
                
                $exp_greater_values[] = $month_name;
        }
        }
        foreach ($line_add_data as $add_row) {
                $month = $add_row['month'];
                $add_value = $add_row['total_money'];
                $avg_value = 0; 
        
                foreach ($avg_adddata as $add_row) {
                        if ($add_row['month'] == $month) {
                        $avg_value = $avg_row['total_money'];
                        break;
                        }
                }
        
                if ($add_value > $avg_value) {
                        $result_add_greater_than_avg[] = [
                        'month' => $month,
                        'add_value' => $add_value,
                        'avg_value' => $add_value,
                        ];
        
                        $month_name = $month_names[$month];
                        
                        $add_greater_values[] = $month_name;
                }
                }
        //for bar chart
        $bar_exp_query = "SELECT CONCAT(p.st_per, ' ถึง ', p.en_per) AS period, SUM(a.money) AS total_sales 
                        FROM per p 
                        JOIN activity a ON a.atv_date BETWEEN p.st_per AND p.en_per 
                        WHERE p.id = :user_id AND a.add_type NOT IN ('ขายผลผลิต', 'อื่นๆ') 
                        GROUP BY period";

        $bar_add_query = "SELECT CONCAT(p.st_per, ' ถึง ', p.en_per) AS period, SUM(a.money) AS total_sales 
                FROM per p 
                JOIN activity a ON a.atv_date BETWEEN p.st_per AND p.en_per 
                WHERE p.id = :user_id AND (a.add_type = 'ขายผลผลิต' OR a.add_type = 'อื่นๆ')
                GROUP BY period";

        $stmt_bar_exp = $conn->prepare($bar_exp_query);
        $stmt_bar_add = $conn->prepare($bar_add_query);

        $stmt_bar_exp->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_bar_add->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt_bar_exp->execute();
        $stmt_bar_add->execute();

        $bar_exp_data = $stmt_bar_exp->fetchAll(PDO::FETCH_ASSOC);
        $bar_add_data = $stmt_bar_add->fetchAll(PDO::FETCH_ASSOC);

?>