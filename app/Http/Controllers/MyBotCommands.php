<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

 class MyBotCommands extends Controller
 {

 public function handleFoo($bot) {
        $bot->reply('yes it works foo Hello World');
    }
//in this function I am getting also the argument form an other class an display it here
 public function callme($bot,$name) {
        $bot->reply('I am trying to say your name ...');
        $bot->reply('Your name is: '.$name);
    }

 }