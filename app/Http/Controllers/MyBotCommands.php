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

 }