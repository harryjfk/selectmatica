<?php
namespace Store\StoreBundle\Command;

use Store\StoreBundle\Controller\ProductoController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncronizeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('rest:sync')
            ->setDescription('Sincronizar productos');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Sincronizando productos');

        $controller = new ProductoController();
        $controller->Syncronize($controller);
        $output->writeln('Sincronización terminada');

     /*   $m = $this->get
        $name = $input->getArgument('nombre');
        if ($name) {
            $text = 'Hola '.$name;
        } else {
            $text = 'Hola';
        }

        if ($input->getOption('gritar')) {
            $text = strtoupper($text);
        }

        $output->writeln($text);*/
    }
}