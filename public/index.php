<?php

require 'Slim/Slim.php';
require 'RedBean/rb.php';
require 'facebook_php_sdk/src/facebook.php';
\Slim\Slim::registerAutoloader();

//R::setup('mysql:host=localhost;dbname=questionnaire', 'root', ''); //mysql
R::setup('mysql:host=localhost;dbname=647054', '647054', '19901013'); //mysql
R::freeze(true);

$app = new \Slim\Slim();

$app->config(array(
    'templates.path' => './templates')
);

//------------------------------------front end--------------------------------------//
$app->get('/', function() use($app) {
            $app_id = '508173905905976';
            $secret = 'cf27054f46cc2e3bd45d2422046f351b';

            $facebook = new Facebook(array(
                'appId' => $app_id,
                'secret' => $secret,
            ));

            //嘗試取得使用者ID
            $uid = $facebook->getUser();

//設定跳回的應用程式網址
            $redirectUrl = 'http://apps.facebook.com/questionnairee';
            //$redirectUrl = 'http://localhost/new1/intro/';
//設定跳回的應用程式網址
            $loginUrl = $facebook->getLoginUrl(
                    array('scope' => 'publish_stream,user_birthday, user_location', //新版的授權參數
                        'redirect_uri' => $redirectUrl, //回傳網址
                        'canvas' => 1, 'fbconnect' => 1
            ));

//檢查是否存在使用者ID
            if ($uid) {
//有使用者ID,嘗試取得個人資料
                try {
                    $me = $facebook->api('/me');
                } catch (FacebookApiException $e) {

                    error_log($e);
                    $uid = null;
                    $me = null;
                }
            } else {
//沒有使用者ID,導引到登入頁面
                echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
            }

//已取得使用者資料，利用GRAPH API 存取使用者對應用程式的授權，
            $permissions = $facebook->api("/me/permissions");
            //var_dump($permissions);
//檢查授權清單，以避免使用者缺乏蹶別授權項目
            if (!array_key_exists('publish_stream,user_birthday,ads', $permissions['data'][0])) {
//缺乏蹶別授權項目,,導引到登入頁面
                echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
            }
        });

$app->get('/intro/', function () use($app) {
            $code = $_GET['code'];
            $app_id = '508173905905976';
            $secret = 'cf27054f46cc2e3bd45d2422046f351b';
            $redirectUrl = '/questionnaire.freeoda.com';
            $token_url = "https://graph.facebook.com/oauth/access_token?"
                    . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirectUrl)
                    . "&client_secret=" . $secret . "&code=" . $code;

            $response = file_get_contents($token_url);
            $params = null;
            parse_str($response, $params);
            $graph_url = "https://graph.facebook.com/me?access_token="
                    . $params['access_token'];

            $user = json_decode(file_get_contents($graph_url));
            $record = R::findOne('fbuser', 'id=' . $user->id);
            if (!$record) {
                $a = R::dispense('fbuser');
                $a->id = $user->id;
                $a->firstName = $user->first_name;
                $a->lastName = $user->last_name;
                $a->gender = $user->gender;
                $a->Location = $user->locale;
                $a->birthday = $user->birthday;
                $a->lastUpdate = R::isoDate();
                R::store($a);
            }
            /* $dsn = "mysql:host=localhost;dbname=questionnaire";
              $db = new PDO($dsn, 'root','');
              $count = $db->exec("INSERT INTO fbuser(id, firstName, lastName, gender, Location, birthday) VALUES (" . $user->id . ',' . $user->first_name . ',' . $user->last_name . ',' . $user->gender . ',' . $user->locale . ',' . $user->birthday .')');
              //echo $count;
              $db = null; */
            $introduction = R::findOne('introduction', 'id = 1');
            $name = $introduction->name;
            $description = $introduction->description;

            $data = array(
                'title' => $name,
                'heading' => $description);

            $app->render('/question/tpl_intro.php', $data);
        });

$app->get('/question', function () use($app) {

            $introduction = R::findOne('introduction', 'id = 1');
            $name = $introduction->name;

            $questions = R::findAll('questions', 'order by seq');
            foreach ($questions as $qid) {
                $ans[] = R::find('answers', 'questions_id =' . $qid->id . ' order by seq');
            }
            $data = array(
                'header' => $name,
                'title' => '選擇下面題目的答案',
                'questions' => $questions,
                'ans' => $ans
            );

            $app->render('/question/tpl_que.php', $data);
        });

$app->post('/getResult', function () use($app) {

            $introduction = R::findOne('introduction', 'id = 1');
            $name = $introduction->name;
            $mark = 0;
            $ans = R::findAll('answers');
            $count = R::count('answers');
            $req = $app->request();
            $var = $req->post();

            for ($i = 1; $i <= $count; $i++) {
                if (isset($var['option_' .
                                $i])) {
                    foreach ($ans as $one) {
                        if ($one->id == $var['option_' . $i]) {
                            $option[] = $one->id;
                            $mark += $one->point;
                        }
                    }
                }
            }
            $result = R::findOne('results', 'upper >= ' . $mark . ' AND ' . $mark . '>= lower');

            $resultfreq = R::dispense('resultfreq');
            $resultfreq->fbuser_id = 11;
            $resultfreq->results_id = $result->id;
            $resultfreq->subDate = R::isoDateTime();
            $resultFreqId = R::store($resultfreq);
            foreach ($option as $opt) {
                $ansFreq = R::dispense('ansfreq');
                $ansFreq->answers_id = $opt;
                $ansFreq->resultFreq_id = $resultFreqId;
                R::store($ansFreq);
            }
            $chart = R::findAll('chart');
            foreach ($chart as $ch) {
                if ($ch->display == 1) {
                    $c[] = $ch->id;
                    $query = $stat[$ch->id] = R::getAll($ch->query);
                    if ($ch->id == 1)
                        $URL[$ch->id] = chart1($query);
                    else if ($ch->id == 2)
                        $URL[$ch->id] = chart2($query);
                    else if ($ch->id == 3)
                        $URL[$ch->id] = chart3($query);
                    else if ($ch->id == 4)
                        $URL[$ch->id] = chart4($query);
                }
            }
            $data = array(
                'header' => $name,
                'title' => '結果',
                'type' => $result->type,
                'content' => $result->content,
                'stat' => $stat,
                'URL' => $URL,
                'c' => $c
            );
            $app->render('/question/tpl_result.php', $data);
        });

//------------------------------------back end--------------------------------------//       
/* --------------------------------admin----------------------------------------- */
$app->add(new \Slim\Middleware\SessionCookie(array('secret' => 'myappsecret')));

$app->config(array('templates.path' => './templates'));

$authenticate = function ($app) {
            return function () use ($app) {
                        if (!isset($_SESSION['user'])) {
                            $_SESSION['urlRedirect'] = $app->request()->getPathInfo();
                            $app->redirect('./login&login_required');
                        }
                    };
        };

$app->hook('slim.before.dispatch', function() use ($app) {
            $user = null;
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
            }
            $app->view()->setData('user', $user);
        });

$app->get("/logout", function () use ($app) {
            unset($_SESSION['user']);
            $app->view()->setData('user', null);
            $app->redirect('login&null');
        });

$app->get("/login&:status", function ($status) use ($app) {


            $urlRedirect = '/admin_panel';
            if ($status == "invalid")
                $error = 'Incorrect username/password.';

            else if ($status == 'login_required')
                $error
                        = 'Login required.';
            else
                $error = '';
            if ($app->request()->get('r') && $app->request()->get('r') != '/logout' && $app->request()->get('r') != '/login') {
                $_SESSION['urlRedirect'] = $app->request()->get('r');
            }

            if (isset($_SESSION['urlRedirect'])) {
                $urlRedirect = '/new1' . $_SESSION['urlRedirect'];
            }

            $data = array(
                'pageTitle' => "Administrator Login | Questionnaire",
                'pageHeader' => "Administrator Login Page",
                'error' => $error
            );
            $app->render('/admin/admin_Login.php', $data);
        });

$app->post("/login", function () use ($app) {
            $username = strtolower($app->request()->post('username'));
            $password = md5($app->request()->post('password'));

            $errors = array();
            $row = R::getCell('select account from users where password = :pw AND account = :username', array(':pw' => $password,
                        'username' => $username));

            if ($row == NULL) {
                $errors['username'] = " username is not found.";
                $app->redirect('login&invalid');
            } else {
                $_SESSION['user'] = $username;

                if (isset($_SESSION['urlRedirect'])) {
                    $tmp = './' . $_SESSION['urlRedirect'];
                    unset($_SESSION['urlRedirect']);
                    $app->redirect($tmp);
                }
                $app->redirect('admin_panel');
            }
        });

$app->get("/admin_panel", $authenticate($app), function() use($app) {
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => 'Administration Panel',
                'user' => $_SESSION['user']);
            $app->render('/admin/adminPanel.php', $data);
        });

$app->get("/listAdmins&:status", $authenticate($app), function ($status) use ($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_id") {
                $error = 'Username cannot be same!';
                $message
                        = '';
            }
            else
                $error = $message = '';
            $list = R::findAll('users');
            $total = R::count('users');
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Administrator List",
                'user' => $_SESSION['user'],
                'list' => $list,
                'total' => $total,
                'success' => $message,
                'error' => $error
            );
            $app->render('/admin/listAdmin.php', $data);
        });

$app->get("/editAdmin = :id&:status", $authenticate($app), function ($id, $status) use ($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_id") {
                $error = 'Username already exist!';
                $message = '';
            } else if ($status == "pw_not_match") {
                $error = 'The two passwords do not match!';
                $message
                        = '';
            }
            else
                $error = $message = '';
            $getById = R::find('users', 'id =' . $id);
            $data = array(
                'pageTitle' => "Administrator | Questionnaire",
                'pageHeader' => "Edit Admin Information",
                'pageHeader_2' => "Edit Admin Information",
                'user' => $_SESSION['user'],
                'admin' => $getById,
                'success' => $message,
                'error' => $error
            );
            $app->render('/admin/editAdmin.php', $data);
        })->name('admin_edit');

$app->post("/editAdmin = :id", $authenticate($app), function ($id) use ($app) {

            $account = strtolower($app->request()->post('account'));
            $password = $app->request()->post('password');
            $confirm_pw = $app->request()->post('confirm_pw');
            $row = R::findOne('users', 'account = :name', array(':name' => $account));
            if ($row != NULL && $row->id != $id) {
                $app->redirect('editAdmin=' . $id . '&invalid_id');
            } else if ($password != $confirm_pw) {
                $app->redirect('editAdmin=' . $id . '&pw_not_match');
            } else {
                $admin = R::load('users', $id);
                $admin->account = $account;
                $admin->password = md5($password);
                $admin->lastUpdate = R::isoDateTime();
                R::store($admin);
                $app->redirect('listAdmins&success');
            }
        })->name('admin_edit_post');

$app->get("/deleteAdmin = :id", $authenticate($app), function ($id) use ($app) {
            $getById = R::load('users', $id);
            R::trash($getById);
            $app->redirect('listAdmins&success');
        });

$app->get("/newAdmin&:status", $authenticate($app), function ($status) use ($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_id") {
                $error = 'Username already exist!';
                $message = '';
            } else if ($status == "pw_not_match") {
                $error = 'The two passwords do not match!';
                $message = '';
            }
            else
                $error = $message = '';
            $data = array(
                'pageTitle' => "Administrator | Questionnaire",
                'pageHeader' => "New Administrator ",
                'pageHeader_2' => "New Admin Information",
                'user' => $_SESSION['user'],
                'success' => $message,
                'error' => $error
            );
            $app->render('/admin/create_Form.php', $data);
        })->name('admin_edit');

$app->post("/newAdmin", $authenticate($app), function () use ($app) {

            $account = strtolower($app->request()->post('account'));
            $password = $app->request()->post('password');
            $confirm_pw = $app->request()->post('confirm_pw');
            $row = R::count('users', 'account = :name', array(':name' => $account));
            if ($row > 0) {
                $app->redirect('newAdmin&invalid_id');
            } else if ($password != $confirm_pw) {
                $app->redirect('newAdmin&pw_not_match');
            } else {
                $admin = R::dispense('users');
                $admin->account = $account;
                $admin->password = md5($password);
                $admin->lastUpdate = R::isoDateTime();
                R::store($admin);
                $app->redirect('listAdmins&success');
            }
        });

/* --------------------------------question-------------------------------------- */

$app->get('/list&:status', $authenticate($app), function($status) use($app) {

            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_order") {
                $error = 'Questions order cannot be same!';
                $message = '';
            }
            else
                $error = $message = '';
            $list = R::findAll('questions', "order by seq");
            $total = R::count('questions');
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Question List",
                'user' => $_SESSION['user'],
                'list' => $list,
                'total' => $total,
                'success' => $message,
                'error' => $error
            );
            $app->render('/question/list_question.php', $data);
        });

$app->post("/updateQuestion/id = :id", $authenticate($app), function($id) use($app) {

            $count = R::count('answers', 'questions_id =' . $id);
            $answer = R::find('answers', 'questions_id =' . $id);
            $req = $app->request();
            $var = $req->post();
            foreach ($answer as $a) {
                $s[] = $app->request()->post('order_' . $a->id);
            }
            for ($i = 0; $i <
                    $count; $i++) {
                for ($j = $i + 1; $j < $count; $j++) {
                    if ($s[$i] == $s[$j])
                        $app->
                                redirect('../getQuestion/id=' . $id . '&invalid_order');
                }
            }

            $question = R::load('questions', $id);
            $question->question = $var['question'];
            $question->lastUpdate = R::isoDateTime();
            R::store($question);

            foreach ($answer as $ans) {
                $str = "order_" . $ans->id;
                $str2 = "ans_" . $ans->id;
                $str2 = "point_" . $ans->id;
                $ans->seq = $var['order_' . $ans->id];
                $ans->answer = $var['ans_' . $ans->id];
                $ans->point = $var['point_' . $ans->id];
                $ans->lastUpdate = R::isoDateTime();
            }
            R::storeAll($answer);
            $app->redirect('../list&success');
        });

$app->get("/getQuestion/id = :id&:status", $authenticate($app), function ($id, $status) use($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_order") {
                $error = 'Questions order cannot be same!';
                $message
                        = '';
            }
            else
                $error = $message = '';
            $getQuestionById = R::findOne('questions', 'id =' . $id);
            $getAnsById = R::find('answers', "questions_id = " . $id . " order by seq");
            $count = R::count('answers', 'questions_id =' . $id);
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Edit Question",
                'quest' => $getQuestionById,
                'ans' => $getAnsById,
                'total' => $count,
                'error' => $error,
                'success' => $message
            );
            $app->render('/question/getQuestion.php', $data);
        });

$app->post("/changeOrder", $authenticate($app), function () use($app) {
            $count = R::count('questions');
            for ($i = 1; $i <= $count; $i++) {
                $s[$i] = $app->request()->post('qid_' . $i);
            }
            for ($i = 1; $i <= $count; $i++) {
                for ($j = $i + 1; $j <= $count; $j++) {
                    if ($s[$i] == $s[$j])
                        $app->redirect('./list&invalid_order');
                }
            }
            $question = R::find('questions');
            foreach ($question as $quest) {
                $str = "qid_" . $quest->id;
                $quest->seq = $app->request()->post($str);
            }
            R::storeAll($question);
            $app->redirect('./list&success');
        });

$app->get("/addQuestion&:status", $authenticate($app), function ($status) use($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_order") {
                $error = 'Questions order cannot be same!';
                $message
                        = '';
            }
            else
                $error = $message = '';
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Add Question",
                'user' => $_SESSION['user'],
                'success' => $message,
                'error' => $error
            );
            $app->render('/question/question_form.php', $data);
        });

$app->post("/addQuestion", $authenticate($app), function () use($app) {
            $req = $app->request();
            $allPostVars = $req->post();
            $q_order = $allPostVars['q_order'];
            $row = R::findOne("questions", 'seq =' . $q_order);
            if (isset($row))
                $app->redirect('./addQuestion&invalid_order');
            $quest = R::dispense('questions');
            $quest->question = $allPostVars['question'];
            $quest->seq = $allPostVars['q_order'];
            $quest->lastUpdate = R::isoDateTime();
            R::store($quest);

            $qid = R::findOne('questions', 'seq=' . $q_order);
            $answer = R::dispense('answers');
            $answer->answer = $allPostVars['ans'];
            $answer->questions_id = $qid->id;
            $answer->seq = $allPostVars['a_order'];
            $answer->point = $allPostVars['point'];
            $answer->lastUpdate = R::isoDateTime();
            R::store($answer);
            $app->redirect('./list&success');
        });

$app->get("/dropQuestion/id = :id", $authenticate($app), function ($id) use($app) {
            $getQuestionById = R::load('questions', $id);
            $getansid = $getAnsById = R::find('answers', 'questions_id =' . $id);

            foreach ($getansid as $getansid) {
                $ansfreq = R::find('ansfreq', 'answers_id=' . $getansid->id);
                foreach ($ansfreq as $a) {
                    $resultfreq = R::find('resultfreq', 'id =' . $a->resultFreq_id);
                    R::trashAll($resultfreq);
                }
                R::trashAll($ansfreq);
            }
            R::trashAll($getAnsById);
            R::trash($getQuestionById);
            $app->redirect('../list&success');
        });
/* --------------------------------intro--------------------------------------- */

$app->get("/editIntro", $authenticate($app), function() use($app) {
            $msg = R::findOne('introduction', '1');
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Change Introduction",
                'user' => $_SESSION['user'],
                'intro' => $msg);
            $app->render('/introduction/editIntro.php', $data);
        });

$app->post("/editIntro", $authenticate($app), function() use($app) {
            $msg = R::load('introduction', '1');
            $msg->name = $app->request()->post('intro');
            $msg->description = $app->request()->post('description');
            $msg->lastUpdate = R::isoDateTime();
            R::store($msg);
        });

/* --------------------------------fbuser-------------------------------------- */

$app->get("/all_fbuser&:status", $authenticate($app), function ($status) use($app) {
            if ($status == "success")
                $message
                        = 'Success, changes saved.';
            else
                $message = '';
            $list = R::findAll('fbuser');
            $total = R::count('fbuser');
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Facebook User Record",
                'user' => $_SESSION['user'],
                'list' => $list,
                'total' => $total,
                'success' => $message
            );
            $app->render('/fbuser/list_user.php', $data);
        });

$app->get("/details = :id", $authenticate($app), function ($id) use($app) {
            $getById = R::findOne('fbuser', 'id = :id', array(':id' => $id));
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Facebook User Details",
                'user' => $_SESSION['user'],
                'list' => $getById);
            $app->render('/fbuser/user_details.php', $data);
        });

$app->get("/delete = :id", $authenticate($app), function ($id) use ($app) {
            $getfreq = R::find('resultfreq', 'fbuser_id=' . $id);
            $getById = R::load('fbuser', $id);
            R::trashAll($getfreq);
            R::trash($getById);
            $app->redirect('all_fbuser&success');
        });

/* -------------------------------------answer------------------------------------- */

$app->get("/addAnswer/qid = :qid&:status", $authenticate($app), function ($qid, $status) use($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_order") {
                $error = 'Questions order cannot be same!';
                $message = '';
            }
            else
                $error = $message = '';
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Add Answer",
                'quest' => $qid,
                'success' => $message,
                'error' => $error
            );
            $app->render('/answer/answer_form.php', $data);
        });

$app->post("/addAnswer/qid = :qid", $authenticate($app), function ($qid) use ($app) {
            $req = $app->request();
            $allPostVars = $req->post();
            $order = $allPostVars['a_order'];
            $row = R::findOne('answers', 'questions_id = :qid AND seq= :order', array(':qid' => $qid, ':order' => $order));
            if (isset($row))
                $app->redirect('../addAnswer/qid=' . $qid . '&invalid_order');
            $answer = R::dispense('answers');
            $answer->answer = $allPostVars['ans'];
            $answer->questions_id = $qid;
            $answer->seq = $allPostVars['a_order'];
            $answer->point = $allPostVars['point'];
            $answer->lastUpdate = R::isoDateTime();
            R::store($answer);
            $app->redirect('../getQuestion/id=' . $qid . '&success');
        });

$app->get("/dropAnswer/id = :id&qid = :qid", $authenticate($app), function ($id, $qid) use($app) {
            $getAnsById = R::load('answers', $id);
            $ansfreq = R::find('ansfreq', 'answers_id=' . $id);
            $freqid = R::findOne('ansfreq', 'answers_id=' . $id);
            $resultfreq = R::findOne('resultfreq', 'id=' . $freqid->resultFreq_id);
            R::trash($resultfreq);
            R::trashAll($ansfreq);
            R::trash($getAnsById);
            $app->redirect('../getQuestion/id=' . $qid . '&success');
        });
//------------------------------------Results-----------------------------------------------//

$app->get("/listResults&:status", $authenticate($app), function ($status) use($app) {
            if ($status == "success") {
                $message = 'Success, changes saved.';
                $error = '';
            } else if ($status == "invalid_mark") {
                $error = 'The Upper Mark cannot larger than the Lower one!';
                $message
                        = '';
            }
            else
                $error = $message = '';
            $list = R::findAll('results');
            $total = R::count('results');
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Results List",
                'user' => $_SESSION['user'],
                'list' => $list,
                'total' => $total,
                'success' => $message,
                'error' => $error
            );
            $app->render('/result/result_list.php', $data);
        });

$app->get("/editResult/id = :id&:status", $authenticate($app), function ($id, $status) use ($app) {
            if ($status == "invalid_mark")
                $error
                        = 'The Upper Mark cannot larger than the Lower one!';
            else
                $error = '';
            $getById = R::findOne('results', 'id =' . $id);
            $data = array(
                'pageTitle' => "Administration | Questionnaire",
                'pageHeader' => "Edit Results",
                'list' => $getById,
                'error' => $error
            );
            $app->render('/result/edit_form.php', $data);
        });

$app->post("/editResult/id = :id", $authenticate($app), function ($id) use ($app) {
            $req = $app->request();
            $allPostVars = $req->post();

            if ($allPostVars['lower'] > $allPostVars ['upper'])
                $app->
                        redirect('../editResult/id=' . $id . '&invalid_mark');

            $result = R::load('results', $id);
            $result->type = $allPostVars['type'];
            $result->content = $allPostVars['content'];
            $result->lower = $allPostVars['lower'];
            $result->upper = $allPostVars['upper'];
            $result->lastUpdate = R::isoDateTime();
            R::store($result);
            $app->redirect('../listResults&success');
        });

$app->get("/addResult&:status", $authenticate($app), function ($status) use($app) {
            if ($status == "invalid_mark")
                $error
                        = 'The Upper Mark cannot larger than the Lower one!';
            else
                $error = '';
            $data = array(
                'pageHeader' => 'Create New Result Type',
                'error' => $error
            );
            $app->render('/result/result_form.php', $data);
        });

$app->post("/addResult", $authenticate($app), function () use ($app) {
            $req = $app->request();
            $allPostVars = $req->post();

            if ($allPostVars['lower'] > $allPostVars ['upper'])
                $app->
                        redirect('./addResult&invalid_mark');

            $result = R::dispense('results');
            $result->type = $allPostVars['type'];
            $result->lower = $allPostVars['lower'];
            $result->upper = $allPostVars['upper'];
            $result->content = $allPostVars['content'];
            $result->lastUpdate = R::isoDateTime();
            R::store($result);
            $app->redirect('./listResults&success');
        });

$app->get("/dropResult/id = :id", $authenticate($app), function ($id) use($app) {
            $getById = R::load('results', $id);
            $getfreqid = $getfreq = R::find('resultfreq', 'results_id=' . $id);
            $ansfreq = R::find('ansfreq', 'resultfreq_id=' . $getfreqid);
            R::trashAll($ansfreq);
            R::trashAll($getfreq);
            R::trash($getById);
            $app->redirect('../listResults&success');
        });

//--------------------------------------Chart------------------------------------------//
function chart4(
$query) {

    $chd = 't:';
    $chl = '';
    foreach ($query as $query) {
        $chl .= $query['Answer'] . '|';
        $chd .= $query['Frequency'] . ',';
    }
    $chd = substr($chd, 0, -1);
    $chl = substr($chl, 0, -1);
    $http = "https://chart.googleapis.com/chart?";
    $chco = '514b4b|ffcc71|38a0ad|15d7df|ff6262|f87a04|0f220f|010131|f6f2e5|cc995d|cbdccc|5528b2|0000ff|0c822d|09853a|018b40|008050|a08060|0f8f70';
    return $http .
            'chs=640x230&amp;cht=p3&amp;chd=' . $chd .
            '&amp;chco=' . $chco .
            '&amp;chxt=y,x&amp;chxr=0,0|0,0&amp;chl=' . $chl .
            '&amp;chls=200,1,1&amp;chtt=各答案被選擇的次數';
}

function chart1($query) {

    $chd = 't:';
    $chl = '';
    foreach ($query as $query) {
        $chl .= $query['Type'] . '|';
        $chd .= $query['Frequency'] . ',';
    }
    $chd = substr($chd, 0, -1);
    $chl = substr($chl, 0, -1);
    $http = "https://chart.googleapis.com/chart?";
    $chco = '514b4b|ffcc71|38a0ad|15d7df|ff6262|f87a04|0f220f|010131|f6f2e5|cc995d|cbdccc|5528b2|0000ff|0c822d|09853a|018b40|008050|a08060|0f8f70';
    return $http .
            'chs=640x230&amp;cht=p3&amp;chd=' . $chd .
            '&amp;chco=' . $chco .
            '&amp;chxt=y,x&amp;chxr=0,0|0,0&amp;chl=' . $chl .
            '&amp;chls=200,1,1&amp;chtt=各結果的次數分佈';
}

function chart2($query) {

    $chd = 't:';
    $chxl = '0:|';
    $chd2 = '';
    foreach ($query as $query) {
        if ($query['gender'] == 'M') {
            $chxl .= $query['Type'] . '|';
            $chd .= $query['Frequency'] . ',';
        }
        else
            $chd2 .= $query['Frequency'] . ',';
    }
    $chd = substr($chd, 0, -1);
    $chd .= '|' . $chd2;
    $chd = substr($chd, 0, -1);
    $chl = substr($chxl, 0, -1);

    $http = "https://chart.googleapis.com/chart?";
    return $http . '&amp;cht=bvs&amp;chd=' . $chd .
            '&amp;chdl=Male|Female&amp;chs=400x300&amp;chco=0081ff,eeeeee&amp;chxt=x,y&amp;chxl=' . $chl .
            '&amp;chbh=a,50&amp;chtt=各結果的男女分佈';
}

function chart3($query) {

    $type = R::getCol('select type from results');
    $q = R::findOne('chart', 'id = 3');
    $num = R::exec($q->query);
    $chd = 't:';
    $chxl = '0:|';
    $chd2 = '';
    $chdl = '';
    $s = $t = strlen($chd);
    foreach ($type as $type) {
        $chdl .= $type . '|';
        for ($i = 0; $i < $num; $i++) {
            if ($query[$i]['type'] == $type) {
                $chxl .= $query[$i]['age'] . '|';
                $chd .= $query[$i]['Frequency'] . ',';
                $s = strlen($chd);
            }
        }
        if ($s > $t) {
            $chd = substr($chd, 0, -1);
            $chd.='|';
            $t = $s;
        }
    }
    $chd = substr($chd, 0, -1);
    $chl = substr($chxl, 0, -1);
    $chdl = substr($chdl, 0, -1);

    $http = "https://chart.googleapis.com/chart?";
    return $http . '&amp;cht=bvs&amp;chd=' . $chd .
            '&amp;chdl=' . $chdl . '&amp;chs=400x300&amp;chco=0081ff,eeeeee,514b4b,1ee8ff&amp;chxt=x,y&amp;chxl=' . $chl .
            '&amp;chbh=a,20&amp;chtt=各結果的年齡分佈';
}

//----------------------------------stat-----------------------------------------*/
$app->get("/getStat", $authenticate($app), function () use($app) {
            $check = $query = R::findAll('chart');
            $fbuser = R::count('fbuser');
            foreach ($query as $query) {
                $chart[] = R::getAll($query->query);
            }

            $data = array(
                'pageHeader' => "Statistics Page",
                'ansfreq' => $chart[3], //$ansfreq,
                'resultfreq' => $chart[0], //$resultfreq,
                'mostfreqAns' => $chart[4], //$mostfreqAns,
                'fbuser' => $fbuser,
                'genderNresult' => $chart[1], //$genderNresult,
                'ageresult' => $chart[2], //$ageresult,
                'URL1' => chart1($chart[0]),
                'URL2' => chart2($chart[1]),
                'URL3' => chart3($chart[2]),
                'URL4' => chart4($chart[3]),
                'chart' => $check
            );
            $app->render('statistics/show_static.php', $data);
        });

$app->post('/changeShowChart', function() use($app) {
            $request = $app->request();
            $choice = $request->post();
            $record = R::findAll('chart');
            $i = 0;

            if (empty($choice)) {
                $record = R::findAll('chart');
                foreach ($record as $record) {
                    $record->display = 0;
                    R::store($record);
                }
            } else {
                foreach ($record as $rec) {
                    $flag = 0;
                    foreach ($choice as $ch) {
                        foreach ($ch as $c) {
                            if ($rec->id == $c) {
                                $rec->display = 1;
                                $flag = 1;
                            }
                        }
                    }
                    if (!$flag)
                        $rec->display = 0;
                    R::store($rec);
                }
            }
        });
$app->run();
?>