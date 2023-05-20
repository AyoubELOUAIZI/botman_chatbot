<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;


class Order3 extends Conversation
{
    protected $order = [];
    protected $products = [
        'pen' => [
            'price' => 5,
            'stock' => 10,
        ],
        'notebook' => [
            'price' => 10,
            'stock' => 5,
        ],
        'pencil' => [
            'price' => 2,
            'stock' => 20,
        ],
    ];
    protected $name;
    protected $city;
    protected $phoneNumber;

    public function askName()
    {
        $this->bot->typesAndWaits(2);
        $this->bot->typesAndWaits(2);
        $this->ask('What is your name?', function (Answer $answer) {
            $this->name = $answer->getText();
            $this->askCity();
        });
    }

    public function askCity()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Which city are you located in?', function (Answer $answer) {
            $this->city = $answer->getText();
            $this->askPhoneNumber();
        });
    }

    public function askPhoneNumber()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Please enter your phone number:', function (Answer $answer) {
            $phoneNumber = $answer->getText();

            if ($this->validatePhoneNumber($phoneNumber)) {
                $this->phoneNumber = $phoneNumber;
                $this->askProduct();
            } else {
                $this->bot->typesAndWaits(2);
                $this->say('Invalid phone number. Please enter a valid 10-digit phone number.');
                $this->askPhoneNumber();
            }
        });
    }

    public function askProduct()
    {
        $question = Question::create('Select a product:')
            ->fallback('Unable to select a product')
            ->callbackId('select_product');

        foreach ($this->products as $product => $details) {
            $price = $details['price'];
            $stock = $details['stock'];

            $question->addButton(
                Button::create($product . ' ($' . $price . ', Stock: ' . $stock . ')')->value($product)
            );
        }

        $question->addButton(
            Button::create('Finish Order')->value('cancel'),
        );
        $this->bot->typesAndWaits(2);
        $this->ask($question, function (Answer $answer) {
            $product = $answer->getValue();

            if ($product === 'cancel') {
                $this->bot->typesAndWaits(2);
                $this->say('Order canceled.');
                $this->showOrderSummary();
            } else {
                $this->askQuantity($product);
            }
        });
    }

    public function askQuantity($product)
    {
        $details = $this->products[$product];
        $price = $details['price'];
        $stock = $details['stock'];

        $this->bot->typesAndWaits(2);
        $this->ask('How many ' . $product . 's would you like? (Stock: ' . $stock . ')', function (Answer $answer) use ($product, $price, $stock) {
            $quantity = (int) $answer->getText();

            if ($quantity <= $stock) {
                $this->addToOrder($product, $quantity);
                $this->products[$product]['stock'] -= $quantity;

                $this->say($product . ' (' . $quantity . ') added to your order.');

                $this->askProduct();
            } else {
                $this->bot->typesAndWaits(2);
                $this->say('Sorry, thereSorry, there is not enough stock available. Please enter a quantity less than or equal to the remaining stock of ' . $stock);
                 $this->askQuantity($product);
}
});
}

public function addToOrder($product, $quantity)
{
    if (array_key_exists($product, $this->order)) {
        $this->order[$product] += $quantity;
    } else {
        $this->order[$product] = $quantity;
    }
}

public function showOrderSummary()
{
    $message = 'Order Summary:' . PHP_EOL;

    $message .= '<br/>Name: ' . $this->name . PHP_EOL;
    $message .= '<br/>City: ' . $this->city . PHP_EOL;
    $message .= '<br/>Phone Number: ' . $this->phoneNumber . PHP_EOL;

    foreach ($this->order as $product => $quantity) {
        $price = $this->products[$product]['price'];
        $subtotal = $price * $quantity;
        $message .= '<br/>'.$product . ' (' . $quantity . '): $' . $subtotal . PHP_EOL;
    }

    $total = $this->calculateTotal();
    $message .= '<br/>Total: $' . $total . PHP_EOL;



    $this->say($message);
}

public function calculateTotal()
{
    $total = 0;
    foreach ($this->order as $product => $quantity) {
        $price = $this->products[$product]['price'];
        $total += $price * $quantity;
    }

    return $total;
}

public function validatePhoneNumber($phoneNumber)
{
    // Add your phone number validation logic here
    // For simplicity, we'll assume any 10-digit number is valid
    return preg_match('/^\d{10}$/', $phoneNumber);
}


public function finishOrder()
{
        $this->bot->typesAndWaits(2);
    $this->ask('Would you like to proceed with the order?', function (Answer $answer) {
        $response = strtolower($answer->getText());

        if ($response === 'yes' || $response === 'y') {
            // Process the order
            $this->placeOrder();
        } else {
    $this->bot->typesAndWaits(2);
            $this->say('Order canceled. If you have any further questions, feel free to ask.');
        }
    });
}

public function placeOrder()
{
    // Logic to place the order and perform any necessary actions
    // You can add your own implementation here

    $this->bot->typesAndWaits(2);
    $this->say('Thank you for your order! We have received your request and will process it shortly.');
    $this->bot->typesAndWaits(2);
    $this->say('Your order details:');
    $this->showOrderSummary();
    $this->bot->typesAndWaits(2);
    $this->say('If you have any further questions, feel free to ask.');
}


public function run()
{
    $this->askName();
}
}
