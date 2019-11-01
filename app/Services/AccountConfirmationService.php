<?php

namespace App\Services;

use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use App\Utils\SendWithTemplate;
use Mailjet\Resources;

class AccountConfirmationService
{
    protected $mjV31;

    use SendWithTemplate;

    /**
     * Create the event listener.
     * @param MailTransactionalContract $mjV31
     * @param Confirmation $template
     */
    public function __construct( MailTransactionalContract $mjV31)
    {
        $this->mjV31 = $mjV31;
    }

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new Confirmation($data));
        print_r($res);exit;
    }

}