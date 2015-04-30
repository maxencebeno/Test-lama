<?php

namespace LamaFrance\ArticleBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LamaFrance\ArticleBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of ImportArticleCommand
 *
 * @author mbeno
 */
class ImportArticleCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('article:import')
                ->setDescription('Importer les articles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        set_time_limit(0);
        ini_set('memory_limit', '5120M');
        if (($handle = fopen('C:\Users\awils\Downloads\guide.csv', "r")) !== FALSE) {

            $i = 0;
            $em = $this->getContainer()->get('doctrine')->getManager();
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $data = array_map('utf8_encode', $data);
                $data = array_map('trim', $data);


                $article = new Article();

                $article->setMarque(trim($data[0]));
                $article->setModele(trim($data[1]));
                $article->setOem(trim($data[2]));
                $article->setCodelama(trim($data[3]));
                $article->setCapacite(trim($data[4]));
                $article->setEquivalencelama(trim($data[5]));
                $article->setCouleur(trim($data[6]));
                $article->setDescription(trim($data[7]));
                $article->setType(trim($data[8]));

                $em->persist($article);

                $i++;
                echo $i . "\n";
            }

            $em->flush();
        }
        fclose($handle);
    }

}
