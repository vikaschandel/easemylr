<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <style>
        @media only screen and (max-width: 479px) and (min-width: 0px) {
            .nn {
                background-image: none !important;
                background-color: aliceblue;
                height: 870px !important;
            }
            .dd {
            margin-top: 118px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        }

        .nn {
            background-image: url("/eslr_file/bg.jpg");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 588px;
        } 
        .EE{
            margin-top: 21px;
        }

        .dd {
            margin-top: 74px;

            /* margin-top: 118px;
            display: block;
            margin-left: auto;
            margin-right: auto; */
        }

        .main-container {
            margin-top: 118px;
            display: block;
            margin-left: auto;
            height: 330px;
            width: 361px;
            background-color: #989b9e21;
            border-radius: 39px;
        }

        .form-group {
            padding: 6px;
        }

        button.jj {
            margin-left: 8px;
            width: 102px;
            border: none;
            margin-top: 10px;
            background: #febe15;
            padding: 4px;
        }
      
        .jj:hover {
            background-color: #008CBA;
            color: white;
        }
    </style>
</head>

<body>

    <div class="main nn">
        <div class="container ">
            <div class="row">
                <div class="col-sm-6">
                    <div class=" container">
                        <img src="http://easemylr.in/assets/images/Eternity_Forwarder.png" width="200px" height="100px"
                            class="dd">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="main-container">
                        <div class="container">
                            <a><img src="http://easemylr.in/assets/images/ease my lr final.png" class="EE"> </a>
                        </div>
                        <div class="container">
                            <p style="text-align:center;">Please login into your account.</p>
                            <form action="">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email"
                                        name="email">
                                </div>

                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password"
                                        name="pwd">
                                </div>

                                <button type="submit" class="jj">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>








</body>

</html>