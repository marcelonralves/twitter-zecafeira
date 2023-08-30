<?php

namespace Src;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Symfony\Component\Dotenv\Dotenv;

class Twitter
{
  private string $baseUrlAPI = 'https://api.twitter.com/2/';
  private string $baseUploadAPI = 'https://upload.twitter.com/1.1/';
  private readonly Dotenv $dotenv;
  private Client $client;
  private HandlerStack $stack;
  private Oauth1 $middleware;
  public function __construct()
  {
    $this->dotenv = new Dotenv();
    $this->dotenv->load(__DIR__ . '/.env');
    
    $this->stack = HandlerStack::create();
    $this->middleware = new Oauth1([
      'consumer_key' => $_ENV['TWITTER_CONSUMER_KEY'],
      'consumer_secret' => $_ENV['TWITTER_CONSUMER_SECRET'],
      'token' => $_ENV['TWITTER_ACCESS_TOKEN'],
      'token_secret' => $_ENV['TWITTER_ACCESS_TOKEN_SECRET'],
      'signature_method' => 'HMAC-SHA1'
    ]);
    $this->stack->push($this->middleware);
  }

  public function postTweet(): void
  {
    $mediaID = $this->postMedia();

    $this->stack->push($this->middleware);
    $this->client = new Client([
      'base_uri' => $this->baseUrlAPI,
      'handler' => $this->stack,
      'auth' => 'oauth'
    ]);
    
    $this->client->post('tweets', [
      'json' => [
        'text' => 'AVISO: Hoje é Zeca-feira',
        'media' => [
          'media_ids' => [$mediaID]
        ]
      ]
    ]);
  }

  public function postMedia(): string
  {
    $this->client = new Client([
      'base_uri' => $this->baseUploadAPI,
      'handler' => $this->stack,
      'auth' => 'oauth'
    ]);

    $response = $this->client->post($this->baseUploadAPI . 'media/upload.json', [
      'form_params' => [
        'media' => base64_encode(file_get_contents(__DIR__ . '/zeca-feira.png'))
      ]
    ]);

    $body = json_decode($response->getBody());
    return $body->media_id_string;
  }
}