<html>
    <head>
        <meta charset="UTF-8">
        <title>Stock Trade Analytics</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!--Date Picker-->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    </head>
    <body cz-shortcut-listen="true" data-new-gr-c-s-check-loaded="14.1085.0" data-gr-ext-installed="">

        <!-- START - Header -->
        <!-- END - Header -->

        <!-- START - Body -->
        <?php
        require 'db_connection.php';
        ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="stocks_csv" id="stocks_csv">
            <input type="submit" value="Upload CSV" name="submit">
        </form>
        <div class="filter_div">
            <h2>Filter</h2>
            <?php
            $result = $conn->query("SELECT * FROM stock_rates");
            $unique_arr = array();
            ?>
            <form action="#" method="post" enctype="multipart/form-data">
                <select id="stock_select" name="stock_select">
                    <?php
                    while ($row = $result->fetch_assoc()) {

                        if (!in_array($row['stock_name'], $unique_arr)) {
                            ?>
                            <option name="<?php echo $row['stock_name']; ?>"><?php echo $row['stock_name']; ?></option>
                            <?php
                            $unique_arr[$row['stock_name']] = $row['stock_name'];
                        }
                    }
                    ?>  
                </select>

                <input type="input" class="start_date date_input" name="start_date" placeholder="Select Start Date" />
                <input type="input" class="end_date date_input" name="end_date" placeholder="Select End Date" />

                <input type="submit" value="Filter" name="filter">
            </form>

        </div>

        <?php
        if(isset($_POST['start_date']) && !empty($_POST['start_date'])) {
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));

        $sql_price = $conn->query("SELECT min(stock_price) min,  max(stock_price) max FROM stock_rates WHERE 1 = 1 AND (date BETWEEN '{$start_date}' AND '{$end_date}') AND stock_name LIKE '{$_POST['stock_select']}';");
        $row_price = $sql_price->fetch_assoc();

        $min = $row_price['min'];
        $max = $row_price['max'];

        $stock_arr = array();
        $sql = $conn->query("SELECT * FROM stock_rates WHERE 1 = 1 AND (date BETWEEN '{$start_date}' AND '{$end_date}') AND stock_name LIKE '{$_POST['stock_select']}' ORDER BY date ASC;");

        $i = 0;

        $stock_price_max = $stock_price_min = $stock_buy = $stock_sell = $second_max = 0;
        $total_stock_price = 0;
        $sd_arr = array();
        while ($row = $sql->fetch_assoc()) {
            $stock_arr[$i] = $row;
            $sd_arr[$row['date']] = $row['stock_price'];

            if ($row['stock_price'] == $max) {
                $stock_price_max = $i;
            }
            if ($row['stock_price'] == $min) {
                $stock_price_min = $i;
            }
            //If it's greater than the value of max
            if ($row['stock_price'] > $max) {

                $second_max = $max;
            }

            //If array number is greater than secondMax and less than max
            if ($row['stock_price'] > $second_max && $row['stock_price'] < $max) {
                $second_max = $row;
            }

            $i++;
            $total_stock_price += $row['stock_price'];
        }

        if ($stock_price_max == 0) {
            //Bought Stock at the highest price, at loss
            $stock_buy = $stock_arr[$stock_price_max];
            $stock_sell = $second_max;
        } else if ($stock_price_max < $stock_price_min) {
            //Bought Stock at loss
            $stock_buy = $stock_arr[$stock_price_max];
            $stock_sell = $second_max;
            
        } else if ($stock_price_max > $stock_price_min) {
            //Bought Stock at profit

            $stock_buy = $stock_arr[$stock_price_min];
            $stock_sell = $stock_arr[$stock_price_max];
        } else {
            //Bought Stock at no profit/loss          
            $stock_buy = $stock_arr[$stock_price_min];
            $stock_sell = $stock_arr[$stock_price_max];
        }
        ?>
        <table border="1" style="margin: 20px 0;width: 100%" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>Buy On</th>
                    <th>Sell On</th>

                    <th>Profit</th>
                    <th>Mean Stock Price</th>
                    <th>Standard Deviation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($stock_buy['date'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($stock_sell['date'])); ?></td>

                    <td><?php echo $stock_sell['stock_price'] - $stock_buy['stock_price']; ?></td>
                    <td><?php echo $total_stock_price / count($stock_arr); ?></td>
                    <td><?php echo std_deviation($sd_arr); ?></td>
                </tr>
            </tbody>
        </table>
        <!-- END - Body -->

        <!-- START - Footer -->
        <!-- END - Footer -->
        <?php
        }

        function std_deviation($my_arr) {
            $no_element = count($my_arr);
            $var = 0.0;
            $avg = array_sum($my_arr) / $no_element;
            foreach ($my_arr as $i) {
                $var += pow(($i - $avg), 2);
            }
            $return = (float) sqrt($var / $no_element);
            return round($return, 3);
        }

        $result = $conn->query("SELECT min(date) min, max(date) max FROM stock_rates ORDER BY date ASC;");
        $row = $result->fetch_assoc();
        ?>
        <script>
            $(function () {
                $('#stock_select').select2({
                    placeholder: 'Select an option'
                });
                $(".start_date").datepicker({
                    dateFormat: "dd-mm-yy",
                    minDate: new Date(<?php echo date('Y, m-1, d', strtotime($row['min'])); ?>),
                    maxDate: new Date(<?php echo date('Y, m-1, d', strtotime($row['max'])); ?>),
                });
                $(".end_date").datepicker({
                    dateFormat: "dd-mm-yy",
                    minDate: new Date(<?php echo date('Y, m-1, d', strtotime($row['min'])); ?>),
                    maxDate: new Date(<?php echo date('Y, m-1, d', strtotime($row['max'])); ?>),
                });
            });
        </script>
    </body>
</html>