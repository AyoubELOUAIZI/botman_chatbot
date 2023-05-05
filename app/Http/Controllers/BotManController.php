<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

 class BotManController extends Controller
 {
//    public function handle()
//     {
//         $botman = app('botman');
//         // Set up listener for any message that the bot receives
//         $botman->hears('{message}', function($botman, $message) {
//             if ($message == 'hi') {
//                 $this->askName($botman);
//             } else if ($message == 'how are you') {
//                 $botman->reply('I am a machine learning model, I do not have feelings. But thanks for asking!');
//             } else if (stripos($message, 'tell me a joke') !== false) {
//                 $botman->reply('Why was the math book sad? Because it had too many problems.');
//             } else {
//                 $botman->reply("Sorry, I didn't understand what you said. Write 'hi' or 'tell me a joke' for testing...");
//             }
//         });
//         $botman->listen();
//     }

//     /**
//      * Ask the user for their name.
//      */
//     public function askName($botman)
//     {
//         $botman->ask('Hello! What is your name?', function(Answer $answer) {
//             $name = $answer->getText();
//             $this->say('Nice to meet you, '.$name);
//         });
//     }
// }

//----------------------------------------------------------------------------//
// public function handle()
// {
//     $botman = app('botman');
//     // Set up listener for any message that the bot receives
//     $botman->hears('{message}', function($botman, $message) {
//         if ($message == 'hi') {
//             $this->askName($botman);
//         } else if ($message == 'how are you') {
//             $botman->reply('I am a machine learning model, I do not have feelings. But thanks for asking!');
//         } else if (stripos($message, 'tell me a joke') !== false) {
//             $botman->reply('Why was the math book sad? Because it had too many problems.');
//         } else if (stripos($message, 'make an order') !== false) {
//             $this->askForOrderDetails($botman);
//         } else {
//             $botman->reply("Sorry, I didn't understand what you said. Write 'hi' or 'tell me a joke' or 'make an order' for testing...");
//         }
//     });
//     $botman->listen();
// }

// /**
//  * Ask the user for their name.
//  */
// public function askName($botman)
// {
//     $botman->ask('Hello! What is your name?', function(Answer $answer) {
//         $name = $answer->getText();
//         $this->say('Nice to meet you, '.$name);
//          $this->askForOrderDetails($botman);
//     });
// }

// /**
//  * Ask the user for order details.
//  */
// public function askForOrderDetails($botman)
// {
//     $botman->ask('What would you like to order?', function(Answer $answer){
//         $order = $answer->getText();
//         $botman->reply('You would like to order ');
//         // $this->askForConfirmation($botman);
//     });
// }

// /**
//  * Ask the user for confirmation of their order.
//  */
// public function askForConfirmation($botman)
// {
//     $question = Question::create("Is that correct?")
//                 ->addButtons([
//                     Button::create('Yes')->value('yes'),
//                     Button::create('No')->value('no'),
//                 ]);

//     $botman->ask($question, function(Answer $answer) use ($botman) {
//         if ($answer->isInteractiveMessageReply()) {
//             if ($answer->getValue() === 'yes') {
//                 $botman->reply('Great, your order will be processed.');
//             } else {
//                 $this->askForOrderDetails($botman);
//             }
//         }
//     });
// }
//----------------------------------------------------------------------------------------------//

public function handle()
{

   $botman = app('botman');

//     $botman->hears('My First Message', function ($bot) {
//     $bot->reply('Your First Response');
// });

//     $botman->hears('{message}', function($botman, $message) {
//         if ($message == 'hi') {
//             $this->askName($botman);
//         } else if ($message == 'help') {
//             $this->displayHelpMenu($botman);
//         } else if (stripos($message, 'weather') !== false) {
//             $this->askForLocation($botman);
//         } else if (stripos($message, 'news') !== false) {
//             $this->askForNewsCategory($botman);
//         } else {
//             $botman->reply("Sorry, I didn't understand what you said. Write 'hi' or 'help' or 'weather' or 'news' for testing...");
//         }
//     });

    //  $botman->listen();
// }

// /**
//  * Ask the user for their name.
//  */
// public function askName($botman)
// {
//     $botman->ask('Hello! What is your name?', function(Answer $answer){
//         $name = $answer->getText();
//         $botman->reply('Nice to meet you, '.$name);
//         $this->displayHelpMenu($botman);
//     });
// }

// /**
//  * Display the help menu.
//  */
// public function displayHelpMenu($botman)
// {
//     $botman->reply('Here are some things you can ask me:');
//     $botman->reply('- What is the weather like in a certain location?');
//     $botman->reply('- What are the latest news headlines in a certain category?');
// }

// /**
//  * Ask the user for their location.
//  */
// public function askForLocation($botman)
// {
//     $botman->ask('Where are you located?', function(Answer $answer) use ($botman) {
//          $location = $answer;
//         $botman->reply('Checking the weather for '.$location.'...');
//         $weatherData = $this->getWeatherData($location);
//         if (!$weatherData) {
//             $botman->reply('Sorry, I could not retrieve weather data for '.$location);
//         } else {
//             $botman->reply('The temperature in '.$location.' is '.$weatherData['temperature'].'°C, with '.$weatherData['description']);
//         }
//     });
// }

// /**
//  * Get weather data for a location.
//  */
// public function getWeatherData($location)
// {
//     // Use a weather API to retrieve weather data for the location
//     // ...
//     // Return an array containing the temperature and description
//     return [
//         'temperature' => '25',
//         'description' => 'partly cloudy',
//     ];
// }

// /**
//  * Ask the user for their news category.
//  */
// public function askForNewsCategory($botman)
// {
//     $question = Question::create('What type of news are you interested in?')
//                 ->addButtons([
//                     Button::create('Sports')->value('sports'),
//                     Button::create('Entertainment')->value('entertainment'),
//                     Button::create('Technology')->value('technology'),
//                     Button::create('Business')->value('business'),
//                 ]);
//     $botman->ask($question, function(Answer $answer) use ($botman) {
//         $category = $answer->getText();
//         $botman->reply('Here are the latest news headlines in '.$category.':');
//         $newsData = $this->getNewsData($category);
//         if (!$newsData) {
//             $botman->reply('Sorry, I could not retrieve news data for '.$category);
//         } else {
//             foreach ($newsData as $article)
//                     {
//             $botman->reply('- '.$article['title'].': '.$article['description'].' (Read more at '.$article['url'].')');
//         }
//     }
// });
// }

// /**
//  * Get news data for a category.
// */
// public function getNewsData($category)
// {
// // Use a news API to retrieve news data for the category
// // ...
// // Return an array containing the article titles, descriptions, and URLs
// return [
// [
// 'title' => 'New football stadium to be built in downtown area',
// 'description' => 'The city council has approved the construction of a new football stadium in the downtown area, which is expected to bring in more tourism and revenue for local businesses.',
// 'url' => 'https://example.com/article1',
// ],
// [
// 'title' => 'Movie studio announces new slate of superhero films',
// 'description' => 'The movie studio has unveiled its plans for the next phase of its superhero film franchise, which includes sequels to popular titles as well as new characters.',
// 'url' => 'https://example.com/article2',
// ],
// [
// 'title' => 'Tech giant unveils new product lineup at conference',
// 'description' => 'The tech giant has announced a range of new products and services at its annual conference, including updates to existing products as well as new offerings in emerging markets.',
// 'url' => 'https://example.com/article3',
// ],
// ];



//L'ets train here//

$botman->hears('My First Message', function ($bot) {
    $bot->reply('Your First Response');
});

  $botman->hears('Hi', function ($bot) {
    $bot->reply('Hello');
});

  $botman->hears('age', function ($bot) {
    $bot->reply('22');
});

$botman->hears('foo','App\Http\Controllers\MyBotCommands@handleFoo');








     //this line is required to make it work when we donot use botmanStudio//
     $botman->listen();



 }
}