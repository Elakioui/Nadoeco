<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17/03/15
 * Time: 15:35
 */
namespace Nadoeco\NadoecoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class FactureCommand extends ContainerAwareCommand{

    protected function configure(){

        $this->setName('nadoeco:facture');
        $this->setDescription('generation de la facture');
        $this->addArgument('date',InputArgument::OPTIONAL,'date pour laquelle vous souhaitez récupérer la facture ');

    }
    protected function execute(InputInterface $input, OutputInterface $output){
        $date    = new \DateTime();
        $em      = $this->getContainer()->get('doctrine')->getManager();
        $factures = $em->getRepository('NadoecoNadoecoBundle:Commandes')->byDateCommande($input->getArgument('date'));
        $output->writeln(count($factures).'facture(s) trouvés.');
        if(count($factures) > 0){
            $dir = $date->format('d-m-Y h:i:s');
            mkdir('facturation/'.$dir);
            foreach($factures as $facture){
                $this->getContainer()->get('setNewFacture')->facture($facture)->Output('facturation/'.$dir.'/facture'.$facture->getReference().'.pdf','F');
            }
        }




    }
}
