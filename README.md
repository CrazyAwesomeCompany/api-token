Crazy Awesome API Token
=======================

Create and validate API tokens

In this example we create a new token based on the user ID

    # ... user is logged in with user id 123
    use CAC\Component\Token\Encrypt\McryptToken;
    use CAC\Component\Token\TokenGenerator;

    $tokenEncrypter = new McryptToken();
    $tokenGenerator = new TokenGenerator($tokenEncrypter, 's3cr3tKeY$$');

    $token = $tokenGenerator->createToken(123);

Get the user ID back from the token

    $userId = $tokenGenerator->validateToken($token);
    # $userId = 123

When an invalid token is given the `validateToken` method returns `FALSE`

