<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets\css\bootstrap.css">
    <title>Lover</title>
    <style>
        .feed>p {
            padding: 10px;
            overflow-x: auto;
            display: block;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 80%;
            margin: 10px 0px;
            background-color: lightblue;
            border: 0px;
            border-radius: 0 20% 0 20%;
            justify-content: center;
            box-shadow: 2px 1px darkgray;
            letter-spacing: 2px;
        }

        .feed>.myp {

            background-color: lightgreen;
            align-self: flex-end;

        }
    </style>
</head>

<body>
    <div class="container ">
        <header class="card">
            <h2 class="card-header font-weight-bold">LOVER</h2>
        </header>
        <div class="row pt-2 pr-2">
            <div class="col-md-8 p-2 border-right">
                <h4 class="text-center text-secondary" style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">Messenger</h4>
                <form id="smsSimulator" onsubmit="return smsSend(event);">
                    <div class="row">
                        <div class=" form-group col">
                            <label for="">Phone</label>
                            <input type="text" placeholder="07712345678" name="phone" id="phone" class="form-control form-control-sm">
                        </div>
                        <div class=" form-group col">
                            <label for="">To</label>
                            <input type="text" name="too" readonly value="5001" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea name="msg_body" id="msg_body" cols="30" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <button type="submit" class="btn btn-outline-secondary btn-block">Send</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 p-2">
                <h4 class="text-center text-secondary border-bottom" style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">Feed</h4>
                <div id="feed" class="feed"></div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="assets\jquery-3.4.1.min.js"></script>
    <script src="assets\js\bootstrap.bundle.min.js"></script>
    <script src="assets\notify.js"></script>
    <script src="assets\app.js"></script>

</body>

</html>