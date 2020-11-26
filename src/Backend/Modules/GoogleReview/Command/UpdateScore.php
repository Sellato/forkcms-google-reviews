<?php

namespace Backend\Modules\GoogleReview\Command;

use Common\ModulesSettings;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateScore extends Command
{
    protected static $defaultName = 'google-review:update-score';

    private $logger;
    private $settings;

    public function __construct(LoggerInterface $logger, ModulesSettings $settings)
    {
        $this->logger = $logger;
        $this->settings = $settings;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Fetch current review score for the given business');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $placeId = $this->settings->get('GoogleReview', 'place_id');
        $apiKey = $this->settings->get('GoogleReview', 'api_key');

        if (!$placeId || !$apiKey) {
            $this->logger->error('No place id or api key set.');
            return;
        }

        $client = new Client([
            'base_uri' => 'https://maps.googleapis.com/',
        ]);

        try {
            $response = $client->get('maps/api/place/details/json', [
                'query' => [
                    'key' => $apiKey,
                    'place_id' => $placeId,
                ],
            ]);
        } catch (ServerException $e) {
            $this->logger->error('[GoogleReview] Server exception: ' . $e->getMessage());
            return;
        } catch (ClientException $e) {
            $this->logger->error('[GoogleReview] Client exception: ' . $e->getResponse()->getBody());
            return;
        }

        $data = json_decode($response->getBody());

        if ($data->status != 'OK') {
            $this->logger->error('Something went wrong: (' . $data->status . ') ' . $data->error_message);

            return;
        }

        $reviewCount = $data->result->user_ratings_total;
        $score = number_format($data->result->rating, 1);

        $this->settings->set('GoogleReview', 'review_count', $reviewCount);
        $this->settings->set('GoogleReview', 'score', $score);

        $output->writeln('Review count: ' . $reviewCount);
        $output->writeln('Rating: ' . $score);
    }
}
