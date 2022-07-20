<!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <style>
                * {
                    font-size: 15px;
                    font-family: "Arial";
                }
                
                .centered {
                    text-align: center;
                    align-content: center;
                }
                table, th, td {
                    border: 1px solid;
                    border-collapse: collapse;
                   
                  }
                .ticket {
                    width:108mm;
                    height:108mm;
                }
                .imu{ 
                    width:350px;
                }
                img {
                  display: block;
                  margin-left: auto;
                  margin-right: auto;
                }
                .ff{
                    margin-top: 7px;
                    font-size: 28px;
                    margin-bottom: 2px;
                }
                .kk{
                    margin-top: 4px;
                    margin-bottom: 2px;
                    font-size: 20px;
                }
                .address{
                    font-size: 19px;
                    margin-top: 2px;
                }
                
                @media print {
                    .hidden-print,
                    .hidden-print * {
                        display: none !important;
                    }
                    @page { margin: 5px 19px; }
                }
                </style>
            </head>
            <body onload="window.print()">
                <div class="ticket">
                    <table style="width:100%" style="background-color: aquamarine;">
                        <tr>
                            <td colspan="3" style="text-align:center;">
                                <img src="/assets/img/logo_se.jpg" class="imu">
                            </td>
                            
                        </tr>
                        <tr>
                            <td width="30%" ><b style="margin-left: 8px; ">LR No.</b></td>
                            <td colspan ="2" style="text-align:center;"><h3 class="ff">2345345678</h3></td>
                        </tr>
                        <tr>
                            <td width="30%"><b style="margin-left: 8px;">Order ID:</b></td>
                            <td colspan ="2" style="text-align:center;"><b>2345345-678647</b></td>
                        </tr>
                        <tr>
                            <td width="30%"><b style="margin-left: 8px;">Client:-</b></td>
                            <td colspan ="2" style="text-align:center;"><b>Nurture AG Farm </b></td>
                        </tr>
                        <tr>
                            <td width="30%"><b style="margin-left: 8px;">NO Of Boxes:</b></td>
                            <td colspan ="2" style="text-align:center;"><p style="font-size: 36px;margin: 1px;font-weight:bold;position: relative;top: 8px;">11<p></td>
                        </tr>
                        <tr>
                            <td width="30%" style="text-align:center;"><img src="/assets/img/barcode.png" style="width: 80px;"></td>
                            <td colspan ="2">
                                <div class="row" style="margin-left: 8px;">
                                <p  style="font-weight:bold">Ship to: <br/>Dharma Agro Chemicals Iffco center,Kamelpur Road,Dhanaura,XYZ Dummy Address</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                           <th>Delivery Station</th>
                           <th>Zone</th>
                           <th>PIN Code</th>
                        </tr>
                        <tr>
                            <td style="text-align:center;"><h3 class="kk">Amroha, Punjab India</h3></td>
                            <td style="text-align:center;"><h3 class="kk">UP-03</h3></td>
                            <td style="text-align:center;"><h3 class="kk">204101</h3></td>
                        </tr>
                        
                    </table>
                </div>
                <script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>
            </body>       
</html>