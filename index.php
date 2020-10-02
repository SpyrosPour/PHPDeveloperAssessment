<html>
    <head>
        <meta charset="UTF-8">
        <title>Weather</title>
        <style>
            body {
                background-color: #cfdaff;
            }        
            
            h2 {
                color: #313d63;
            }
            table, td {
                background-color: white;
                border: 1px solid #313d63;                
                text-align: center;
                color: #313d63;
            }
            
            button {
                color: #313d63;
            }
        </style>
    </head>
    
    <body>
        <form method="post">
            <h2>Enter City:</h2>
            <input type="text" id="cityName" name="cityName">
            <button name="btn" type="submit">Search</button><br>
        </form>        
        
        <?php
        if(isset($_POST['btn'])) {
            $city=filter_input(INPUT_POST, 'cityName', FILTER_SANITIZE_STRING);
            $ch = curl_init("http://api.weatherapi.com/v1/current.xml?key=510eb7be47904818b8a174646202809&q=$city");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if (!$data || $httpCode >= 400) { ?>
                <p>Could not find results for the specified city, please try again.</p>
                <?php
            }
            else {          
                
                $xml = new SimpleXMLElement($data);
                $name = $xml->location->name;
                $region = $xml->location->region;
                $country = $xml->location->country;
                $time = $xml->location->localtime;
                $temp = $xml->current->temp_c;
                $condition = $xml->current->condition->text;
                ?>
                <table>
                    <tr>
                        <td><strong>Name</strong></td><td> <?php echo $name?></td>
                    </tr>
                    <tr>
                        <td><strong>Region</strong></td><td><?php echo $region?></td>
                    </tr>
                    <tr>
                        <td><strong>Country</strong></td><td><?php echo $country?></td>
                    </tr>
                    <tr>
                        <td><strong>Local Time</strong></td><td><?php echo $time?></td>
                    </tr>
                    <tr>
                        <td><strong>Current Temperature</strong></td><td><?php echo $temp?></td>
                    </tr>
                    <tr>
                        <td><strong>Condition</strong></td><td><?php echo $condition?></td>
                    </tr>                    
                </table>
                <?php
            }
        }		
        ?>

    </body>
</html>