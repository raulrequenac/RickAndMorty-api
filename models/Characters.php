<?php

namespace RickAndMorty;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Url as UrlValidator;
use Phalcon\validation\Validator\Date as DateValidator;

class Characters extends Model
{
  public $type;
  public $origin;
  public $location;
  public $episode;

  public function validation()
  {
    $validator = new Validation();

    $validator->add(
      'id',
      new Uniqueness(
        [
          'field'   => 'id',
          'message' => 'The id must be unique',
        ]
      )
    );

    $validator->add(
      'name',
      new Uniqueness(
        [
          'field'   => 'name',
          'message' => 'The robot name must be unique',
        ]
      )
    );

    $validator->add(
      "status",
      new InclusionIn(
        [
          'message' => 'Status must be "alive", "dead", or "unknown"',
          'domain' => [
            'alive',
            'dead',
            'unknown',
          ],
        ]
      )
    );

    $validator->add(
      "species",
      new PresenceOf(
        [
          'message' => 'Species is required'
        ]
      )
    );

    $validator->add(
      "gender",
      new InclusionIn(
        [
          'message' => 'Gender must be "female", "male", "genderless", or "unknown"',
          'domain' => [
            'female',
            'male',
            'genderless',
            'unknown',
          ],
        ]
      )
    );

    $validator->add(
      [
        "image",
        "url",
      ],
      new UrlValidator(
        [
          "message" => [
            "image" => "Image must be a url",
            "url" => "Url must be a url"
          ]
        ]
      )
    );

    $validator->add(
      "created",
      new DateValidator(
        [
          "format" => "Y-m-d",
          "message" => "The date is invalid"
        ]
      )
    );

    // Check if any messages have been produced
    if ($this->validationHasFailed() === true) {
      return false;
    }
  }
}