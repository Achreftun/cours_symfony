<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class AdresseEmailService
{
    public function __construct(private LoggerInterface $logger, private string $extension)
    {
    }
    public function generateEmailFromNomAndPrenom($nom, $prenom)
    {
        $email = "$prenom.$nom@symfony." . $this->extension;
        //     $email = "$prenom.$nom@symfony.com";
        $this->logger->info($email);
        return $email;
    }
}