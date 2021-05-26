<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
</head>
<body >
    <div class="container">
        <div class="row" style="margin-top:80px ;">
            <div class="col-md-4 col-md-offset-4">
                <h4 style="text-align: center;">Register</h4>
                <form action="{{ route('auth.save') }}" method="post">
                @if(Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                @if(Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
                @endif
                @csrf
                <div class="form-group">
                        <label>User Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}">
                        <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                        <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                    </div>
                    <br>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-block btn-success">Sign Up</button>
                    </div>
                    <br>
                    <a href="{{ route('auth.login') }}">I already have an account, sign in</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>