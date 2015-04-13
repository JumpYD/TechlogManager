<?php
namespace Qihoo\ToolBundle\Tests\Job;
use Symfony\Component\DependencyInjection\ContainerInterface;
class JobTest {
    private $container;
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    //测试简单调用
    public function test_hello() {
        file_put_contents("/tmp/jobtest.txt", "[".date("Y-m-d H:i:s")."] Hello world!\n", FILE_APPEND);
    }
    
    //测试服务参数
    public function test_param($i, $j) {
        file_put_contents("/tmp/jobtest_param.txt", "[".date("Y-m-d H:i:s")."]".($i*10 + $j+1+12000)."\n", FILE_APPEND);
    }
    
    //测试自身的循环调用（频度测试）, $t表示延迟时间
    public function test_rec($t) {
        file_put_contents("/tmp/jobtest_rec.txt", "[".date("Y-m-d H:i:s")."] coming!\n", FILE_APPEND);
        $jq = $this->container->get("job_queue");
        if ($t == 0) {
            $jq->enqueue("test", array("job.test", "test_rec"), array($t));
        } else {
            $jq->enqueueIn("test", $t, array("job.test", "test_rec"), array($t));
        }
    }
    
}
