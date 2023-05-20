<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;

use App\Conversations\TravelConversation;
use App\Conversations\Order3;
use App\Conversations\MainMenu;
use Termwind\Components\Element;
use App\Conversations\OrderConversation;
use BotMan\BotMan\Messages\Incoming\Answer;

use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Outgoing\Question;


//for the conversation
use BotMan\BotMan\Messages\Attachments\Carousel;
use BotMan\BotMan\Messages\Attachments\Attachment;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;


use BotMan\BotMan\Messages\Outgoing\Actions\Select;
use BotMan\BotMan\Messages\Attachments\CarouselItem;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;


 class BotManController extends Controller
 {

  public function handle()
 {

   $botman = app('botman');




 $botman->hears('voyage', function (BotMan $bot) {
            $bot->startConversation(new TravelConversation());
        });


 //L'ets train here//
 $botman->hears('Order3', function (BotMan $bot) {
            $bot->startConversation(new Order3());
        });


    $botman->hears('call me {name} ok', function ($bot, $name) {
        $bot->typesAndWaits(2)
            ->reply('Ok Your name is: '.$name);
    });

    $botman->hears('call me {name} the {adjective}', function ($bot, $name, $adjective) {
        $bot->typesAndWaits(2)
            ->reply('Hello '.$name.'. You truly are '.$adjective);
    });


    $botman->hears('I want ([0-9]+) ok', function ($bot, $number) {
        $bot->typesAndWaits(2)
            ->reply('You will get: '.$number);
    });

    $botman->hears('I want ([0-9]+) ', function ($bot, $number) {
        $bot->typesAndWaits(2)
            ->reply('You will get: '.$number);
    });

    $botman->hears('I want ([0-9]+) portions of (Cheese|Cake)', function ($bot, $amount, $dish) {
        $bot->typesAndWaits(2)
            ->reply('You will get '.$amount.' portions of '.$dish.' served shortly.');
    });

    $botman->hears('.*Bonjour.*', function ($bot) {
        $bot->typesAndWaits(2)
            ->reply('Nice to meet you!');
        $bot->typesAndWaits(2)
            ->receivesImages(function($bot, $images) {

        foreach ($images as $image) {
            $url = $image->getUrl(); // The direct url
            $title = $image->getTitle(); // The title, if available
            $payload = $image->getPayload(); // The original payload
        }
    });
    });


//replay with images

$botman->hears('image', function (BotMan $bot) {
    // Create attachment
    $attachment = new Image('https://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RE55U7F');
    // $attachment = new Image('https://botman.io/img/logo.png');

    // Build message object
    $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

$botman->hears('image2', function (BotMan $bot) {
    // Create attachment
    $attachment = new Image('https://images.hdqwalls.com/download/sunrises-and-sunsets-scenery-grass-hill-5k-pk-1920x1080.jpg');
    // $attachment = new Image('https://botman.io/img/logo.png');

    // Build message object
    $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

$botman->hears('image3', function (BotMan $bot) {
    // Create attachment
    $attachment = new Image('https://i.pinimg.com/originals/3d/08/e0/3d08e03cb40252526fee2036a67f07f1.gif');
    // $attachment = new Image('https://botman.io/img/logo.png');

    // Build message object
    $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

$botman->hears('image4', function (BotMan $bot) {
    // Create attachment
    $attachment = new Image('https://www.lovethispic.com/uploaded_images/231116-Nice.gif');
    // $attachment = new Image('https://botman.io/img/logo.png');

    // Build message object
    $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

$botman->hears('image5', function (BotMan $bot) {
    // Create attachment
    $attachment = new Image('https://my-media.apjonlinecdn.com/magefan_blog/5_Components_Of_A_Computer_And_Their_Benefits.jpg');
    // $attachment = new Image('https://botman.io/img/logo.png');

    // Build message object
    $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

$botman->hears('image1', function (BotMan $bot) {
    // Create attachment
     $attachment = new Image('https://botman.io/img/logo.png');

    // Build message object
    $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

  $botman->hears('image7', function (BotMan $bot) {
    // Create attachment
     $attachment = new Image('https://5.imimg.com/data5/SELLER/Default/2022/12/BQ/VL/ON/60122989/dell-desktop-computer-1000x1000.jpg');

    // Build message object
    $message = OutgoingMessage::create('image7')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

$botman->hears('image8', function (BotMan $bot) {
    // Create attachment
     $attachment = new Image('https://ajicod.com/media/img/robot.svg');

    // Build message object
    $message = OutgoingMessage::create('just an image')
                ->withAttachment($attachment);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});

    $botman->hears('image9', function (BotMan $bot) {
        // Create attachment
        $attachment = new Image('https://ajicod.com/media/img/ajicod_institute_ar.svg');

        // Build message object
        $message = OutgoingMessage::create('just an image')
                    ->withAttachment($attachment);

        // Reply message object
        $bot->typesAndWaits(2)
            ->reply($message);
    });

$botman->hears('image10', function (BotMan $bot) {
    // Create attachment
    $attachment = new Image('https://ajicod.com/media/img/ajicod_institute_ar.svg');

    // Build message object
    $message = OutgoingMessage::create('just an image')
                ->withAttachment($attachment);

    // Modify HTML tag attributes
    $message->setAdditionalParameters([
        'imageAttributes' => [
            'style' => 'width:300px;height:200px;',
        ],
    ]);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});


    $botman->hears('video attachment', function (BotMan $bot) {
        // Create attachment
        $attachment = new Video('https://samplelib.com/lib/preview/mp4/sample-5s.mp4');

        // Build message object
        $video = OutgoingMessage::create('Our video')
                    ->withAttachment($attachment);

        // Reply message object
        $bot->typesAndWaits(2)
            ->reply($video);
    });




    $botman->hears('audio', function (BotMan $bot) {
        // Create attachment
    $attachment = new Audio('https://file-examples.com/storage/fe0d875dfd645260e96b346/2017/11/file_example_MP3_700KB.mp3');
        // Build message object
        $message = OutgoingMessage::create('This is my text')
                    ->withAttachment($attachment);

        // Reply message object
        $bot->typesAndWaits(2)
            ->reply($message);
    });

$botman->fallback(function($bot) {
    $bot->typesAndWaits(2)
        ->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...not set yet');
});



    $botman->hears('Order3', function (BotMan $bot) {
                $bot->startConversation(new Order3());
            });

    $botman->hears('Order', function (BotMan $bot) {
                $bot->typesAndWaits(2)
            ->startConversation(new OrderConversation());
            });

    $botman->hears('Hi', function (BotMan $bot) {
        $bot->typesAndWaits(2)->startConversation(new MainMenu());
     });

    $botman->hears('dropdown', function (BotMan $bot) {
        $question = Question::create('Select an option:')
            ->addButtons([
                Button::create('Option 1')->value('option_1'),
                Button::create('Option 2')->value('option_2'),
                Button::create('Option 3')->value('option_3'),
            ]);

    $bot->typesAndWaits(2)
        ->ask($question, function (Answer $answer) {
        if ($answer->isInteractiveMessageReply()) {
            $selectedOption = $answer->getValue();
            // Handle the selected option
            $this->say('You selected: ' . $selectedOption);
        }
    });
  });

    $botman->hears('dropdown1', function (BotMan $bot) {
        // Create a dropdown
        $dropdown = Select::create('Select an option')
            ->options([
                Button::create('Option 1')->value('option_1'),
                Button::create('Option 2')->value('option_2'),
                Button::create('Option 3')->value('option_3'),
            ]);

    // Build message object
    $message = OutgoingMessage::create('Here is a dropdown:')
        ->withAttachment($dropdown);

    // Reply message object
    $bot->typesAndWaits(2)
        ->reply($message);
});


     //this line is required to make it work when we donot use botmanStudio//
     $botman->listen();

}
}
