<?php
namespace app\index\controller;

use Pheanstalk\Pheanstalk;

class Index
{
    public function index()
    {


        $pheanstalk = new Pheanstalk('182.61.35.43');

        // ----------------------------------------
        // producer (queues jobs)

        $pheanstalk
            ->useTube('testtube')
            ->put("job payload goes here\n");

        // ----------------------------------------
        // worker (performs jobs)

        $job = $pheanstalk
            ->watch('testtube')
            ->ignore('default')
            ->reserve();

        echo $job->getData();

        $pheanstalk->delete($job);

        // ----------------------------------------
        // check server availability

        $pheanstalk->getConnection()->isServiceListening(); // true or false

    }
}
