<?php

use App\Controllers\AuthController;
use App\Controllers\DiscoveryController;
use App\Controllers\MyLibrary;
use App\Controllers\PlayQuizController;
use App\Controllers\QuizController;
use App\Core\Database;
use App\Core\Router;

session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

define('BASE', dirname(__DIR__));

require_once BASE . '/vendor/autoload.php';

$router = new Router;
// Kết nối db
$db = new Database('127.0.0.1', 'root', '', 'quizapp');

// Load routes
$router->addRoute('GET', '/', [DiscoveryController::class, 'index']);
$router->addRoute('GET', '/thu-vien-cua-toi', [MyLibrary::class, 'index']);

$router->addRoute('GET', '/choi', [PlayQuizController::class, 'index']);
$router->addRoute('POST', '/choi/bat-dau', [PlayQuizController::class, 'start']);
$router->addRoute('GET', '/choi/cau-hoi', [PlayQuizController::class, 'question']);
$router->addRoute('POST', '/choi/gui-dap-an', [PlayQuizController::class, 'submitAnswer']);
$router->addRoute('GET', '/choi/ket-qua', [PlayQuizController::class, 'result']);

$router->addRoute('POST', '/tao-quiz-moi', [QuizController::class, 'createNewQuiz']);
$router->addRoute('POST', '/luu-quiz', [QuizController::class, 'saveQuiz']);
$router->addRoute('DELETE', '/xoa-quiz', [QuizController::class, 'deleteQuizById']);
$router->addRoute('POST', '/them-cau-hoi-moi', [MyLibrary::class, 'addNewQuestion']);
$router->addRoute('DELETE', '/xoa-cau-hoi', [MyLibrary::class, 'deleteQuestionById']);

$router->addRoute('GET', '/dang-nhap', [AuthController::class, 'loginPage']);
$router->addRoute('POST', '/dang-nhap', [AuthController::class, 'login']);
$router->addRoute('GET', '/dang-ky', [AuthController::class, 'registerPage']);
$router->addRoute('POST', '/dang-ky', [AuthController::class, 'register']);
$router->addRoute('GET', '/dang-xuat', [AuthController::class, 'logout']);

$router->addRoute('GET', '/lich-su-choi-quiz', [QuizController::class, 'history']);

$router->handleRequest();
