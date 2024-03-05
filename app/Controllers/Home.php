<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function testEmail()
    {
        $email = \Config\Services::email();

        $email->setFrom('admin@koateen.com', 'Admin Koateen');
        $email->setTo('nadhirov@gmail.com');

        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');

        try {
            $email->send();
            echo 'success';
        } catch (\Exception $er) {
            echo $er->getMessage();
        }
    }
}
