<!DOCTYPE html>
<html>

<head>
    <meta charset=“UTF-8">
    <meta name=“viewport” content=“width=device-width,initial-scale=1">
    <meta name=“x-apple-disable-message-reformatting”>
    <title>Madares Email</title>
    <link rel=“preconnect” href=“https://fonts.googleapis.com”>
    <link rel=“preconnect” href=“https://fonts.gstatic.com” crossorigin>
    <link href=“https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap” rel=“stylesheet”>
    <style>
        body {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background-image: url('');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0px;
            height: 100vh;
            text-align: center;
            font-family: ‘Poppins’;
        }


        table {
            background-size: cover;
            background-image: url('https://cdn.baynounahsc.ae/storage/cdn/F0nIydXCxlgP1Ae2kIsDbPKdOhUUyqZRYC4svjcD.png');

        }


        .body_inner {
            margin: 50px;
            background-color: #fff;
            box-shadow: 1px 0px 8px rgba(128, 128, 128, 0.342);
            border-radius: 15px;
            padding: 10px;
            width: 50%;
            overflow: hidden;
            position: relative;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .body_inner h1,
        .body_inner label,
        .body_inner p {
            z-index: 99;
        }

        .body_inner h1 {
            margin: 0px;
        }

        .greenBC {
            background-color: #104B08;
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            z-index: 100;
            height: 5px;
        }
    </style>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
        <tr>
            <td>
                <div class="body_inner">
                    <div class="greenBC"></div>
                    <h1>Welcome To Madares</h1>
                    <label>You can verifiy your email by clicking <a href="{{$code}}">here</a></label>
                </div>
            </td>
        </tr>

    </table>

</body>
</html>