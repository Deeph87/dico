<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Dico\Services\Parameters;
use Dico\Services\GlosbeWrapper;
use App\Controllers;

// Routes

//$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//// Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//// Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});
$app->get('/', Controllers\BotController::class . ':show');

$app->get('/bot', Controllers\BotController::class . ':show');

$app->get('/getrandworddefinition', Controllers\AjaxBotController::class . ':getRandWordDefinition');

$app->get('/test', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, '../app/views/pages/test.html', $args);
});

$app->get('/worddef', function (Request $request, Response $response, array $args) {
    GlosbeWrapper::getRandFRWordDefinition('dichotomie');
});

$app->post('/user', function (Request $request, Response $response, array $args) {
    try {
    $DBConnect = $this->DBConnect;
    $sql = 'INSERT INTO `users`(`email`, `firstname`, `lastname`, `gender`, `age`, `date_signin`, `date_last_login`, `password`) 
    VALUES (:email, :firstname, :lastname, :gender, :age, :date_signin, :date_last_login, :password)';
    $prepare = $DBConnect->getPDO()->prepare($sql);

    $params = $request->getParams();

    $parametersObject = new Parameters($params);
    $paramsValid = $parametersObject->areValid(Parameters::USER_VALID_PARAMETERS);
    if($paramsValid['state']){
        $date = DateTime::createFromFormat('U', date('U'))->format('Y-m-d H:i:s');
        $values = [
            ':email' => $request->getParam('email'),
            ':firstname' => $request->getParam('firstname'),
            ':lastname' => $request->getParam('lastname'),
            ':gender' => $request->getParam('gender'),
            ':age' => $request->getParam('age'),
            ':date_signin' => $date,
            ':date_last_login' => $date,
            //Using hash for password encryption
            ':password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
        ];
        $prepare->execute($values);
        return $response->withJson(['status' => 'User Created'], $paramsValid['status']);
    }

    return $response->withJson(['error' => 'User not created'], $paramsValid['status']);

    } catch (\Exception $exception){
        return $response->withJson(['error' => $exception->getMessage()],422);
    }
});

$app->get('/user/{id}', function (Request $request, Response $response, array $args) {
    try {
        $DBConnect = $this->DBConnect;
        $sql = 'SELECT * FROM `users` WHERE id = :id';
        $prepare = $DBConnect->getPDO()->prepare($sql);
        $values = [
            ':id' => $request->getAttribute('id')
        ];
        $prepare->execute($values);
//        $results = $prepare->fetch();

        $results = [];
        while($currentRes = $prepare->fetch()){
            $results['id'] = !empty($currentRes['id']) ? $currentRes['id'] : null;
            $results['email'] = !empty($currentRes['email']) ? $currentRes['email'] : null;
            $results['firstname'] = !empty($currentRes['firstname']) ? $currentRes['firstname'] : null;
            $results['lastname'] = !empty($currentRes['lastname']) ? $currentRes['lastname'] : null;
            $results['age'] = !empty($currentRes['age']) ? $currentRes['age'] : null;
            $results['gender'] = !empty($currentRes['gender']) ? $currentRes['gender'] : null;
            $results['date_signin'] = !empty($currentRes['date_signin']) ? $currentRes['date_signin'] : null;
            $results['date_last_login'] = !empty($currentRes['date_last_login']) ? $currentRes['date_last_login'] : null;
            $results['password'] = !empty($currentRes['password']) ? $currentRes['password'] : null;
        }

        if($results){
            return $response->withJson($results, 200);
        } else {
            return $response->withJson(['status' => 'User not found'], 422);
        }

    } catch (\Exception $exception){
        return $response->withJson(['error' => $exception->getMessage()],422);
    }
});
