<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Lora', sans-serif;
            background-color: #EAEDF8; 
            margin: 0;
        }

        .footer {
            padding: 100px;
            text-align: center;
            background-color: #343434;
            color: white;
            margin-top: 300px;
        }

        p {
            font-size: 23px;
            color: rgba(0,0,0,0.7);
        }

        .main {
            display: flex;
        }

        .menu {
            width: 20%;
            background-color: #746CF5;
            margin-right: 32px;
            padding-top: 150px;
            height: 100vh;
        }

        .menu a {
            display: block;
            text-decoration: none;
            color: white;
            padding: 8px;
            display: flex;
            align-items: center;
        }

        .menu img {
            margin-right: 8px;
            height: 20px;
        }

        .menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .content {
            width: 80%;
            margin-top: 120px;
            margin-right: 32px;
            background-color: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 2px 2px 2px rgba(0,0,0,0.1);
        }

        .menubar {
            background-color: white;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 80px;
            box-shadow: 2px 2px 2px rgba(0,0,0,0.1);
            padding-left: 50px;
            display: flex;
            justify-content: space-between;
        }

        .avatar {
            border-radius: 100%;
            background-color: yellowgreen;
            padding: 16px;
            width: 16px;
            height: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 8px;
        }

        .myname {
            display: flex;
            margin-right: 50px;
            align-items: center;
        }

        .card {
            background-color: rgba(0,0,0,0.05);
            margin-bottom: 16px;
            border-radius: 8px;
            padding: 8px;
            padding-left: 64px;
            position: relative;
        }

        .profile-picture {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 2px solid white;
            position: absolute;
            left: 8px;
        }

        .phonebtn {
            background-color: #999900;
            padding: 4px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            position: absolute;
            right: 0px;
            top: 0px;
        }

        .phonebtn:hover {
            background-color: #26D026;
        }

        .deletenummer {
            background-color: red;
            padding: 4px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            position: absolute;
            right: 0px;
            bottom: 0px;
        }

        .deletenummer:hover {
            background-color: pink;
        }
    </style>

</head>

<body>

    <div class="menubar">
        
        <h1>My contact book</h1>
        <div class="myname">
            <div class="avatar">P</div>
            Parlinka
        </div>
    
    </div>

    <div class="main">

        <div class="menu">
            <a href="index.php?page=start"><img src="img/home.png"> Start</a>
            <a href="index.php?page=contacts"><img src="img/book.png"> Kontakte</a>
            <a href="index.php?page=addcontact"><img src="img/add.png"> Kontakt hinzufügen</a>
            <a href="index.php?page=legal"><img src="img/legal.png"> Impressum</a>
        </div>

        <div class="content">
            <?php
                $headline = 'Herzlich wilkommen!';
                $contacts = [];

                if(file_exists('contacts.txt')) {
                    $text = file_get_contents('contacts.txt', true);
                    $contacts = json_decode($text, true);
                }

                if(isset($_POST['name']) && isset($_POST['phone'])) {
                    echo 'Kontakt ' . $_POST['name'] . ' wurde hinzugefügt';

                    $newContact = [
                        'name' => $_POST['name'],
                        'phone' => $_POST['phone']
                    ];
                    array_push($contacts, $newContact);
                    file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
                }

                if($_GET['page'] == 'contacts') {
                    $headline = 'kontakte';
                }

                if($_GET['page'] == 'addcontact') {
                    $headline = 'kontakt hinzufügen';
                }

                if($_GET['page'] == 'legal') {
                    $headline = 'impressum';
                }

                if($_GET['page'] == 'contacts&delete')

                echo '<h1>' . $headline . '<h1>';

                if($_GET['page'] == 'contacts') {
                    echo '<p>kontakte</p>';

                    foreach($contacts as $key=>$row) {
                        $name = $row['name'];
                        $phone = $row['phone'];

                        echo "
                        <div class='card'>
                            <img class='profile-picture' src='img/profile-picture.jpg'>
                            <b>$name</b><br>$phone

                            <a class='phonebtn' href='tel:$phone'>Anrufen</a>
                            <form action='?page=contacts&delete=$key' method='DELETE'>
                                <button class='deletenummer' type='submit'>Delete</button>
                            </form>
                        </div>
                        ";
                    }
                } else if($_GET['page'] == 'legal') {
                    echo '<p>impressum</p>';
                } else if($_GET['page'] == 'addcontact') {
                    echo '
                    <div>
                        <p>da kannst du einen weiteren kontakt hinzufügen</p>
                    </div>
                    
                    <form action="?page=contacts" method="POST">
                        <div>
                            <input placeholder="Namen eingeben" name="name">
                        </div>

                        <div>
                            <input placeholder="Telefonenummer eingeben" name="phone">
                        </div>

                        <button type="submit">Absenden</button>
                    </form>
                    ';
                }
                else {
                    echo '<p>start</p>';
                }
            ?>
        </div>

    </div>

    <div class="footer">
        (c) 2023 bla bla bla GmbH
    </div>
    
</body>
</html>