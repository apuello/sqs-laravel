<?php

namespace App\Helpers;

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

class ProcessMessageHelper
{
    protected $queueUrl;
    protected $client;

    function __construct(){
      $this->queueUrl = env("SQS_PREFIX") . "/" . env("SQS_QUEUE");

      $this->client = new SqsClient([
        'profile' => 'default',
        'region' => env("AWS_DEFAULT_REGION"),
        'version' => '2012-11-05'
      ]);
    }
    public function handle()
    {
      try {
        $result = $this->client->receiveMessage(array(
            'AttributeNames' => ['SentTimestamp'],
            'MaxNumberOfMessages' => 1,
            'MessageAttributeNames' => ['All'],
            'QueueUrl' => $this->queueUrl, // REQUIRED
            'WaitTimeSeconds' => 0,
        ));
        if (count($result->get('Messages')) > 0) {
            var_dump($result->get('Messages')[0]);
            $result = $this->client->deleteMessage([
                'QueueUrl' => $this->queueUrl, // REQUIRED
                'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
            ]);
        } else {
            echo "No messages in queue. \n";
        }
      } catch (AwsException $e) {
        // output error message if fails
        error_log($e->getMessage());
      }
    }
}
