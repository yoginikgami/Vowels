<?php 
session_start();
include_once 'connection.php';
    if(isset($_POST['salesPorfolio'])){
        // $date = $_POST['date_range'];
        // $end_date = date("Y-m-d", strtotime("-$date days"));
        // $start_date = date("Y-m-d");
        $portfolio = implode(',',$_POST['salesPorfolio']);
        $portfolioArray = explode(',', $portfolio);
        // print_r($portfolioArray);
        $fetch_portfolio_subscriber = ""; ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
        google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(salesGraphq);

      function salesGraphq() {
        var data = google.visualization.arrayToDataTable([
                  ['Date', 'Total Sales'],
        <?php

        $fetch_portfolio_subscriber .= "SELECT dates, SUM(sales) AS total_income
            FROM (";
        
        
         if (in_array("trade_mark", $portfolioArray)){
            //  echo 'Helloooooo';
            if ($fetch_portfolio_subscriber != "") {
              $fetch_portfolio_subscriber .= " UNION ALL";
            }
            $fetch_portfolio_subscriber .= "(SELECT DATE_FORMAT (date_application, '%Y-%M-%d') AS dates,sum(`bill_amt`) as sales FROM `trade_mark` WHERE `company_id` = '".$_SESSION['company_id']."' AND (date_application) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) group by dates)";
        }
        if (in_array("copy_right", $portfolioArray)){
            //  echo 'Helloooooo';
            if ($fetch_portfolio_subscriber != "") {
              $fetch_portfolio_subscriber .= " UNION ALL";
            }
            $fetch_portfolio_subscriber .= "(SELECT DATE_FORMAT (filling_date, '%Y-%M-%d') AS dates,sum(`billing_amount`) as sales FROM `copy_right` WHERE `company_id` = '".$_SESSION['company_id']."' AND (filling_date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) group by dates)";
        }
        if (in_array("patent", $portfolioArray)){
            //  echo 'Helloooooo';
            if ($fetch_portfolio_subscriber != "") {
              $fetch_portfolio_subscriber .= " UNION ALL";
            }
            $fetch_portfolio_subscriber .= "(SELECT DATE_FORMAT (filling_date, '%Y-%M-%d') AS dates,sum(`billing_amount`) as sales FROM `patent` WHERE `company_id` = '".$_SESSION['company_id']."' AND (filling_date) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) group by dates)";
        }
        if (in_array("trade_secret", $portfolioArray)){
            //  echo 'Helloooooo';
            if ($fetch_portfolio_subscriber != "") {
              $fetch_portfolio_subscriber .= " UNION ALL";
            }
            $fetch_portfolio_subscriber .= "(SELECT DATE_FORMAT (date_of_filling, '%Y-%M-%d') AS dates,sum(`billing_amount`) as sales FROM `trade_secret` WHERE `company_id` = '".$_SESSION['company_id']."' AND (date_of_filling) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) group by dates)";
        }
        if (in_array("industrial_design", $portfolioArray)){
            //  echo 'Helloooooo';
            if ($fetch_portfolio_subscriber != "") {
              $fetch_portfolio_subscriber .= " UNION ALL";
            }
            $fetch_portfolio_subscriber .= "(SELECT DATE_FORMAT(STR_TO_DATE(application_filling, '%Y-%b-%d'), '%Y-%m-%d') AS dates, 
                                  SUM(`billing_amount`) AS sales 
                                  FROM `industrial_design` 
                                  WHERE `company_id` = '".$_SESSION['company_id']."' 
                                  AND (STR_TO_DATE(application_filling, '%Y-%b-%d') >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                                  GROUP BY dates)";

        }
        
        if (in_array("sales", $portfolioArray)){
            if ($fetch_portfolio_subscriber != "") {
              $fetch_portfolio_subscriber .= " UNION ALL";
            }
            $fetch_portfolio_subscriber .= "(SELECT DATE_FORMAT(STR_TO_DATE(date, '%Y-%M-%d'), '%Y-%m-%d') AS dates,sum(`billing_amount`) as sales FROM `sales` WHERE `company_id` = '".$_SESSION['company_id']."' AND (STR_TO_DATE(date, '%Y-%M-%d') >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) group by dates)";
        }
        $fetch_portfolio_subscriber.= ") AS CombinedData GROUP BY dates ORDER BY dates ASC";
        $fromPos = stripos($fetch_portfolio_subscriber, 'FROM');
        
        // If FROM is found and UNION ALL appears within 10 characters after it, remove UNION ALL
        if ($fromPos !== false) {
            $unionPos = stripos($fetch_portfolio_subscriber, 'UNION ALL', $fromPos);
            if ($unionPos !== false && $unionPos - $fromPos <= 10) {
                $fetch_portfolio_subscriber = substr_replace($fetch_portfolio_subscriber, '', $unionPos, strlen('UNION ALL'));
            }
        }
        $row_11 = mysqli_query($con,$fetch_portfolio_subscriber);
        $data = array();

        // Fetch rows and add them to the data array
        while ($row = mysqli_fetch_assoc($row_11)) {
            $dates = $row['dates'];
            $sales = $row['total_income']; ?>
        
    ['<?php echo $dates; ?>', <?php echo $sales; ?>],
            <?php } ?>
        ]);
    var options = {
        //   title: '',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('sales_material'));

        chart.draw(data, options);

        // var chart = new google.charts.Bar(document.getElementById('sales_material'));
        // chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    </script>
    <?php } ?>