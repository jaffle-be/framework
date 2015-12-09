<?php namespace App\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailJob extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $root_url;

    protected $email_from;

    protected $email_from_name;

    protected $email_to;

    public function __construct()
    {
        $this->root_url = config('app.url');
        $this->email_from = config('mail.from.address');
        $this->email_from_name = config('mail.from.name');
        parent::__construct();
    }

    protected function baseData()
    {
        return array_merge(parent::baseData(), [
            'email_from' => $this->email_from,
            'email_from_name' => $this->email_from_name,
            'root_url' => $this->root_url,
        ]);
    }

}