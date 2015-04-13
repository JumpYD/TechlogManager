<?php
namespace Qihoo\ToolBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class JobQueueTestCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName('tool:jobqueue:test')
            ->setDescription('test job queue from command line')
            ->addArgument('tc_name', InputArgument::REQUIRED, 'test case name');
    }

    private $jq;
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tcName = $input->getArgument("tc_name");
        $method = "test_".$tcName;
        $this->jq = $this->getContainer()->get("job_queue");
        $this->$method();
       
    }
    
    private function test_hello()
    {
        $this->jq->enqueue("test", array("job.test", "test_hello"));
    }
    
    private function test_param()
    {
        $this->jq->enqueue("test", array("job.test", "test_param"), array(1, 2));
    }
    
    /*
    //需要停止队列执行
    private function test_enqueue_once()
    {
        $this->jq->enqueueOnce("test", array("job.test", "test_hello"));
        $this->jq->enqueueOnce("test", array("job.test", "test_hello"));
        $this->jq->enqueueOnce("test", array("job.test", "test_hello"));
    }
     * 
     */
    
    //延迟n秒后执行
    private function test_enqueue_in()
    {
        $this->jq->enqueueIn("test", 30, array("job.test", "test_hello"));
    }
    
    //指定时间执行
    private function test_enqueue_at()
    {
        $this->jq->enqueueAt("test", strtotime("2013-06-30 14:11:00"), array("job.test", "test_hello"));
    }
    
    //清空队列
    private function test_clear()
    {
        $this->jq->clearQueue("test_queue");
    }
    
    private function test_queue()
    {
        var_dump($this->jq->getQueue("test"));
    }
    
    private function test_queues()
    {
        var_dump($this->jq->getQueues("test"));
    }
    
    //测试循环(不延迟, 测试最高频度)
    private function test_rec0()
    {
        $this->jq->enqueue("test", array("job.test", "test_rec"), array(0));
    }
    
    //延迟10秒，测试循环服务
    private function test_rec10()
    {
        $this->jq->enqueue("test", array("job.test", "test_rec"), array(10));
    }
    
}
