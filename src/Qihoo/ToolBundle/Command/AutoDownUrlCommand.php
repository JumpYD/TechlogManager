<?php
namespace Qihoo\ToolBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Qihoo\ToolBundle\Entity\AutoDownUrl;
use Component\Util\CurlUtil;

/**
 */
class AutoDownUrlCommand extends ContainerAwareCommand {
    protected function configure()
    {
		$this->setName('cron:autodownurl')->setDescription('auto download url from dev center');
    }

    private function log($type, $msg) {
    }

    private function logInfo($msg) {
    }

    private function logError($msg) {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }

    //下载url
    private function downloadUrl($url, $saveDir) {
    }

    private function parseMd5($url) {
    }

    private function checkMd5($saveFile, $url) {
    }

    private function upload($saveFile, $remoteDir) {
    }
    
    private function reconnect() {
    }

    //处理某个下载对象
    private function process($em, $urlObj)
    {
    }

}
