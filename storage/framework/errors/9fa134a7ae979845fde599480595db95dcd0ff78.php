<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wrong!</title>

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: "Segoe UI";
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 32px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <img width="100" height="100" src="https://apprecs.org/gp/images/app-icons/300/91/com.neurondigital.FakeError.jpg" alt="Wrong!">
            <div class="title">
            <?php echo empty($e->getMessage()) ? 'Look like something went wrong!': $e->getMessage();?>
            </div>
        </div>
    </div>
</body>

</html>