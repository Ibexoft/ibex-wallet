<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accounts</title>
</head>
<body>
    <h1>Accounts</h1>
    <ul>
        @foreach ($accounts as $account)
            <li> 
                <a href="accounts/{{$account->id}}"> 
                    {{ $account->name }} 
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>