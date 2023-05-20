<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class OrderConversation extends Conversation
{
    protected $order = [];
    protected $products = [
        'pen' => [
            'price' => 5,
            'stock' => 10,
            'img' => "https://fountainpenlove.com/wp-content/uploads/2020/06/expensive-versus-inexpensive-fountain-pen-difference-2.jpg",
        ],
        'notebook' => [
            'price' => 10,
            'stock' => 5,
            'img' => "https://www.thestationerycompany.pk/cdn/shop/products/dotted.png?v=1663846035",
        ],
        'pencil' => [
            'price' => 2,
            'stock' => 20,
            'img' => "https://sdcdn.io/mac/ae/mac_sku_M38022_1x1_0.png?width=1080&height=1080",
        ],
    ];
    protected $name;
    protected $phoneNumber;
    protected $city;
    protected $address;

 public function askName()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Nom complet de votre client?', function (Answer $answer) {
        $name = $answer->getText();

        $nameParts = explode(' ', $name);
        $numNameParts = count($nameParts);

        if (strlen($name) < 5 || $numNameParts < 2) {
            $this->bot->typesAndWaits(2);
            $this->say('Le nom doit être composé de deux parties minimum séparées par un espace.');
            $this->askName();
        } else {
            $this->name = $name;
            $this->askNameConfirmation();
        }
    });
}


public function askNameConfirmation()
{
    $question = Question::create('confirmer nome de client: "'.$this->name.'"')
        ->fallback('Impossible de confirmer la nome')
        ->callbackId('confirm_name');

    $question->addButton(Button::create('Oui')->value('yes'));
    $question->addButton(Button::create('Non')->value('no'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $response = $answer->getValue();

        if ($response === 'yes') {
           $this->askPhoneNumber();
        } else {
            $this->askName();
        }
    });
}


        public function validatePhoneNumber($phoneNumber)
    {
        // Check if the phone number is a valid 10-digit number
        if (preg_match('/^\d{10}$/', $phoneNumber)) {
            return true; // Valid phone number
        } else {
            return false; // Invalid phone number
        }
    }


    public function askPhoneNumber()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Tél:', function (Answer $answer) {
            $phoneNumber = $answer->getText();

            if ($this->validatePhoneNumber($phoneNumber)) {
                $this->phoneNumber = $phoneNumber;
                $this->askPhoneNumberConfirmation();
            } else {
                $this->bot->typesAndWaits(2);
                $this->say('Numéro de téléphone invalide. Veuillez entrer un numéro de téléphone valide.');
                $this->askPhoneNumber();
            }
        });
    }


public function askPhoneNumberConfirmation()
{
    $question = Question::create('confirmer Numéro de téléphone: "'. $this->phoneNumber.'"')
        ->fallback('Impossible de confirmer Numéro de téléphone')
        ->callbackId('confirm_phone');

    $question->addButton(Button::create('Oui')->value('yes'));
    $question->addButton(Button::create('Non')->value('no'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $response = $answer->getValue();

        if ($response === 'yes') {
           $this->askCity();
        } else {
            $this->askPhoneNumber();
        }
    });
}


    public function askCity()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Ville:', function (Answer $answer) {
            $this->city = $answer->getText();
            $this->askCityConfirmation();
        });
    }



public function askCityConfirmation()
{
    $question = Question::create('confirmer Ville: "'. $this->city.'"')
        ->fallback('Impossible de confirmer Ville')
        ->callbackId('confirm_city');

    $question->addButton(Button::create('Oui')->value('yes'));
    $question->addButton(Button::create('Non')->value('no'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $response = $answer->getValue();

        if ($response === 'yes') {
           $this->askAddress();
        } else {
            $this->askAddress();
        }
    });
}

    public function askAddress()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Adresse:', function (Answer $answer) {
            $this->address = $answer->getText();
            $this->askAddressConfirmation();
        });
    }



public function askAddressConfirmation()
{
    $question = Question::create('confirmer Address: "'. $this->address.'"')
        ->fallback('Impossible de confirmer Address')
        ->callbackId('confirm_address');

    $question->addButton(Button::create('Oui')->value('yes'));
    $question->addButton(Button::create('Non')->value('no'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $response = $answer->getValue();

        if ($response === 'yes') {
           $this->askProduct();
        } else {
            $this->askAddress();
        }
    });
}
    //her is ask for product
    public function askProduct()
    {
        $question = Question::create('Choiser un produit:')
            ->fallback('Impossible de sélectionner un produit')
            ->callbackId('select_product');

        foreach ($this->products as $product => $details) {
            $price = $details['price'];
            $stock = $details['stock'];

            if ($stock > 0) {
                $question->addButton(
                    Button::create($product . ' ($' . $price . ', Stock: ' . $stock . ')')->value($product)
                );
            }
        }

        $this->bot->typesAndWaits(2);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply() ) {
                $product = $answer->getValue();
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


    public function askQuantity($product)
    {
        $details = $this->products[$product];
        $price = $details['price'];
        $stock = $details['stock'];
        $image = $details['img'];

        $this->bot->typesAndWaits(2);
        $this->ShowImage($product,$image);
        $this->ask('Donner la quantité (' . $product . ') (Stock: ' . $stock . '):', function (Answer $answer) use ($product, $price, $stock) {
        $quantity = (int) $answer->getText();

        if ($quantity <= $stock) {
            $this->addToOrder($product, $quantity);
            $this->products[$product]['stock'] -= $quantity;

            $this->bot->typesAndWaits(2);
            $this->say($product . ' (' . $quantity . ') ajouté à votre commande.');

            $this->askAnotherProduct();
        } else {
            $this->bot->typesAndWaits(2);
            $this->say('Désolé, il n\'y a pas suffisamment de stock disponible. Veuillez entrer une quantité inférieure ou égale au stock restant de ' . $stock);
            $this->askQuantity($product);
        }
    });
}


public function askAnotherProduct()
{
    $question = Question::create('Voulez-vous ajouter un autre produit?')
        ->fallback('Impossible de confirmer ajouter un autre produit')
        ->callbackId('confirm_ajouter');

    $question->addButton(Button::create('Oui')->value('yes'));
    $question->addButton(Button::create('Non')->value('no'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
         if ($answer->isInteractiveMessageReply() ) {
        $response = $answer->getValue();
        if ($response === 'yes') {
           $this->askProduct();
        } else {
            $this->showOrderSummary();
            $this->askConfirmation();
        }
    }
    });
}

public function askConfirmation()
{
    $question = Question::create('La commande est-elle correcte?')
        ->fallback('Impossible de confirmer la commande')
        ->callbackId('confirm_order');

    $question->addButton(Button::create('Oui')->value('yes'));
    $question->addButton(Button::create('Annuler')->value('no'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $response = $answer->getValue();

        if ($response === 'yes') {
            $this->askDeliveryMethod();
        } else {
            $this->bot->typesAndWaits(2);
            $this->say('Commande annulée. Si vous avez d\'autres questions, n\'hésitez pas à demander.');
            // Perform any necessary cleanup or actions for order cancellation
            // You can reset variables, clear the order, or take any other required steps
        }
    });
}

public function askDeliveryMethod()
{
$question = Question::create('Comment souhaitez-vous recevoir les produits?')
->fallback('Impossible de sélectionner une méthode de livraison')
->callbackId('delivery_method');


    $question->addButton(Button::create('Mes livreurs')->value('my_drivers'));
    $question->addButton(Button::create('Société de livraison')->value('delivery_company'));
    $question->addButton(Button::create('Autre Livreur')->value('other_driver'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $response = $answer->getValue();

        switch ($response) {
            case 'my_drivers':
                $this->askMyDriver();
                break;
            case 'delivery_company':
                $this->askDeliveryCompany();
                break;
            case 'other_driver':
                $this->askOtherDriver();
                break;
            default:
                $this->bot->typesAndWaits(2);
            $this->say('Option invalide. Veuillez sélectionner une option valide.');
                $this->askDeliveryMethod();
                break;
        }
    });
}

public function askMyDriver()
{
    $question = Question::create('Veuillez sélectionner votre livreur:')
        ->fallback('Impossible de sélectionner le livreur')
        ->callbackId('my_driver');

    // Add your logic to retrieve and populate the drivers' list

    $question->addButton(Button::create('Livreur 1')->value('driver1'));
    $question->addButton(Button::create('Livreur 2')->value('driver2'));
    $question->addButton(Button::create('Livreur 3')->value('driver3'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $driver = $answer->getValue();
        // Process the selected driver

        $this->bot->typesAndWaits(2);
        $this->say('Merci pour votre commande! Nous avons reçu votre demande et la traiterons sous peu.');

    });
}

public function askDeliveryCompany()
{
    $question = Question::create('Veuillez sélectionner une société de livraison:')
        ->fallback('Impossible de sélectionner une société de livraison')
        ->callbackId('delivery_company');

    // Add your logic to retrieve and populate the delivery companies' list

    $question->addButton(Button::create('Société 1')->value('company1'));
    $question->addButton(Button::create('Société 2')->value('company2'));
    $question->addButton(Button::create('Société 3')->value('company3'));

    $this->bot->typesAndWaits(2);
    $this->ask($question, function (Answer $answer) {
        $company = $answer->getValue();
        // Process the selected delivery company
        $this->bot->typesAndWaits(2);
        $this->say('Merci pour votre commande! Nous avons reçu votre demande et la traiterons sous peu.');

    });
}

public function askOtherDriver()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Veuillez entrer le numéro du livreur:', function (Answer $answer) {
        $driverNumber = $answer->getText();
        // Process the entered driver number
        $this->bot->typesAndWaits(2);
        $this->say('Merci pour votre commande! Nous avons reçu votre demande et la traiterons sous peu.');

    });
}

public function askComment()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Veuillez ajouter un commentaire (facultatif):', function (Answer $answer) {
        $comment = $answer->getText();
        // Process the entered comment
        $this->bot->typesAndWaits(2);
        $this->say('Merci pour votre commande! Nous avons reçu votre demande et la traiterons sous peu.');

    });
}


public function showOrderSummary()
{
    $message = '<br/>****** Order Summary ******' . PHP_EOL;
    // $message = '<br/>Order Summary:' . PHP_EOL;

    $message .= '<br/>Name: ' . $this->name . PHP_EOL;
    $message .= '<br/>City: ' . $this->city . PHP_EOL;
    $message .= '<br/>Phone Number: ' . $this->phoneNumber . PHP_EOL;

    foreach ($this->order as $product => $quantity) {
        $price = $this->products[$product]['price'];
        $subtotal = $price * $quantity;
        $message .='<br/>'. $product . ' (' . $quantity . '): $' . $subtotal . PHP_EOL;
    }

    $total = $this->calculateTotal();
    $message .= '<br/>Total: $' . $total . PHP_EOL;

    $this->bot->typesAndWaits(2);
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


  function ShowImage($description,$image) {
    $attachment = new Image($image);
    // Build message object
    $message = OutgoingMessage::create($description)->withAttachment($attachment);
    // Reply message object
    $this->bot->typesAndWaits(2)->reply($message);

    }


public function run()
{
    $this->askName();
}

}


