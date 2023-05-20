<?php
namespace App\Conversations;

use App\Conversations\OrderConversation;
use App\Conversations\TravelConversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\Question;


use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;


class MainMenu extends Conversation
{
    protected $CommanQuestions = [
        'Place an order' ,
        'Envie de voyager ?' ,
        'Payment and voucher inquiry' ,
        'Another general inquiry' ,
        'Order related inquiry' ,
    ];

    public function askUserToSelectQuestion()
    {
        $Listquestions = Question::create('What can I help you with?')
            ->fallback('Unable to select a question')
            ->callbackId('select_question');

        foreach ($this->CommanQuestions as $question) {
            $Listquestions->addButton(
                Button::create($question)->value($question)
            );
        }

            $this->bot->typesAndWaits(2);
            $this->ask($Listquestions, function (Answer $answer) {
             $userQuestion = $answer->getValue();

             if($userQuestion===$this->CommanQuestions[0]){
                $this->bot->typesAndWaits(2);
                $this->ShowImage("Commencez votre commande.","https://st4.depositphotos.com/11574170/30286/v/600/depositphotos_302863018-stock-illustration-trolley-glyph-colour-vector-icon.jpg");
                $this->bot->startConversation(new OrderConversation());
             } else if($userQuestion===$this->CommanQuestions[1]) {
                $this->bot->typesAndWaits(2);
                $this->ShowImage("réservation de voyages.","https://ih1.redbubble.net/image.3034276974.0528/fposter,small,wall_texture,product,750x1000.jpg");
                $this->bot->startConversation(new TravelConversation());

            }else {
                $this->bot->typesAndWaits(2);
                $this->say('This option not implemanted yet!!!');
            }
        });

    }

   function ShowImage($description,$image) {
    $attachment = new Image($image);
    // Build message object
    $message = OutgoingMessage::create($description)->withAttachment($attachment);
    // Reply message object
    $this->bot->typesAndWaits(2)->reply($message);

    }


    // function addScript(){
    //         // PHP code to determine if input should be disabled or enabled
    // $disableInput = true;

    // // Generate JavaScript code dynamically based on the PHP variable
    // $jsCode = '';
    // if ($disableInput) {
    //     $jsCode .= 'document.getElementById("userText").disabled = true;';
    //     $jsCode .= 'document.getElementById("userText").value = "You cannot type now";';
    // } else {
    //     $jsCode .= 'document.getElementById("userText").disabled = false;';
    //     $jsCode .= 'document.getElementById("userText").value = "";';
    // }

    // // Output the JavaScript code within a <script> tag
    // echo '<script>';
    // echo $jsCode;
    // echo '</script>';

    // }


public function run()
{
    $this->askUserToSelectQuestion();
}
}
