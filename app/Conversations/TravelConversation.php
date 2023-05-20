<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class TravelConversation extends Conversation
{
    protected $travelOption;
    protected $departurePlace;
    protected $arrivalPlace;
    protected $travelers;
    protected $departureDate;
    protected $departureTime;
    protected $luggage;
    protected $travelPurpose;
    protected $equipment;
    protected $customerType;
    protected $email;
    protected $password;


    public function run()
    {
        $this->bot->typesAndWaits(2);
        $this->say('Bienvenue sur notre plateforme de réservation de voyages.');
        $this->askTravelOption();
    }

    public function askTravelOption()
    {
        $question = Question::create('Choisissez une option de voyage :')
            ->fallback('Option de voyage non valide')
            ->callbackId('select_travel_option')
            ->addButtons([
                Button::create('Aller-Simple')->value('aller_simple'),
                Button::create('Aller-Retour')->value('aller_retour'),
                Button::create('Circuit')->value('circuit'),
                Button::create('Transfert-aeroport')->value('transfert_aeroport'),
            ]);

            $this->bot->typesAndWaits(2);
            $this->ask($question, function (Answer $answer) {
            $this->travelOption = $answer->getValue();

            if ($this->travelOption === 'aller_simple') {
                // $this->bot->systemMessage('This is a system message');
                 $this->bot->typesAndWaits(2);
                $this->say("Vous avez sélectionné l'option *Aller-Simple*.");
                $this->askDeparturePlace();
            } else {
                $this->bot->typesAndWaits(2);
                $this->say('Option de voyage non implémentée pour le moment.');
            }
        });
    }

    public function askDeparturePlace()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Entrez le lieu de départ :', function (Answer $answer) {
            $departurePlace = $answer->getText();

            // Perform validation for departure place

            $this->departurePlace = $departurePlace;
            $this->confirmDeparturePlace();
        });
    }

    public function confirmDeparturePlace()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez entré "' . $this->departurePlace . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->askArrivalPlace();
            } else {
                $this->askDeparturePlace();
            }
        });
    }

  public function askArrivalPlace()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Entrez le lieu d\'arrivée :', function (Answer $answer) {
        $arrivalPlace = $answer->getText();

        // Perform validation for arrival place

        $this->arrivalPlace = $arrivalPlace;
        $this->confirmArrivalPlace();
    });
}

public function confirmArrivalPlace()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Vous avez entré "' . $this->arrivalPlace . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
        $confirmation = strtolower($answer->getText());

        if ($confirmation === 'oui') {
            $this->askTravelers();
        } else {
            $this->askArrivalPlace();
        }
    });
}

   public function askTravelers()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Combien de voyageurs ?', function (Answer $answer) {
        $travelers = $answer->getText();

        // Perform validation for number of travelers
        if (!is_numeric($travelers) || $travelers < 1) {
             $this->bot->typesAndWaits(2);
            $this->say('Le nombre de voyageurs doit être un nombre valide supérieur à 0.');
            $this->askTravelers();
            return;
        }

        $this->travelers = $travelers;
        $this->confirmTravelers();
    });
}

public function confirmTravelers()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Vous avez entré "' . $this->travelers . '" voyageur(s). Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
        $confirmation = strtolower($answer->getText());

        if ($confirmation === 'oui') {
            $this->askDepartureDate();
        } else {
            $this->askTravelers();
        }
    });
}


  public function askDepartureDate()
{
    $this->bot->typesAndWaits(2);
    $this->ask('Entrez la date de départ (JJ-MM-AAAA) :', function (Answer $answer) {
        $departureDate = $answer->getText();

        // Perform validation for departure date
        $dateParts = explode('-', $departureDate);
        if (count($dateParts) !== 3 || !checkdate($dateParts[1], $dateParts[0], $dateParts[2])) {
            $this->bot->typesAndWaits(2);
            $this->say('Le format de la date est invalide. Veuillez entrer une date au format JJ-MM-AAAA.');
            $this->askDepartureDate();
            return;
        }

        // Check if departure date is greater than current date
        $currentDate = date('Y-m-d'); // Get the current date
        $departureTimestamp = strtotime($departureDate);
        $currentTimestamp = strtotime($currentDate);

        if ($departureTimestamp <= $currentTimestamp) {
            $this->bot->typesAndWaits(2);
            $this->say('La date de départ doit être supérieure à la date actuelle.');
            $this->askDepartureDate();
            return;
        }

        $this->departureDate = $departureDate;
        $this->confirmDepartureDate();
    });
}


    public function confirmDepartureDate()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez entré la date de départ "' . $this->departureDate . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->askDepartureTime();
            } else {
                $this->askDepartureDate();
            }
        });
    }

    public function askDepartureTime()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('À quelle heure souhaitez-vous partir ? (HH:MM)', function (Answer $answer) {
            $departureTime = $answer->getText();

            // Perform validation for departure time
            if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $departureTime)) {
                $this->bot->typesAndWaits(2);
                $this->say('Le format de l\'heure de départ est invalide. Veuillez entrer une heure au format HH:MM (par exemple, 09:30).');
                $this->askDepartureTime();
                return;
            }

            $this->departureTime = $departureTime;
            $this->confirmDepartureTime();
        });
    }

    public function confirmDepartureTime()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez entré l\'heure de départ "' . $this->departureTime . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->askLuggage();
            } else {
                $this->askDepartureTime();
            }
        });
    }

    //pour le Bagage
    public function askLuggage()
    {
        $question = Question::create('Sélectionnez le type de bagages :')
            ->fallback('Type de bagages non valide')
            ->callbackId('select_luggage')
            ->addButtons([
                Button::create('Valise classique')->value('valise_classique'),
                Button::create('Grande valise')->value('grande_valise'),
                Button::create('Bagage volumineux')->value('bagage_volumineux'),
                Button::create('Matériel de surf')->value('materiel_surf'),
                Button::create('Matériel de golf')->value('materiel_golf'),
                Button::create('Pas de bagage')->value('pas_de_bagage'),
            ]);

        $this->bot->typesAndWaits(2);
        $this->ask($question, function (Answer $answer) {
            $this->luggage = $answer->getValue();
            $this->confirmLuggage();
        });
    }

    public function confirmLuggage()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez sélectionné "' . $this->getLuggageLabel($this->luggage) . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->askTravelPurpose();
            } else {
                $this->askLuggage();
            }
        });
    }

    public function getLuggageLabel($luggage)
    {
        switch ($luggage) {
            case 'valise_classique':
                return 'Valise classique';
            case 'grande_valise':
                return 'Grande valise';
            case 'bagage_volumineux':
                return 'Bagage volumineux';
            case 'materiel_surf':
                return 'Matériel de surf';
            case 'materiel_golf':
                return 'Matériel de golf';
            case 'pas_de_bagage':
                return 'Pas de bagage';
            default:
                return '';
        }
    }

    public function askTravelPurpose()
    {
        $question = Question::create('Sélectionnez le motif du voyage :')
            ->fallback('Motif du voyage non valide')
            ->callbackId('select_travel_purpose')
            ->addButtons([
                Button::create('Déplacement sportif')->value('deplacement_sportif'),
                Button::create('Mariage ou cérémonie')->value('mariage_ceremonie'),
                Button::create('Groupe d’étudiants')->value('groupe_etudiants'),
                Button::create('Groupe de touristes')->value('groupe_touristes'),
                Button::create('Groupe de touriste non résidant')->value('groupe_touriste_non_residant'),
            ]);

        $this->bot->typesAndWaits(2);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
            $this->travelPurpose = $answer->getValue();
            $this->confirmTravelPurpose();
            }
        });
    }

    public function confirmTravelPurpose()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez sélectionné "' . $this->getTravelPurposeLabel($this->travelPurpose) . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->askEquipment();
            } else {
                $this->askTravelPurpose();
            }
        });
    }

    public function getTravelPurposeLabel($purpose)
    {
        switch ($purpose) {
            case 'deplacement_sportif':
                return 'Déplacement sportif';
            case 'mariage_ceremonie':
                return 'Mariage ou cérémonie';
            case 'groupe_etudiants':
                return 'Groupe d’étudiants';
            case 'groupe_touristes':
                return 'Groupe de touristes';
            case 'groupe_touriste_non_residant':
                return 'Groupe de touriste non résidant';
            default:
                return '';
        }
    }

    public function askEquipment()
    {
        $question = Question::create('Sélectionnez les équipements nécessaires :')
            ->fallback('Équipements non valides')
            ->callbackId('select_equipment')
            ->addButtons([
                Button::create('Micro audio')->value('micro_audio'),
                Button::create('Siège bébé')->value('siege_bebe'),
                Button::create('Glacière')->value('glaciere'),
            ]);

        $this->bot->typesAndWaits(2);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
            $this->equipment = $answer->getValue();
            $this->confirmEquipment();
            }
        });
    }

    public function confirmEquipment()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez sélectionné "' . $this->getEquipmentLabel($this->equipment) . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->askCustomerType();
            } else {
                $this->askEquipment();
            }
        });
    }

    public function getEquipmentLabel($equipment)
    {
        switch ($equipment) {
            case 'micro_audio':
                return 'Micro audio';
            case 'siege_bebe':
                return 'Siège bébé';
            case 'glaciere':
                return 'Glacière';
            default:
                return '';
        }
    }

    public function askCustomerType()
    {
        $question = Question::create('Sélectionnez le type de client :')
            ->fallback('Type de client non valide')
            ->callbackId('select_customer_type')
            ->addButtons([
                Button::create('Particulier')->value('particulier'),
                Button::create('Société')->value('societe'),
            ]);

        $this->bot->typesAndWaits(2);
        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
            $this->customerType = $answer->getValue();
            $this->confirmCustomerType();
            }
        });
    }

    public function confirmCustomerType()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Vous avez sélectionné "' . $this->customerType . '". Confirmez-vous ? (Oui/Non)', function (Answer $answer) {
            $confirmation = strtolower($answer->getText());

            if ($confirmation === 'oui') {
                $this->finishTravel();
            } else {
                $this->askCustomerType();
            }
        });
    }


    public function finishTravel()
    {
        // Generate and display the travel summary based on the captured information
        $this->bot->typesAndWaits(2);
        $this->say('Merci pour votre demande de voyage. Nous traiterons votre demande dans les plus brefs délais.');
       $this->DisplayallInfo();
        $this->askIfHasAccount();
    }

 public function DisplayallInfo()
{
    $message = "*Récapitulatif du voyage :*<br/><br/>";
    $message .= "*Option de voyage :* " . $this->travelOption . "<br/>";
    $message .= "*Lieu de départ :* " . $this->departurePlace . "<br/>";
    $message .= "*Lieu d'arrivée :* " . $this->arrivalPlace . "<br/>";
    $message .= "*Nombre de voyageurs :* " . $this->travelers . "<br/>";
    $message .= "*Date de départ :* " . $this->departureDate . "<br/>";
    $message .= "*Heure de départ :* " . $this->departureTime . "<br/>";
    $message .= "*Type de bagages :* " . $this->getLuggageLabel($this->luggage) . "<br/>";
    $message .= "*Motif du voyage :* " . $this->getTravelPurposeLabel($this->travelPurpose) . "<br/>";
    $message .= "*Équipements nécessaires :* " . $this->getEquipmentLabel($this->equipment) . "<br/>";
    $message .= "*Type de client :* " . $this->customerType . "<br/>";
    $this->bot->typesAndWaits(2);
    $this->say($message, ['parse_mode' => 'Markdown']);
}



    public function askIfHasAccount()
    {
        $question = Question::create('Avez-vous un compte ?')
            ->fallback('Impossible de déterminer si vous avez un compte.')
            ->callbackId('check_account')
            ->addButtons([
                Button::create('Oui')->value('yes'),
                Button::create('Non')->value('no'),
            ]);

            $this->bot->typesAndWaits(2);
            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
            $response = $answer->getValue();

            if ($response === 'yes') {
                $this->askForCredentials();
            } else {
                $this->createAccount();
            }
        }
        });
    }

        public function askForCredentials()
        {
            $this->askEmail();
        }

        public function askEmail()
        {
            $this->bot->typesAndWaits(2);
            $this->ask('Veuillez entrer votre email :', function (Answer $answer) {
              $this->email = $answer->getText();

                if ($this->validateEmail($this->email)) {
                    $this->askPassword();
                } else {
                     $this->bot->typesAndWaits(2);
                    $this->say('L\'email que vous avez saisi est invalide. Veuillez entrer une adresse email valide.');
                    $this->askEmail();
                }
            });
        }

        public function validateEmail($email)
        {
            // Regular expression pattern to validate email structure
            $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

            // Check if the email matches the pattern
            if (preg_match($pattern, $email)) {
                $this->bot->typesAndWaits(2);
                $this->say("email is valide");
                return true; // Email is valid
            } else {
                return false; // Email is invalid
            }
        }


    public function askPassword()
    {
        $this->bot->typesAndWaits(2);
        $this->ask('Veuillez entrer votre mot de passe :', function (Answer $answer) {
            $this->password = $answer->getText();

            if (strlen( $this->password ) >= 8) {
                $this->validateCredentials($this->email, $this->password);
            } else {
                $this->bot->typesAndWaits(2);
                $this->say('Le mot de passe doit contenir au moins 8 caractères. Veuillez entrer un mot de passe valide.');
                $this->askPassword();
            }
        });
    }

    public function validateCredentials($email, $password)
    {
        $credentialsAreValid=false;
        // Validate the email and password
        if($email == "mail@gmail.com" && $password == "password"){
            $credentialsAreValid=true;
        }
        // Check if the email exists in the database and if the password matches the email

        if ($credentialsAreValid) {
            // Proceed with the travel conversation
            // $this->askTravelType();
            $this->bot->typesAndWaits(2);
            $this->say("welcome to your account.");
        } else {
            $this->bot->typesAndWaits(2);
            $this->say('Les informations d\'identification que vous avez fournies sont incorrectes. Veuillez réessayer.');
            $this->askForCredentials();
        }
    }



    public function createAccount()
    {
        // Code to handle creating a new account for the user
        $this->bot->typesAndWaits(2);
        $this->say('create Account functionality not implemanted yet..!!!!!');
        // Proceed with the travel conversation
        // $this->askTravelType();
    }



}
